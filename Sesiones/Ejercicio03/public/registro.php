<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Clases\ConexionBD;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$errores = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
    $usuario = trim((string) $_POST['usuario'] ?? '');
    $password = trim((string) $_POST['password'] ?? '');
    $password_copia = trim((string) $_POST['password_copia'] ?? '');

    if ($usuario === '') {
        $errores[] = 'El usuario es obligatorio';
    } elseif (mb_strlen($usuario) > 50) {
        $errores[] = 'El usuario debe tener menor a 50 caracteres';
    }
    if ($password === '') {
        $errores[] = 'El pasword es obligatorio';
    } elseif (mb_strlen($password) < 6) {
        $errores[] = 'El password debe tener mas de 6 caracteres';
    }
    if ($password !== $password_copia) {
        $errores[] = 'La contraseña no son iguales';
    }
    echo ($usuario);
    echo (htmlspecialchars($password));

    if (empty($errores)) {
        try {
            // code...

            $pdo = ConexionBD::getConexion();
            $stmt = $pdo->prepare('select count(*) from usuarios where usuario = :usuario limit 1');
            $stmt->execute([':usuario' => $usuario]);

            if ($stmt->fetchColumn() > 0) {
                $errores[] = 'Ya existe un usrio con ese nombre';
            } else {
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $ins = $pdo->prepare('
            INSERT INTO usuarios (usuario, password) values(:usuario, :password)
             ');
                $ok = $ins->execute([
                    ':usuario' => $usuario,
                    ':password' => $hash
                ]);

                if (!$ok) {
                    $errores[] = 'No se pudo crear';
                } else {
                    $success = true;
                }
            }
        } catch (PDOException $e) {
            // throw $th;
            $errores[] = 'Error al crear el usario ' . $e->getMessage();
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
        <p>Se creo el suario correctamente <a href="login.php">ir al login</a></p>
    <?php else: ?>
        <?php if (!empty($errores)): ?>
            <p><ul>

            <?php foreach ($errores as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
            </ul></p>
        <?php endif; ?>
    <form method="post" action="registro.php" novalidate>
    <labe for ='usuario'>usuario</labe>
    <input name="usuario" id="usuario" type="text">
    <labe for ='password'>password</labe>
    <input name="password" id="password" type="password">
    <labe for ='password_copia'>Confirmar password</labe>
    <input name="password_copia" id="password_copia" type="password">
    <button type="submit" name="crear">Crear usuario</button>
    </form>
    <?php endif; ?>
</body>
</html>