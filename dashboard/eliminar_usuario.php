<?php
require_once '../includes/sesion.php';
require_once '../config.php';

// Solo admins pueden entrar
if ($_SESSION['usuario']['rol'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: admin.php');
    exit;
}

$id = $_GET['id'];

// Obtener el usuario
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch();

if (!$usuario || $usuario['rol'] === 'admin') {
    header('Location: admin.php');
    exit;
}

// Si es docente, borrar sus recursos y archivos
if ($usuario['rol'] === 'docente') {
    $stmt = $pdo->prepare("SELECT * FROM recursos WHERE docente_id = ?");
    $stmt->execute([$id]);
    $recursos = $stmt->fetchAll();

    foreach ($recursos as $recurso) {
        $ruta = '../uploads/' . $recurso['archivo'];
        if (file_exists($ruta)) {
            unlink($ruta);
        }
    }

    $stmt = $pdo->prepare("DELETE FROM recursos WHERE docente_id = ?");
    $stmt->execute([$id]);
}

$stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
$stmt->execute([$id]);

header('Location: admin.php');
exit;
?>
