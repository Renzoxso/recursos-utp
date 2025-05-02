<?php require_once '../includes/sesion.php'; ?>
<?php require_once '../includes/config.php'; ?>
<?php
$stmt = $pdo->query("SELECT * FROM recursos");
$recursos = $stmt->fetchAll();
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
  <h2>Bienvenido Estudiante</h2>
  <a href="perfil.php" class="btn btn-outline-info">Mi Perfil</a>
  <a href="../auth/logout.php" class="btn btn-secondary">Cerrar sesión</a>

  <hr>
  <h4>Recursos Disponibles</h4>
  <ul class="list-group">
    <?php foreach ($recursos as $recurso): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <?= htmlspecialchars($recurso['titulo']) ?>
        <a href="recursos/descargar.php?archivo=<?= urlencode($recurso['archivo']) ?>" class="btn btn-success btn-sm">Descargar</a>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
