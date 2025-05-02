<?php
require_once '../includes/sesion.php';
require_once '../config.php';

$stmt = $pdo->query("SELECT r.*, u.nombre AS autor FROM recursos r JOIN usuarios u ON r.usuario_id = u.id");
$recursos = $stmt->fetchAll();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
    <h2>Bienvenido Estudiante</h2>

    <h4 class="mt-4">Recursos Disponibles</h4>
    <ul class="list-group">
        <?php foreach ($recursos as $recurso): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong><?= htmlspecialchars($recurso['nombre']) ?></strong> -
                    <?= htmlspecialchars($recurso['descripcion']) ?><br>
                    <small>Autor: <?= htmlspecialchars($recurso['autor']) ?></small>
                </div>
                <a href="../uploads/<?= urlencode($recurso['archivo']) ?>" class="btn btn-sm btn-success" download>Descargar</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="perfil.php" class="btn btn-outline-info mt-3">Mi Perfil</a>
    <a href="../auth/logout.php" class="btn btn-secondary mt-3">Cerrar sesión</a>
</div>
