<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Clases\ConexionBD;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$errores = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] = 'POST' && isset($_POST['crear'])) {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $pasword_conf = trim($_POST['password_conf'] ?? '');

    if ($usuario === '') {
        $errores[] = 'El usuario es obligatorio';
    } elseif (mb_strlen($usuario) > 50) {
        $errores[] = 'El usuario debe tener menor a 50 caracteres';
    }
    if ($password === '') {
        $errores[] = 'El password es obligatorio';
    } elseif (mb_strlen($password) < 6) {
        $errores[] = 'El pasword debe tener mayor a 6 caracteres';
    }

    if ($password !== $pasword_conf) {
        $errores[] = 'la confirmacion del pasword no es correcta';
    }

    if (empty($errores)) {
        try {
            $pdo = ConexionBD::getConexion();
            $stmt = $pdo->prepare('
                select count(*) from usuarios where usuario = :usuario 
            ');
            $stmt->execute(['usuario' => $usuario]);
            if ($stmt->fetchColumn() > 0) {
                $errores[] = 'Ya existe un usario con ese nombre';
            } else {
                $hash = password_hash($password, PASSWORD_BCRYPT);

                $ins = $pdo->prepare('
                    insert into usuarios(usuario, password) values(:usuario, :password)
                ');
                $ok = $ins->execute([
                    'usuario' => $usuario,
                    'password' => $hash
                ]);

                if ($ok) {
                    $success = true;
                } else {
                    $errores[] = 'usuario o contraseña invalida';
                }
            }
        } catch (PDOException $th) {
            $errores[] = 'Error de servidor' . $th->getMessage();
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
        <p style="color: green;">Datos gurdados correctamente</p>
        <a href="login.php">Ingresar al login</a>
        <?php else: ?>
            
                <?php if (!empty($errores)): ?>
                    <ul>
                            <?php foreach ($errores as $e): ?>
                                <li><?= htmlspecialchars($e) ?></li>
                                <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <form method="post" action="registro.php" novalidate>
                    <label>usuario</label>
                    <input type="text" name="usuario" required >
                    <label>Contraseña</label>
                    <input type="password" name="password" required >
                    <label>Vuelva ha insertar la Contraseña</label>
                    <input type="password" name="password_conf"required >
                    <button type="submit" name="crear">Crear usuario</button>
                    
                </form>

 <?php endif; ?>
</body>
</html>