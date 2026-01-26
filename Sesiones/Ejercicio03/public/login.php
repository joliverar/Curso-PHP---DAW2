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
                header('Location: peliculas.php');
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php if (!empty($errores)): ?>
        <p><ul>
            <?php foreach ($errores as $e): ?>
            
            <li>
                    <?= htmlspecialchars($e) ?>
            </li>
            <?php endforeach; ?>
        </ul></p>
     <?php endif; ?>
    <form method="post" action="login.php" novalidate>
        <label for="usuario">usuario</label>
        <input name="usuario" id="usuario" required  value="<?= htmlspecialchars($usuario) ?>">
        <label for="password">Password</label>
        <input name="password" id="password" >
        <button type="submit" name="ingresar">Ingresar</button>
        <a href="registro.php">Crear usuario</a>
    </form>
   
</body>
</html>