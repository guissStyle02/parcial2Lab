<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');
include 'conexion.php';

$link = conectaDB();

$sql = "SELECT id_documento, no_oficio, fecha, asunto, remitente, destinatario, estatus, archivo_pdf, fecha_registro FROM documentos ORDER BY fecha_registro DESC";
$resultado = mysqli_query($link, $sql);

$documentos = [];

if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $documentos[] = $fila;
    }
}

mysqli_close($link);
echo json_encode($documentos);
?>