<?php

require_once __DIR__ . '/../includes/session_handler.php';
require_once 'conexion.php';

// Verificar que l'usuari estigui autenticat
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit();
}

$cliente_id = $_SESSION['cliente_id'];

// Verificar que s'han rebut les dades necessàries
if (!isset($_POST['vmid']) || !isset($_POST['php_version'])) {
    header("Location: dashboard.php?error=missing_data");
    exit();
}

$vmid = $_POST['vmid'];
$php_version = $_POST['php_version'];

// Validar que la versió de PHP és una de les permeses
$versiones_permitidas = ['5.6', '7.4', '8.1'];
if (!in_array($php_version, $versiones_permitidas)) {
    header("Location: dashboard.php?error=invalid_php_version");
    exit();
}

try {
    // Verificar que la VM pertany al client (usant la columna id, no vmid)
    $stmt = $conn->prepare("SELECT * FROM vms WHERE id = :vmid AND cliente_id = :cliente_id");
    $stmt->bindParam(':vmid', $vmid, PDO::PARAM_INT);
    $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        // La VM no pertany a aquest client
        header("Location: dashboard.php?error=unauthorized");
        exit();
    }

    // Actualitzar la versió de PHP i l'estat de la VM
    $update = $conn->prepare("UPDATE vms SET php = :php_version, estado = 'cambio_php' WHERE id = :vmid");
    $update->bindParam(':php_version', $php_version, PDO::PARAM_STR);
    $update->bindParam(':vmid', $vmid, PDO::PARAM_INT);
    $update->execute();

    // Redirigir de tornada a la pàgina principal amb un missatge d'èxit
    header("Location: dashboard.php?success=php_updated");
    exit();

} catch (PDOException $e) {
    // Error en actualitzar la versió de PHP
    header("Location: dashboard.php?error=database_error");
    exit();
}
