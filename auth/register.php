<?php
require_once '../config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
    $rol_id = $_POST['rol'];

    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, contraseña, rol_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombre, $correo, $contraseña, $rol_id]);
    echo "<div class='alert alert-success text-center mt-3'>Registro exitoso. <a href='login.php'>Iniciar sesión</a></div>";
    exit;
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
  <h2>Registro de Usuario</h2>
  <form method="POST" class="mt-3">
    <div class="mb-3">
      <label>Nombre</label>
      <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Correo</label>
      <input type="email" name="correo" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Contraseña</label>
      <input type="password" name="contraseña" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Rol</label>
      <select name="rol" class="form-select">
        <option value="1">Administrador</option>
        <option value="2">Docente</option>
        <option value="3">Estudiante</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Registrarse</button>
  </form>
</div>