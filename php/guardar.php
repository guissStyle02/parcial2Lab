<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    

    $conexion = conectaDB();

 
    echo json_encode(['status' => 'error', 'message' => 'Funcionalidad pendiente por el equipo.']);
}
?>