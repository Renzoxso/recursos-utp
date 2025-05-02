<?php require_once '../includes/sesion.php'; ?>
<?php require_once '../config.php'; ?>
<?php
$usuario_id = $_SESSION['usuario']['id'];
$stmt = $pdo->prepare("SELECT * FROM recursos WHERE docente_id = ?");
$stmt->execute([$usuario_id]);
$recursos = $stmt->fetchAll();
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
  <h2>Bienvenido Docente</h2>
  <a href="crear_recurso.php" class="btn btn-primary">Nuevo Recurso</a>
  <a href="perfil.php" class="btn btn-info">Mi Perfil</a>
  <a href="../auth/logout.php" class="btn btn-secondary">Cerrar sesión</a>

  <hr>
  <h4>Mis Recursos</h4>
  <ul class="list-group">
    <?php foreach ($recursos as $recurso): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <?= htmlspecialchars($recurso['titulo']) ?>
        <div>
          <a href="editar_recurso.php?id=<?= $recurso['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
          <a href="eliminar.php?id=<?= $recurso['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
