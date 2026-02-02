<?php declare(strict_types=1);

session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use App\Clases\ConexionBD;
use Dotenv\Dotenv;

$doten = Dotenv::createImmutable(__DIR__ . '/../');

$doten->load();

$errores = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $password_copia = trim($_POST['password_copia'] ?? '');

    if ($usuario === '') {
        $errores[] = 'El suario es obligatorio';
    } elseif (mb_strlen($usuario) > 50) {
        $errores[] = 'El suario debe ser menor a 50 caracteres';
    }
    if ($password === '') {
        $errores[] = 'El password es obligatorio';
    } elseif (mb_strlen($password) < 6) {
        $errores[] = 'El suario debe ser mayor a 6 caracteres';
    }
    if ($password !== $password_copia) {
        $errores[] = 'Las contraseñas no enciden';
    }

    if (empty($errores)) {
        try {
            $pdo = ConexionBD::getConexion();
            $stmt = $pdo->prepare('
                select count(*) from usuarios where usuario = :usuario
            ');

            $stmt->execute(['usuario' => $usuario]);
            if ($stmt->fetchColumn() > 0) {
                $errores[] = 'El usuario ya existe';
            } else {
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $ins = $pdo->prepare('
                insert into usuarios (usuario, password) values(:usuario, :password);
                ');
                $ok = $ins->execute(['usuario' => $usuario, 'password' => $hash]);
                if ($ok) {
                    $success = true;
                    $_SESSION['flash'] = 'se registraron correctamente tus datos';
                    header('Location: login.php');
                    exit;
                } else {
                    $errores[] = 'No se pudo crear el suario';
                }
            }
        } catch (\Throwable $th) {
            $th->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <?php if ($success): ?>
        <p> se creo el usuario correctamente <a href="login.php">Ir al login</a></p>
    <?php else: ?>
    <?php if (!empty($errores)): ?>
        <ul>
        <?php foreach ($errores as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
        </ul>
    <?php endif ?>
    <form method="post" action="registro.php" novalidate>
        <label>Usuario</label>
        <input name="usuario" type="text" required>
        <label>Password</label>
        <input name="password" type="password" required>
        <label>Igrese el mismo password</label>
        <input name="password_copia" type="password" required>
        <button type="submit" name="crear">Crear usuario</button>
    </form>
     <?php endif ?>
</body>
</html>