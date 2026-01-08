<?php
declare(strict_types=1);

// Carga del entorno común (autoload, .env, etc.)
require_once __DIR__ . '/../app/bootstrap.php';

use App\Clases\ConexionBD;

// Variable para mostrar mensajes en la vista
$mensaje = '';

// Solo procesamos si el formulario se envía por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recoger y sanear datos del formulario
    $usuario = trim($_POST['usuario'] ?? '');
    $pass1   = $_POST['password']  ?? '';
    $pass2   = $_POST['password2'] ?? '';

    // Validaciones básicas
    if ($usuario === '' || $pass1 === '' || $pass2 === '') {
        $mensaje = 'Todos los campos son obligatorios.';
    } elseif ($pass1 !== $pass2) {
        $mensaje = 'Las contraseñas deben ser iguales.';
    } else {
        // Cifrado seguro de la contraseña (bcrypt)
        $hash = password_hash($pass1, PASSWORD_BCRYPT);

        try {
            // Obtener conexión PDO
            $pdo = ConexionBD::getConexion();

            // Inserción segura con prepared statement
            $stmt = $pdo->prepare(
                "INSERT INTO usuarios (usuario, password) VALUES (?, ?)"
            );
            $stmt->execute([$usuario, $hash]);

            // Mensaje de éxito
            $mensaje = 'Usuario registrado correctamente.';
        } catch (PDOException $e) {
            // Error típico: usuario duplicado
            $mensaje = 'Error al registrar el usuario (puede que ya exista).';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Registro</title>
</head>
<body>
<main class="main">
<section class="section">

    <h2>Registro de usuarios</h2>

    <!-- Mostrar mensaje si existe -->
    <?php if ($mensaje): ?>
        <p><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>

    <!-- Formulario de registro -->
    <form class="form" method="POST" action="">
        <label>Usuario</label>
        <input name="usuario" type="text" required>

        <label>Contraseña</label>
        <input name="password" type="password" required>

        <label>Repetir contraseña</label>
        <input name="password2" type="password" required>

        <button type="submit">Registrar</button>
    </form>

    <a href="login.php">Ir a login</a>

</section>
</main>
</body>
</html>
