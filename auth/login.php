<?php
require_once '../config.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    $stmt = $pdo->prepare("SELECT u.*, r.nombre as rol FROM usuarios u JOIN roles r ON u.rol_id = r.id WHERE correo = ?");
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
        $_SESSION['usuario'] = $usuario;
        switch ($usuario['rol']) {
            case 'admin':
                header("Location: ../dashboard/admin.php"); break;
            case 'docente':
                header("Location: ../dashboard/docente.php"); break;
            case 'estudiante':
                header("Location: ../dashboard/estudiante.php"); break;
        }
        exit;
    } else {
        echo "<div class='alert alert-danger text-center mt-3'>Credenciales incorrectas.</div>";
    }
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
  <h2>Iniciar Sesión</h2>
  <form method="POST" class="mt-3">
    <div class="mb-3">
      <label>Correo</label>
      <input type="email" name="correo" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Contraseña</label>
      <input type="password" name="contraseña" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Entrar</button>
    <a href="register.php" class="btn btn-link">Registrarse</a>
  </form>
</div>