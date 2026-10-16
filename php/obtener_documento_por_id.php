<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');
include 'conexion.php';

$link = conectaDB();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM documentos WHERE id_documento = $id";
$resultado = mysqli_query($link, $sql);

$documento = null;
if ($resultado && mysqli_num_rows($resultado) > 0) {
    $documento = mysqli_fetch_assoc($resultado);
}

mysqli_close($link);
echo json_encode($documento);
?>