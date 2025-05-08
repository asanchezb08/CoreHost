<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Validació mínima dels camps obligatoris
    $campos_obligatorios = ['hostname', 'db_name', 'site_url', 'site_title', 'admin_user', 'admin_pass', 'admin_email'];
    foreach ($campos_obligatorios as $campo) {
        // Comprova si algun camp obligatori està buit
        if (empty($_POST[$campo])) {
            die("Falta el camp obligatori: $campo");
        }
    }

    // Prepara la consulta SQL per inserir les dades a la base de dades
    $stmt = $conn->prepare("INSERT INTO solicitudes_wordpress (
        hostname, db_name, db_prefix, site_url, site_title,
        admin_user, admin_pass, admin_email, language, timezone, estado
    ) VALUES (
        :hostname, :db_name, :db_prefix, :site_url, :site_title,
        :admin_user, :admin_pass, :admin_email, :language, :timezone, 'pendiente'
    )");

    // Executa la consulta amb els valors proporcionats
    $stmt->execute([
        'hostname'     => $_POST['hostname'],
        'db_name'      => $_POST['db_name'],
        'db_prefix'    => $_POST['db_prefix'] ?: 'wp_', // Valor per defecte si no es proporciona
        'site_url'     => $_POST['site_url'],
        'site_title'   => $_POST['site_title'],
        'admin_user'   => $_POST['admin_user'],
        'admin_pass'   => $_POST['admin_pass'],
        'admin_email'  => $_POST['admin_email'],
        'language'     => $_POST['language'] ?: 'es_ES', // Valor per defecte si no es proporciona
        'timezone'     => $_POST['timezone'] ?: 'Europe/Madrid', // Valor per defecte si no es proporciona
    ]);

    // Redirigeix a la pàgina del tauler de control
    header("Location: dashboard.php");
    exit();
} else {
    // Mostra un missatge si el mètode no és POST
    echo "Mètode no permès.";
}
