<?php require_once '../includes/sesion.php'; ?>
<?php require_once '../config.php'; ?>
<?php
$stmt = $pdo->query("SELECT r.*, u.nombre AS docente FROM recursos r JOIN usuarios u ON r.docente_id = u.id");
$recursos = $stmt->fetchAll();
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
  <h2>Bienvenido Administrador</h2>
  <a href="../auth/logout.php" class="btn btn-secondary">Cerrar sesión</a>

  <hr>
  <h4>Todos los Recursos</h4>
  <ul class="list-group">
    <?php foreach ($recursos as $recurso): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
          <strong><?= htmlspecialchars($recurso['titulo']) ?></strong> - <?= htmlspecialchars($recurso['docente']) ?>
        </div>
        <div>
          <a href="recursos/editar_recurso.php?id=<?= $recurso['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
          <a href="recursos/eliminar.php?id=<?= $recurso['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
