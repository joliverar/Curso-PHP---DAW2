<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Clases\ConexionBD;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if ($usuario === '') {
        $errors[] = 'El usuario es obligatorio.';
    } elseif (mb_strlen($usuario) > 50) {
        $errors[] = 'El usuario no puede superar 50 caracteres.';
    }

    if ($password === '') {
        $errors[] = 'La contraseña es obligatoria.';
    } elseif (mb_strlen($password) < 6) {
        $errors[] = 'La contraseña debe tener al menos 6 caracteres.';
    }

    // Comprobación de repetición de contraseña
    if ($password !== $password_confirm) {
        $errors[] = 'Las contraseñas no coinciden.';
    }

    if (empty($errors)) {
        try {
            $pdo = ConexionBD::getConexion();

            // Comprobar si usuario ya existe
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario');
            $stmt->execute([':usuario' => $usuario]);
            if ($stmt->fetchColumn() > 0) {
                $errors[] = 'El nombre de usuario ya está en uso.';
            } else {
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $ins = $pdo->prepare('INSERT INTO usuarios (usuario, password) VALUES (:usuario, :password)');
                $ok = $ins->execute([':usuario' => $usuario, ':password' => $hash]);
                if ($ok) {
                    $success = true;
                } else {
                    $errors[] = 'No se pudo registrar el usuario.';
                }
            }
        } catch (\Exception $e) {
            $errors[] = 'Error de servidor: ' . $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Registro de usuario</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family:Arial,Helvetica,sans-serif;margin:20px;background:#f6f8fb;color:#222}
    .card{max-width:520px;margin:0 auto;background:#fff;padding:16px;border-radius:6px;border:1px solid #e6e9ee}
    label{display:block;margin:10px 0 4px}
    input{width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;box-sizing:border-box}
    .actions{margin-top:12px}
    button{padding:8px 12px;border:0;border-radius:4px;background:#2b7cff;color:#fff;cursor:pointer}
    .error{background:#fff2f2;border:1px solid #f2c2c2;color:#7a1b1b;padding:8px;border-radius:4px;margin-bottom:10px}
    .ok{background:#e9f7ef;border:1px solid #c7eed4;color:#124825;padding:8px;border-radius:4px;margin-bottom:10px}
    a{color:#2b7cff;text-decoration:none}
  </style>
</head>
<body>
  <main class="card">
    <h1>Registro</h1>

    <?php if ($success): ?>
        <div class="ok">Usuario registrado correctamente. <a href="index.php">Ir a inicio</a></div>
    <?php else: ?>
        <?php if (!empty($errors)): ?>
            <div class="error">
                <ul style="margin:0 0 0 18px;padding:0">
                    <?php foreach ($errors as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="registro.php" autocomplete="off" novalidate>
            <label for="usuario">Usuario</label>
            <input id="usuario" name="usuario" type="text" maxlength="50" required value="<?= isset($usuario) ? htmlspecialchars($usuario) : '' ?>">

            <label for="password">Contraseña</label>
            <input id="password" name="password" type="password" required>

            <label for="password_confirm">Repetir contraseña</label>
            <input id="password_confirm" name="password_confirm" type="password" required>

            <div class="actions">
                <button type="submit">Registrar</button>
                <a href="index.php" style="margin-left:12px">Cancelar</a>
            </div>
        </form>
    <?php endif; ?>
  </main>
</body>
</html>