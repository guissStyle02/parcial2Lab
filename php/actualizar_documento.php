<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');
include 'conexion.php'; 

$link = conectaDB();
$response = ['status' => 'error', 'message' => 'Error desconocido'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_documento = isset($_POST['id_documento']) ? intval($_POST['id_documento']) : 0;
    $no_oficio    = isset($_POST['no_oficio']) ? mysqli_real_escape_string($link, $_POST['no_oficio']) : '';
    $fecha        = isset($_POST['fecha']) ? mysqli_real_escape_string($link, $_POST['fecha']) : '';
    $asunto       = isset($_POST['asunto']) ? mysqli_real_escape_string($link, $_POST['asunto']) : '';
    $remitente    = isset($_POST['remitente']) ? mysqli_real_escape_string($link, $_POST['remitente']) : '';
    $destinatario = isset($_POST['destinatario']) ? mysqli_real_escape_string($link, $_POST['destinatario']) : '';
    $estatus      = isset($_POST['estatus']) ? mysqli_real_escape_string($link, $_POST['estatus']) : '';
    
    if ($id_documento > 0) {
        $archivo_sql = "";
        
        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath   = $_FILES['archivo']['tmp_name'];
            $fileName      = $_FILES['archivo']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $newFileName   = md5(time() . $fileName) . '.' . $fileExtension;
            
            $uploadFileDir = '../uploads/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }
            
            $dest_path = $uploadFileDir . $newFileName;
            
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $archivo_sql = ", archivo_pdf = '$newFileName'";
            }
        }

        // Consulta de actualización
        $sql = "UPDATE documentos SET 
                no_oficio = '$no_oficio', 
                fecha = '$fecha', 
                asunto = '$asunto', 
                remitente = '$remitente', 
                destinatario = '$destinatario', 
                estatus = '$estatus' 
                $archivo_sql 
                WHERE id_documento = $id_documento";
        
        if (mysqli_query($link, $sql)) {
            $response = ['status' => 'success', 'message' => 'Documento actualizado exitosamente.'];
        } else {
            $response = ['message' => 'Error en la base de datos: ' . mysqli_error($link)];
        }
    } else {
        $response = ['message' => 'ID de documento inválido.'];
    }
}

mysqli_close($link);
echo json_encode($response);
?>