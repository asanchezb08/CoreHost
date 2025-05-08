<?php
require_once 'conexion.php';

// Configuració de l'API del Proxmox
$api_host = "172.16.56.100";
$api_user = "API-Admin@pam";
$api_token_id = "apiadmin";
$api_token_secret = "de9fbbb0-1443-4572-8fc9-5c210bc74cee";
$proxmox_node = "pve";

/**
 * Obté l'estat actual d'una VM al Proxmox
 * 
 * @param int $vmid ID de Proxmox de la máquina virtual
 * @return string Estat de la VM (running, stopped, paused, etc.)
 */
function obtenerEstadoVM($vmid) {
    global $api_host, $api_user, $api_token_id, $api_token_secret, $proxmox_node;
    
    // Si no hi ha vmid, retrona unknown
    if (!$vmid || $vmid <= 0) {
        return 'unknown';
    }
    
    // Construir l'URL
    $url = "https://{$api_host}:8006/api2/json/nodes/{$proxmox_node}/qemu/{$vmid}/status/current";
    
    // Inicializar cURL
    $ch = curl_init();
    
    // Configurar opcions de cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    // Establir l'autenticació mitjançant un token API
    $headers = [
        "Authorization: PVEAPIToken={$api_user}!{$api_token_id}={$api_token_secret}"
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    // Executar la sol·licitud
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    // Tencar la conexión cURL
    curl_close($ch);
    
    // Verificar resposta
    if ($http_code >= 200 && $http_code < 300) {
        $result = json_decode($response, true);
        if (isset($result['data']['status'])) {
            return $result['data']['status'];
        }
    }
    
    // Si no es pot obtenir l'estat, retornar 'unknown'
    return 'unknown';
}

/**
 * Retorna una representació visual de l'estat de la VM
 * 
 * @param string $estado Estat de la VM
 * @return string HTML amb l'estat formatat
 */
function mostrarEstadoVM($estado) {
    switch ($estado) {
        case 'running':
            return '<span class="estado-vm estado-encendido">Encendida</span>';
        case 'stopped':
            return '<span class="estado-vm estado-apagado">Apagada</span>';
        case 'paused':
            return '<span class="estado-vm estado-pausado">Pausada</span>';
        case 'suspended':
            return '<span class="estado-vm estado-suspendido">Suspendida</span>';
        case 'unknown':
            return '<span class="estado-vm estado-desconocido">Estado desconocido</span>';
        default:
            if (strpos($estado, 'stop') !== false) {
                return '<span class="estado-vm estado-deteniendo">Deteniéndose</span>';
            } elseif (strpos($estado, 'start') !== false) {
                return '<span class="estado-vm estado-iniciando">Iniciándose</span>';
            } elseif (strpos($estado, 'reset') !== false) {
                return '<span class="estado-vm estado-reiniciando">Reiniciándose</span>';
            } else {
                return '<span class="estado-vm estado-otro">' . ucfirst($estado) . '</span>';
            }
    }
}
