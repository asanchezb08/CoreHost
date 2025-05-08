<?php
require_once __DIR__ . '/../includes/session_handler.php';

require_once 'conexion.php';

if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit();
}

// Configuració de l'API de Proxmox
$api_host = "172.16.56.100";
$api_user = "API-Admin@pam";
$api_token_id = "apiadmin";
$api_token_secret = "de9fbbb0-1443-4572-8fc9-5c210bc74cee";
$proxmox_node = "pve";

// Verificar si s'ha enviat el formulari
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['vmid']) && isset($_POST['accion'])) {
    $cliente_id = $_SESSION['cliente_id'];
    $vm_id = filter_var($_POST['vmid'], FILTER_SANITIZE_NUMBER_INT);
    $accion = $_POST['accion']; // Sense filtres per evitar problemes

    // Verificar que la vm és del client actual
    try {
        $stmt = $conn->prepare("SELECT * FROM vms WHERE id = :vm_id AND cliente_id = :cliente_id");
        $stmt->bindParam(':vm_id', $vm_id, PDO::PARAM_INT);
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->execute();
        $vm = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$vm) {
            header("Location: dashboard.php?error=unauthorized");
            exit();
        }

        // Obtenir el vmid de la VM (ID en Proxmox)
        $proxmox_vmid = $vm['vmid'];

        if (!$proxmox_vmid) {
            header("Location: dashboard.php?error=missing_data&msg=No es va trobar l'ID de VM a Proxmox");
            exit();
        }

        // Realitzar acció directament amb l'API de Proxmox
        switch ($accion) {
            case 'iniciar':
                // Acció directa - envia una ordre al node de Proxmox
                $resultado = accionDirectaProxmox($proxmox_vmid, 'start');
                break;
            case 'parar':
                $resultado = accionDirectaProxmox($proxmox_vmid, 'stop');
                break;
            case 'reiniciar':
                $resultado = accionDirectaProxmox($proxmox_vmid, 'reboot');
                break;
            case 'eliminar':
                try {
                    // Iniciar transacció per assegurar que totes les operacions es completen correctament
                    $conn->beginTransaction();

                    // Obtenir dades de la VM abans d'eliminar-la
                    $stmt_select = $conn->prepare("SELECT vmid, ip_publica, ip_privada FROM vms WHERE id = :vm_id");
                    $stmt_select->bindParam(':vm_id', $vm_id, PDO::PARAM_INT);
                    $stmt_select->execute();
                    $vm_data = $stmt_select->fetch(PDO::FETCH_ASSOC);

                    if (!$vm_data) {
                        throw new Exception("No es va trobar la VM amb ID: $vm_id");
                    }

                    // Guardar el VMID per a les operacions Proxmox
                    $proxmox_vmid = $vm_data['vmid'];

                    // Aturar la VM a Proxmox abans d'eliminar-la
                    $stop_result = accionDirectaProxmox($proxmox_vmid, 'stop');
                    if (!$stop_result['success']) {
                        throw new Exception("Error en aturar la VM: " . $stop_result['message']);
                    }

                    // Esperar un moment per assegurar que la VM s'ha aturat correctament
                    sleep(5);

                    // Eliminar la VM de Proxmox
                    $delete_result = accionDirectaProxmox($proxmox_vmid, 'delete');
                    if (!$delete_result['success']) {
                        throw new Exception("Error en eliminar la VM de Proxmox: " . $delete_result['message']);
                    }

                    // Alliberar les IPs a la taula xarxes
                    if (!empty($vm_data['ip_publica'])) {
                        $stmt_ip_pub = $conn->prepare("UPDATE redes SET en_uso = 0 WHERE ip = :ip_publica");
                        $stmt_ip_pub->bindParam(':ip_publica', $vm_data['ip_publica'], PDO::PARAM_STR);
                        $result_pub = $stmt_ip_pub->execute();

                        if (!$result_pub) {
                            throw new Exception("Error en alliberar la IP pública: " . implode(", ", $stmt_ip_pub->errorInfo()));
                        }
                    }

                    if (!empty($vm_data['ip_privada'])) {
                        $stmt_ip_priv = $conn->prepare("UPDATE redes SET en_uso = 0 WHERE ip = :ip_privada");
                        $stmt_ip_priv->bindParam(':ip_privada', $vm_data['ip_privada'], PDO::PARAM_STR);
                        $result_priv = $stmt_ip_priv->execute();

                        if (!$result_priv) {
                            throw new Exception("Error en alliberar la IP privada: " . implode(", ", $stmt_ip_priv->errorInfo()));
                        }
                    }

                    // Eliminar primer els registres relacionats a la taula acciones_vm_log
                    $stmt_delete_logs = $conn->prepare("DELETE FROM acciones_vm_log WHERE vm_id = :vm_id");
                    $stmt_delete_logs->bindParam(':vm_id', $vm_id, PDO::PARAM_INT);
                    $result_delete_logs = $stmt_delete_logs->execute();

                    if (!$result_delete_logs) {
                        throw new Exception("Error en eliminar els logs de la VM: " . implode(", ", $stmt_delete_logs->errorInfo()));
                    }

                    // Eliminar registres relacionats a la taula solicitudes_wordpress
                    $vm_hostname = $vm['hostname'];
                    if ($vm_hostname) {
                        $stmt_delete_wordpress = $conn->prepare("DELETE FROM solicitudes_wordpress WHERE hostname = :hostname");
                        $stmt_delete_wordpress->bindParam(':hostname', $vm_hostname, PDO::PARAM_STR);
                        $result_delete_wordpress = $stmt_delete_wordpress->execute();

                        if (!$result_delete_wordpress) {
                            throw new Exception("Error en eliminar les sol·licituds de WordPress associades: " . implode(", ", $stmt_delete_wordpress->errorInfo()));
                        }
                    }

                    // Eliminar la VM de la base de dades
                    $stmt_delete = $conn->prepare("DELETE FROM vms WHERE id = :vm_id");
                    $stmt_delete->bindParam(':vm_id', $vm_id, PDO::PARAM_INT);
                    $result_delete = $stmt_delete->execute();

                    if (!$result_delete) {
                        throw new Exception("Error en eliminar la VM de la base de dades: " . implode(", ", $stmt_delete->errorInfo()));
                    }

                    if ($stmt_delete->rowCount() == 0) {
                        throw new Exception("No es va eliminar cap registre de la base de dades. Possible ID invàlid: $vm_id");
                    }

                    // Si arribem fins aquí, totes les operacions han estat exitoses
                    // Confirmar la transacció
                    $conn->commit();

                    // Redirigir amb missatge d'èxit
                    header("Location: dashboard.php?success=vm_eliminada_completament");
                    exit();

                } catch (Exception $e) {
                    // Si alguna cosa falla, revertir els canvis de la base de dades
                    if ($conn->inTransaction()) {
                        $conn->rollBack();
                    }

                    // Aquí el problema és que la VM podria haver estat eliminada de Proxmox però no de la base de dades
                    // Podem proporcionar un missatge detallat perquè l'administrador pugui revisar i corregir manualment
                    $error_message = $e->getMessage();
                    $is_proxmox_deleted = false;

                    // Comprovem si l'error va ocórrer després de l'eliminació de Proxmox
                    if (strpos($error_message, "Error en alliberar") !== false ||
                        strpos($error_message, "Error en eliminar") !== false) {
                        $is_proxmox_deleted = true;
                    }

                    if ($is_proxmox_deleted) {
                        // Si la VM es va eliminar de Proxmox però no es va completar l'operació a la base de dades,
                        // afegim un missatge especial per a l'administrador
                        $error_message = "IMPORTANT: La VM va ser eliminada de Proxmox però no es va actualitzar la base de dades. " .
                                        "És necessari verificar manualment i corregir els registres. Detalls: " . $error_message;
                    }

                    header("Location: dashboard.php?error=error_al_eliminar&mensaje=" . urlencode($error_message));
                    exit();
                }
                break;
            default:
                header("Location: dashboard.php?error=invalid_action");
                exit();
        }

        if (isset($resultado) && $resultado['success']) {
            header("Location: dashboard.php?success=accion_" . $accion);
        } else if (isset($resultado)) {
            header("Location: dashboard.php?error=proxmox_error&message=" . urlencode($resultado['message']));
        }

    } catch (PDOException $e) {
        header("Location: dashboard.php?error=database_error&msg=" . urlencode($e->getMessage()));
        exit();
    }

} else {
    header("Location: dashboard.php");
    exit();
}

/**
 * Executa una acció a Proxmox mitjançant un enfocament diferent
 * Usant l'endpoint /api2/json/nodes/{node}/qemu/{vmid}/status/{action}
 * o l'endpoint /api2/json/nodes/{node}/qemu/{vmid} per eliminar
 *
 * @param int $vmid ID de Proxmox de la màquina virtual
 * @param string $action Acció a executar (start, stop, reboot, delete)
 * @return array Resultat de l'operació
 */
function accionDirectaProxmox($vmid, $action) {
    global $api_host, $api_user, $api_token_id, $api_token_secret, $proxmox_node;

    // Construir la URL segons l'acció
    $url = "";
    $is_delete = false;

    if ($action === 'delete') {
        $url = "https://{$api_host}:8006/api2/json/nodes/{$proxmox_node}/qemu/{$vmid}";
        $is_delete = true;
    } else {
        $url = "https://{$api_host}:8006/api2/json/nodes/{$proxmox_node}/qemu/{$vmid}/status/{$action}";
    }

    // Inicialitzar cURL
    $ch = curl_init();

    // Configurar opcions de cURL
    curl_setopt($ch, CURLOPT_URL, $url);

    if ($is_delete) {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    } else {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "");  // POST buit però necessari
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: PVEAPIToken={$api_user}!{$api_token_id}={$api_token_secret}",
        "Content-Type: application/x-www-form-urlencoded",
        "Accept: application/json"
    ]);

    // Executar la sol·licitud
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);

    // Tancar la connexió cURL
    curl_close($ch);

    // Verificar si hi va haver errors
    if ($curl_error) {
        return ['success' => false, 'message' => "Error cURL: {$curl_error}"];
    }

    // Decodificar la resposta JSON
    $result = json_decode($response, true);

    // Verificar el codi d'estat HTTP
    if ($http_code >= 200 && $http_code < 300) {
        return ['success' => true, 'data' => $result];
    } else {
        $error_msg = isset($result['errors']) ? implode(', ', $result['errors']) : 'Error desconegut';
        return ['success' => false, 'message' => "Error API ({$http_code}): {$error_msg}, URL: {$url}"];
    }
}
?>
