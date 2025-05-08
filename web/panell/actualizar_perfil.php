<?php

// Inclou el gestor de sessions
require_once __DIR__ . '/../includes/session_handler.php';
// Inclou la connexió a la base de dades
require_once 'conexion.php';

// Comprova si l'usuari està autenticat
if (!isset($_SESSION['cliente_id'])) {
    // Redirigeix a la pàgina de login si no està autenticat
    header("Location: login.php");
    exit();
}

$cliente_id = $_SESSION['cliente_id'];

// Obté les dades del formulari
$nombre = $_POST['nombre'] ?? null;
$email = $_POST['email'] ?? null;
$telefono = $_POST['telefono'] ?? null;
$empresa = $_POST['empresa'] ?? null;

// Comprova si els camps obligatoris estan plens
if (!$nombre || !$email) {
    // Redirigeix a la pàgina de perfil amb un error si falten camps
    header("Location: perfil.php?error=missing_fields");
    exit();
}

try {
    // Prepara la consulta SQL per actualitzar les dades del client
    $stmt = $conn->prepare("UPDATE clientes SET nombre = :nombre, email = :email, telefono = :telefono, empresa = :empresa WHERE id = :id");
    $stmt->execute([
        ':nombre' => $nombre,
        ':email' => $email,
        ':telefono' => $telefono,
        ':empresa' => $empresa,
        ':id' => $cliente_id
    ]);

    // Actualitza el nom a la sessió si es mostra en altres llocs
    $_SESSION['cliente_nombre'] = $nombre;

    // Redirigeix a la pàgina de perfil amb un missatge d'èxit
    header("Location: perfil.php?success=perfil_actualizado");
    exit();

} catch (PDOException $e) {
    // Redirigeix a la pàgina de perfil amb un error de base de dades
    header("Location: perfil.php?error=database_error");
    exit();
}
?>
