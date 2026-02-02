<?php declare(strict_types=1);

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use App\Clases\ConexionBD;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$errores = [];
$usuario = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ingresar'])) {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($usuario === '' || $password === '') {
        $errores[] = 'El suario y contraseña son obligatorios';
    } else {
        try {
            $pdo = ConexionBD::getConexion();
            $stmt = $pdo->prepare('
                select password from usuarios where usuario = :usuario
            ');
            $stmt->execute(['usuario' => $usuario]);
            $hash = $stmt->fetchColumn();
            echo ($usuario);
            if ($hash !== false && password_verify($password, (string) $hash)) {
                session_regenerate_id(true);
                $_SESSION['usuario'] = $usuario;
                header('Location:reserva.php');
                exit;
            } else {
                $errores[] = 'El susario o contraseña son incorrectas';
            }
        } catch (PDOException $th) {
            $errores[] = 'Error de servidor ' . $th->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceder</title>
</head>
<body>
      <?php if (!empty($errores)): ?>
                    <ul>
                            <?php foreach ($errores as $e): ?>
                                <li><?= htmlspecialchars($e) ?></li>
                                <?php endforeach; ?>
                    </ul>
        <?php endif; ?>

                <form method="post" action="login.php" novalidate>
                                <label>Usuario</label>
                                <input name="usuario" type="text" required value="<?= htmlspecialchars($usuario) ?>">
                                <label>Contraseña</label>
                                <input name="password" type="text" required>
                                <button type="submit" name="ingresar">Ingresar</button>
                </form>
</body>
</html>