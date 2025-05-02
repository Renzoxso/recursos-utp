<?php
require_once '../includes/sesion.php';
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $archivoNombre = null;

    // Manejar archivo
    if (!empty($_FILES['archivo']['name'])) {
        $archivoNombre = uniqid() . '_' . basename($_FILES['archivo']['name']);
        $ruta = '../uploads/' . $archivoNombre;
        move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta);
    }

    $stmt = $pdo->prepare("INSERT INTO recursos (titulo, descripcion, archivo, docente_id, fecha_subida) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$titulo, $descripcion, $archivoNombre, $_SESSION['usuario']['id']]);

    header("Location: docente.php");
    exit;
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
  <h2>Nuevo Recurso</h2>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Título</label>
      <input type="text" name="titulo" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Descripción</label>
      <textarea name="descripcion" class="form-control" rows="4" required></textarea>
    </div>
    <div class="mb-3">
      <label>Archivo</label>
      <input type="file" name="archivo" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="docente.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
