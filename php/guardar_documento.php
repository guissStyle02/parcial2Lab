<?php
header('Content-Type: application/json');
include 'conexion.php'; 

$link = conectaDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_oficio    = $_POST['no_oficio'] ?? '';
    $fecha        = $_POST['fecha'] ?? '';
    $asunto       = $_POST['asunto'] ?? '';
    $remitente    = $_POST['remitente'] ?? '';
    $destinatario = $_POST['destinatario'] ?? '';
    $estatus      = $_POST['estatus'] ?? '';
    
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
            $no_oficio_esc    = mysqli_real_escape_string($link, $no_oficio);
            $fecha_esc        = mysqli_real_escape_string($link, $fecha);
            $asunto_esc       = mysqli_real_escape_string($link, $asunto);
            $remitente_esc    = mysqli_real_escape_string($link, $remitente);
            $destinatario_esc = mysqli_real_escape_string($link, $destinatario);
            $estatus_esc      = mysqli_real_escape_string($link, $estatus);
            $newFileName_esc  = mysqli_real_escape_string($link, $newFileName);

            $sql = "INSERT INTO documentos (no_oficio, fecha, asunto, remitente, destinatario, estatus, archivo_pdf) 
                    VALUES ('$no_oficio_esc', '$fecha_esc', '$asunto_esc', '$remitente_esc', '$destinatario_esc', '$estatus_esc', '$newFileName_esc')";
            
            if (mysqli_query($link, $sql)) {
                echo json_encode(['status' => 'success', 'message' => 'Documento guardado exitosamente.']);
                mysqli_close($link);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error en la Base de Datos: ' . mysqli_error($link)]);
                mysqli_close($link);
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al mover el archivo a la carpeta uploads.']);
            mysqli_close($link);
            exit;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se seleccionó ningún archivo o ocurrió un error al subirlo.']);
        mysqli_close($link);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
    mysqli_close($link);
    exit;
}
?>