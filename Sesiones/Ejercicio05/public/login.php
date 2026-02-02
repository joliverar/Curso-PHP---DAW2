<?php declare(strict_types=1);

session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use App\Clases\ConexionBD;
use Dotenv\Dotenv;

$doten = Dotenv::createImmutable(__DIR__ . '/../');

$doten->safeLoad();

$errores = [];
$usuario = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ingresar'])) {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($usuario === '' || $password === '') {
        $errores[] = 'El usuario y la contraseña son obligatorios';
    } else {
        try {
            $pdo = ConexionBD::getConexion();
            $stmt = $pdo->prepare('
                select password from usuarios where usuario = :usuario limit 1
            ');
            $stmt->execute(['usuario' => $usuario]);
            $hash = $stmt->fetchColumn();
            if ($hash !== false && password_verify($password, (string) $hash)) {
                session_regenerate_id(true);
                $_SESSION['usuario'] = $usuario;
                $_SESSION['flash'] = 'Login correcto';
                header('Location: peliculas.php');
                exit;
            } else {
                $errores[] = 'el usuario o contraeño es invalido';
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
    <title>Login</title>
</head>
<body>

    <?php if (isset($_SESSION['flash'])): ?>
        <p><?= htmlspecialchars($_SESSION['flash']) ?></p>
    
    <?php unset($_SESSION['flash']);
endif; ?>

    <?php if (!empty($errores)): ?>
        <ul>
        <?php foreach ($errores as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
        <form  method="post" action="login.php" novalidate>
            <label>usuario</label>
            <input type="text" name="usuario">
            <label>Pasword</label>
            <input type="password" name="password">
            <button type="submit" name="ingresar">Ingresar</button>

        </form>


</body>
</html>
