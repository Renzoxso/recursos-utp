<?php
require_once '../includes/sesion.php';
require_once '../config.php';

if (!isset($_GET['id'])) {
    header('Location: docente.php');
    exit;
}

$id = $_GET['id'];

// Obtener el recurso
$stmt = $pdo->prepare("SELECT * FROM recursos WHERE id = ?");
$stmt->execute([$id]);
$recurso = $stmt->fetch();

if (!$recurso) {
    header('Location: docente.php');
    exit;
}

// Si es docente, verificar que sea dueño del recurso
if ($_SESSION['usuario']['rol'] === 'docente') {
    if ($recurso['docente_id'] != $_SESSION['usuario']['id']) {
        header('Location: docente.php');
        exit;
    }
}

// Borrar el archivo físico
$ruta_archivo = '../uploads/' . $recurso['archivo'];
if (file_exists($ruta_archivo)) {
    unlink($ruta_archivo);
}

// Borrar el registro de la base de datos
$stmt = $pdo->prepare("DELETE FROM recursos WHERE id = ?");
$stmt->execute([$id]);

// Redirigir según el rol
if ($_SESSION['usuario']['rol'] === 'admin') {
    header('Location: admin.php');
} else {
    header('Location: docente.php');
}
exit;
?>
