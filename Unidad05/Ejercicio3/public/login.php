<?php
declare(strict_types=1);

// Carga del entorno común (autoload, .env, etc.)
require_once __DIR__ . '/../app/bootstrap.php';

use App\Clases\ConexionBD;


// Iniciar sesión (necesario para guardar el usuario logueado)
session_start();

// Variable para mostrar errores en la vista
$error = '';

// Solo procesamos si el formulario se envía por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recoger y sanear datos del formulario
    $usuario  = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    try {
        // Obtener conexión PDO
        $pdo = ConexionBD::getConexion();

        // Buscar el usuario en la base de datos
        $stmt = $pdo->prepare(
            'SELECT * FROM usuarios WHERE usuario = ?'
        );
        $stmt->execute([$usuario]);

        // Obtener el usuario como array asociativo
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar la contraseña cifrada con bcrypt
        if ($user && password_verify($password, $user['password'])) {

            // Guardar el usuario en la sesión
            $_SESSION['usuario'] = $usuario;

            // Redirigir a la página protegida
            header('Location: index.php');
            exit;

        } else {
            // Usuario o contraseña incorrectos
            $error = 'Credenciales incorrectas.';
        }

    } catch (PDOException $e) {
        // Error de conexión o consulta
        $error = 'Error de conexión.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Login</title>
</head>
<body>
<main class="main">
    <section class="section">
<h2>Login</h2>

<!-- Mostrar error si existe -->
<?php if ($error): ?>
    <p><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<!-- Formulario de login -->
<form class="form" method="post" action="">
    <label>Usuario</label>
    <input type="text" name="usuario" required>

    <label>Contraseña</label>
    <input type="password" name="password" required>

    <button type="submit">Ingresar</button>
</form>
</section>
</main>
</body>
</html>
