<?php require_once '../includes/sesion.php'; ?>
<?php require_once '../config.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $archivo = $_FILES['archivo'];
    $docente_id = $_SESSION['usuario']['id'];

    if ($archivo['error'] === UPLOAD_ERR_OK) {
        $nombre_archivo = time() . '_' . basename($archivo['name']);
        $ruta_destino = '../uploads/' . $nombre_archivo;
        move_uploaded_file($archivo['tmp_name'], $ruta_destino);

        $stmt = $pdo->prepare("INSERT INTO recursos (titulo, descripcion, archivo, docente_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titulo, $descripcion, $nombre_archivo, $docente_id]);

        header('Location: docente.php');
        exit;
    } else {
        $error = 'Error al subir el archivo.';
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
  <h2>Subir Nuevo Recurso</h2>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Título</label>
      <input type="text" name="titulo" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Descripción</label>
      <textarea name="descripcion" class="form-control"></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Archivo</label>
      <input type="file" name="archivo" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Subir</button>
    <a href="docente.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
