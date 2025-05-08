<?php

require_once __DIR__ . '/../includes/session_handler.php';
require_once 'conexion.php';

// Comprovar si l'usuari està autenticat
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit();
}

$cliente_id = $_SESSION['cliente_id'];

// Validar que s'hagin enviat les dues contrasenyes
if (empty($_POST['nueva_password']) || empty($_POST['confirmar_password'])) {
    header("Location: perfil.php?error=password_empty");
    exit();
}

$nueva = $_POST['nueva_password'];
$confirmar = $_POST['confirmar_password'];

// Verificar que les contrasenyes coincideixin
if ($nueva !== $confirmar) {
    header("Location: perfil.php?error=password_mismatch");
    exit();
}

// Hashear la nova contrasenya
$hash = password_hash($nueva, PASSWORD_DEFAULT);

try {
    // Actualitzar la contrasenya a la base de dades
    $stmt = $conn->prepare("UPDATE clientes SET password_hash = :hash WHERE id = :id");
    $stmt->bindParam(':hash', $hash, PDO::PARAM_STR);
    $stmt->bindParam(':id', $cliente_id, PDO::PARAM_INT);
    $stmt->execute();

    // Redirigir amb èxit
    header("Location: perfil.php?success=password_cambiada");
    exit();
} catch (PDOException $e) {
    // Redirigir en cas d'error de base de dades
    header("Location: perfil.php?error=database_error");
    exit();
}
?>
