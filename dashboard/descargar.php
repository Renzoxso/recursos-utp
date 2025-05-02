<?php
// Ruta donde están almacenados los archivos
$ruta = '../uploads/';

if (isset($_GET['archivo'])) {
    $archivo = basename($_GET['archivo']); // sanitiza
    $ruta_completa = $ruta . $archivo;

    if (file_exists($ruta_completa)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $archivo . '"');
        header('Content-Length: ' . filesize($ruta_completa));
        readfile($ruta_completa);
        exit;
    } else {
        echo "El archivo no existe.";
    }
} else {
    echo "No se ha especificado ningún archivo.";
}
?>
