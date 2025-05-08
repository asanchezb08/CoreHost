<?php

require_once __DIR__ . '/../includes/session_handler.php';
require_once 'conexion.php';

// Iniciar el buffer de sortida per evitar "headers already sent"
ob_start();

// Netejar les dades temporals de la sessió si no estem en el procés de confirmació
if (!isset($_POST['confirmar']) && (!isset($_GET['mantener_temp']) || $_GET['mantener_temp'] != '1')) {
    unset($_SESSION['temp_plan']);
    unset($_SESSION['temp_disco']);
    unset($_SESSION['temp_plantilla']);
}

// Comprovar si l'usuari està autenticat
if (!isset($_SESSION['cliente_id'])) {
    header('Location: login.php');
    exit;
}

$mensaje = '';
$tipo_mensaje = '';

// Processar la sol·licitud si s'ha enviat el formulari
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = $_SESSION['cliente_id'];
    $plan_id = $_POST['plan_id'] ?? null;
    $disco_id = $_POST['disco_secundario_id'] ?? null;
    $plantilla = $_POST['plantilla_base'] ?? 'Ubuntu';
    $confirmado = isset($_POST['confirmar']) ? true : false;

    if ($plan_id && $disco_id) {
        // Si és la primera vegada que s'envia el formulari i no està confirmat
        if (!$confirmado) {
            try {
                // Obtenir les dades del pla i disc per mostrar-les en la confirmació
                $stmtPlan = $conn->prepare("SELECT id, nombre, cores, ram, precio FROM planes_recursos WHERE id = ?");
                $stmtPlan->execute([$plan_id]);
                $plan = $stmtPlan->fetch(PDO::FETCH_ASSOC);

                $stmtDisco = $conn->prepare("SELECT id, cantidad_gb, precio FROM tramos_disco WHERE id = ?");
                $stmtDisco->execute([$disco_id]);
                $disco = $stmtDisco->fetch(PDO::FETCH_ASSOC);
                
                if ($plan && $disco) {
                    // Guardar dades en la sessió per a la confirmació
                    $_SESSION['temp_plan'] = $plan;
                    $_SESSION['temp_disco'] = $disco;
                    $_SESSION['temp_plantilla'] = $plantilla;
                    
                    // No processar la creació encara, mostrar confirmació
                } else {
                    $mensaje = 'Error en obtenir les dades del pla o disc.';
                    $tipo_mensaje = 'error';
                }
            } catch (PDOException $e) {
                $mensaje = 'Error en processar la sol·licitud: ' . $e->getMessage();
                $tipo_mensaje = 'error';
            }
        } else {
            // Si ja està confirmat, procedir amb la creació
            try {
                $stmtPlan = $conn->prepare("SELECT cores, ram, precio FROM planes_recursos WHERE id = ?");
                $stmtPlan->execute([$plan_id]);
                $plan = $stmtPlan->fetch(PDO::FETCH_ASSOC);

                $stmtDisco = $conn->prepare("SELECT cantidad_gb, precio FROM tramos_disco WHERE id = ?");
                $stmtDisco->execute([$disco_id]);
                $disco = $stmtDisco->fetch(PDO::FETCH_ASSOC);

                if ($plan && $disco) {
                    $stmtInsert = $conn->prepare("
                        INSERT INTO vms (cliente_id, estado, cores, memory, php, disco_secundario, plantilla_base, plan_id, disco_secundario_id)
                        VALUES (?, 'pendiente', ?, ?, ?, ?, ?, ?, ?)
                    ");
                    $stmtInsert->execute([
                        $cliente_id,
                        $plan['cores'],
                        $plan['ram'],
                        '8.1',
                        $disco['cantidad_gb'],
                        $plantilla,
                        $plan_id,
                        $disco_id
                    ]);
                    
                    // Guardar dades per a la pàgina de pagament
                    $_SESSION['vm_datos'] = [
                        'plan' => [
                            'id' => $plan_id,
                            'nombre' => isset($plan['nombre']) ? $plan['nombre'] : '',
                            'cores' => $plan['cores'],
                            'ram' => $plan['ram']
                        ],
                        'disco' => $disco,
                        'plantilla' => $plantilla,
                        'precio_plan' => $plan['precio'],
                        'precio_disco' => $disco['precio'],
                        'precio_total' => $plan['precio'] + $disco['precio']
                    ];
                    
                    // Netejar el buffer de sortida per evitar "headers already sent"
                    ob_clean();
                    
                    // Redirigir a la pàgina de pagament
                    header('Location: pagament.php');
                    exit;
                } else {
                    $mensaje = 'Error en obtenir les dades del pla o disc.';
                    $tipo_mensaje = 'error';
                }
            } catch (PDOException $e) {
                $mensaje = 'Error en crear la màquina: ' . $e->getMessage();
                $tipo_mensaje = 'error';
            }
        }
    } else {
        $mensaje = 'Has de seleccionar un pla i un disc.';
        $tipo_mensaje = 'error';
    }
}

// Si hi ha dades en sessió, les recuperem per a la confirmació
$temp_plan = $_SESSION['temp_plan'] ?? null;
$temp_disco = $_SESSION['temp_disco'] ?? null;
$temp_plantilla = $_SESSION['temp_plantilla'] ?? null;

// Si no estem en la confirmació, carregar les dades de plans i discos
if (!$temp_plan && !$temp_disco) {
    $planes = $conn->query("SELECT * FROM planes_recursos WHERE activo = 1")->fetchAll(PDO::FETCH_ASSOC);
    $discos = $conn->query("SELECT * FROM tramos_disco WHERE activo = 1")->fetchAll(PDO::FETCH_ASSOC);
}
?>
