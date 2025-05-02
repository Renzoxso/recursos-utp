<?php
require_once '../includes/sesion.php';
require_once '../config.php';

$usuario_id = $_SESSION['usuario']['id'];

// Manejar subida de recurso
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo'])) {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $archivo = $_FILES['archivo'];

    if ($archivo['error'] === UPLOAD_ERR_OK) {
        $ruta = '../uploads/' . basename($archivo['name']);
        move_uploaded_file($archivo['tmp_name'], $ruta);

        $stmt = $pdo->prepare("INSERT INTO recursos (nombre, descripcion, archivo, usuario_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $descripcion, $archivo['name'], $usuario_id]);
        $msg = "Recurso subido correctamente.";
    }
}

// Obtener recursos del docente
$stmt = $pdo->prepare("SELECT * FROM recursos WHERE usuario_id = ?");
$stmt->execute([$usuario_id]);
$recursos = $stmt->fetchAll();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
    <h2>Bienvenido Docente</h2>

    <?php if (isset($msg)): ?>
        <div class="alert alert-success"><?= $msg ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="mb-4">
        <div class="mb-2">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre del recurso" required>
        </div>
        <div class="mb-2">
            <textarea name="descripcion" class="form-control" placeholder="Descripción" required></textarea>
        </div>
        <div class="mb-2">
            <input type="file" name="archivo" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Subir Recurso</button>
    </form>

    <h4>Mis Recursos</h4>
    <ul class="list-group">
        <?php foreach ($recursos as $recurso): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= htmlspecialchars($recurso['nombre']) ?> - <?= htmlspecialchars($recurso['descripcion']) ?>
                <a href="../uploads/<?= urlencode($recurso['archivo']) ?>" class="btn btn-sm btn-outline-success" download>Descargar</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="perfil.php" class="btn btn-outline-info mt-3">Mi Perfil</a>
    <a href="../auth/logout.php" class="btn btn-secondary mt-3">Cerrar sesión</a>
</div>
