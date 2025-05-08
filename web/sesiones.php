<?php
require_once __DIR__ . '/includes/session_handler.php';

$handler = new MariaDBSessionHandler();
if (session_status() === PHP_SESSION_NONE) {
    session_set_save_handler($handler, true);
    session_start();
}

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>