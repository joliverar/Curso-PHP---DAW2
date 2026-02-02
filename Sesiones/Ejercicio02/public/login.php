<?php declare(strict_types=1);

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use App\Clases\ConexionBD;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$errores = [];
$usuario = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $usuario = trim($_POST['usuario'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($usuario === '' || $password === '') {
    $errores[] = 'Usuario y contraseña son obligatorios.';
  } else {
    try {
      $pdo = ConexionBD::getConexion();
      $stmt = $pdo->prepare('SELECT password FROM usuarios WHERE usuario = :usuario LIMIT 1');
      $stmt->execute([':usuario' => $usuario]);
      $hash = $stmt->fetchColumn();

      if ($hash !== false && password_verify($password, (string) $hash)) {
        // Credenciales válidas

        $_SESSION['usuario'] = $usuario;
        header('Location: reserva.php');
        exit;
      } else {
        $errores[] = 'Usuario o contraseña incorrectos.';
      }
    } catch (\Throwable $e) {
      $errores[] = 'Error de servidor.';
    }
  }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Acceso - Login</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family:Arial,Helvetica,sans-serif;margin:20px;background:#f6f8fb;color:#222}
    .card{max-width:420px;margin:0 auto;background:#fff;padding:16px;border-radius:6px;border:1px solid #e6e9ee}
    label{display:block;margin:10px 0 4px}
    input{width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;box-sizing:border-box}
    .actions{margin-top:12px}
    button{padding:8px 12px;border:0;border-radius:4px;background:#2b7cff;color:#fff;cursor:pointer}
    .error{background:#fff2f2;border:1px solid #f2c2c2;color:#7a1b1b;padding:8px;border-radius:4px;margin-bottom:10px}
  </style>
</head>
<body>
  <main class="card">
    <h1>Iniciar sesión</h1>

    <?php if (!empty($errores)): ?>
      <div class="error"><ul style="margin:0 0 0 18px;padding:0">
        <?php foreach ($errores as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
      </ul></div>
    <?php endif; ?>

    <form method="post" action="login.php" autocomplete="off" novalidate>
      <label for="usuario">Usuario</label>
      <input id="usuario" name="usuario" type="text" maxlength="50" required value="<?= htmlspecialchars($usuario) ?>">

      <label for="password">Contraseña</label>
      <input id="password" name="password" type="password" required>

      <div class="actions">
        <button type="submit">Entrar</button>
        <a href="registro.php" style="margin-left:12px">Registrar usuario</a>
      </div>
    </form>
  </main>
</body>
</html>