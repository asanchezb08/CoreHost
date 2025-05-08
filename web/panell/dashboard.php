<?php
// Requereix el gestor de sessions
require_once __DIR__ . '/../includes/session_handler.php';
// Requereix la connexió a la base de dades
require_once 'conexion.php';

// Comprova si l'usuari està autenticat
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit();
}

$cliente_id = $_SESSION['cliente_id'];

// Carrega els plans de recursos
$stmt_planes = $conn->query("SELECT * FROM planes_recursos WHERE activo = 1");
$planes = $stmt_planes->fetchAll(PDO::FETCH_ASSOC);

// Carrega els trams de disc
$stmt_discos = $conn->query("SELECT * FROM tramos_disco WHERE activo = 1");
$discos = $stmt_discos->fetchAll(PDO::FETCH_ASSOC);

try {
    // Obté només les VMs completades
    $stmt = $conn->prepare("SELECT * FROM vms WHERE cliente_id = :cliente_id AND estado = 'completado' ORDER BY fecha_creacion DESC");
    $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
    $stmt->execute();
    $vms_completadas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Compta les VMs pendents
    $stmt_pendientes = $conn->prepare("SELECT COUNT(*) FROM vms WHERE cliente_id = :cliente_id AND estado = 'pendiente'");
    $stmt_pendientes->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
    $stmt_pendientes->execute();
    $vms_pendientes_count = $stmt_pendientes->fetchColumn();
} catch (PDOException $e) {
    die("Error al obtenir les VMs: " . $e->getMessage());
}

// Funció d'ajuda per evitar errors de htmlspecialchars amb valors nulls
function esc($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
?>
