<?php

require_once __DIR__ . '/../includes/session_handler.php';

// Eliminar les dades temporals de la sessió
unset($_SESSION['temp_plan']); // Elimina el pla temporal
unset($_SESSION['temp_disco']); // Elimina el disc temporal
unset($_SESSION['temp_plantilla']); // Elimina la plantilla temporal
unset($_SESSION['vm_datos']); // Elimina les dades de la màquina virtual

// Respondre amb èxit
header('Content-Type: application/json');
echo json_encode(['success' => true]); // Retorna una resposta JSON indicant èxit
?>
