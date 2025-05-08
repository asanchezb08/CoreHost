<?php

require_once __DIR__ . '/../includes/session_handler.php';

// Neteja totes les variables de sessió
$_SESSION = [];
session_destroy();

// Elimina la cookie si existeix
if (isset($_COOKIE['cliente_id'])) {
    setcookie("cliente_id", "", time() - 3600, "/");
}

// Redirigeix a la pàgina de login
header("Location: login.php");
exit();
