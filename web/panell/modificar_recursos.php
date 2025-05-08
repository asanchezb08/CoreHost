<?php

require_once __DIR__ . '/../includes/session_handler.php';
require_once 'conexion.php';

// Comprovar si l'usuari està autenticat
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit();
}

$cliente_id = $_SESSION['cliente_id'];
$vmid = $_POST['vmid'] ?? null;
$plan_id = $_POST['plan_id'] ?? null;
$disco_id = $_POST['disco_id'] ?? null;

// Comprovar si falten dades necessàries
if (!$vmid || !$plan_id || !$disco_id) {
    header("Location: dashboard.php?error=missing_data");
    exit();
}

try {
    // Verificar que la VM pertany al client
    $stmt = $conn->prepare("SELECT * FROM vms WHERE id = :vmid AND cliente_id = :cliente_id");
    $stmt->execute([':vmid' => $vmid, ':cliente_id' => $cliente_id]);

    // Si no hi ha coincidències, redirigir amb error d'autorització
    if ($stmt->rowCount() === 0) {
        header("Location: dashboard.php?error=unauthorized");
        exit();
    }

    // Obtenir la informació actual de la VM i el seu disc
    $vm_actual = $stmt->fetch(PDO::FETCH_ASSOC);
    $disco_actual_gb = $vm_actual['disco_secundario'];

    // Obtenir les dades del pla seleccionat
    $stmt_plan = $conn->prepare("SELECT * FROM planes_recursos WHERE id = :plan_id AND activo = 1");
    $stmt_plan->execute([':plan_id' => $plan_id]);
    $plan = $stmt_plan->fetch(PDO::FETCH_ASSOC);

    // Obtenir les dades del tram de disc seleccionat
    $stmt_disco = $conn->prepare("SELECT * FROM tramos_disco WHERE id = :disco_id AND activo = 1");
    $stmt_disco->execute([':disco_id' => $disco_id]);
    $disco = $stmt_disco->fetch(PDO::FETCH_ASSOC);

    // Comprovar si el pla o el tram de disc no són vàlids
    if (!$plan || !$disco) {
        header("Location: dashboard.php?error=invalid_selection");
        exit();
    }

    // Validar que el nou disc no sigui més petit que l'actual
    if ($disco['cantidad_gb'] < $disco_actual_gb) {
        header("Location: dashboard.php?error=disco_reduccion_no_permitida");
        exit();
    }

    // Actualitzar els recursos i l'estat de la VM
    $update = $conn->prepare("
        UPDATE vms SET
            cores = :cores,
            memory = :memory,
            plan_id = :plan_id,
            disco_secundario = :disco,
            disco_secundario_id = :disco_id,
            estado = 'esperando_modificacion',
            fecha_modificacion = NOW()
        WHERE id = :vmid
    ");
    $update->execute([
        ':cores' => $plan['cores'],
        ':memory' => $plan['ram'],
        ':plan_id' => $plan_id,
        ':disco' => $disco['cantidad_gb'],
        ':disco_id' => $disco_id,
        ':vmid' => $vmid
    ]);

    // Redirigir amb èxit si tot s'ha actualitzat correctament
    header("Location: dashboard.php?success=recursos_actualizados");
    exit();
} catch (PDOException $e) {
    // Gestionar errors de base de dades
    header("Location: dashboard.php?error=database_error");
    exit();
}
?>
