<?php
// Configuració del servidor de base de dades
$servername = "172.16.56.145"; // Adreça IP del servidor
$username = "hostinguser"; // Nom d'usuari per accedir a la base de dades
$password = "proyecto"; // Contrasenya per accedir a la base de dades
$dbname = "hosting_inventari"; // Nom de la base de dades

try {
    // Crear una connexió PDO amb la base de dades
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Configurar el mode d'error de PDO per llançar excepcions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Si hi ha un error de connexió, mostrar el missatge d'error i aturar l'execució
    die("Error de connexió: " . $e->getMessage());
}
?>
