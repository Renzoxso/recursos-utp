<?php
require_once '../includes/sesion.php';
require_once '../config.php';

$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare("SELECT * FROM recursos WHERE id = ?");
$stmt->execute([$id]);
$recurso = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recurso) {
    die("Recurso no encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $archivoNuevo = $recurso['archivo'];

    // Subir nuevo archivo si aplica
    if (!empty($_FILES['archivo']['name'])) {
        $archivoNuevo = uniqid() . '_' . basename($_FILES['archivo']['name']);
        move_uploaded_file($_FILES['archivo']['tmp_name'], '../uploads/' . $archivoNuevo);
    }

    $stmt = $pdo->prepare("UPDATE recursos SET titulo = ?, descripcion = ?, archivo = ? WHERE id = ?");
    $stmt->execute([$titulo, $descripcion, $archivoNuevo, $id]);

    header("Location: admin.php");
    exit;
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
  <h2>Editar Recurso</h2>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Título</label>
      <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($recurso['titulo']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Descripción</label>
      <textarea name="descripcion" class="form-control" rows="4"><?= htmlspecialchars($recurso['descripcion']) ?></textarea>
    </div>
    <div class="mb-3">
      <label>Archivo actual: <?= $recurso['archivo'] ?></label><br>
      <input type="file" name="archivo" class="form-control mt-1">
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="admin.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
