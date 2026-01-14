<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Contacto</title>
    <style>body{font-family:Arial;padding:20px;max-width:720px}</style>
</head>
<body>
    <h1>Formulario de Contacto</h1>

    <!-- Mensajes según GET -->
    <?php if (isset($_GET['error']) && $_GET['error'] === '1'): ?>
        <p style="color:#b00">Por favor, rellena todos los campos.</p>
    <?php elseif (isset($_GET['error']) && $_GET['error'] === '2'): ?>
        <p style="color:#b00">Por favor, introduce un email válido.</p>
    <?php elseif (isset($_GET['error']) && $_GET['error'] === '3'): ?>
        <p style="color:#b00">Ha ocurrido un error al enviar el email.</p>
    <?php elseif (isset($_GET['success']) && $_GET['success'] === '1'): ?>
        <p style="color:green">El email se ha enviado correctamente.</p>
    <?php endif; ?>

    <form method="post" action="procesar.php">
        <label>Nombre:<br>
            <input type="text" name="nombre" required>
        </label>
        <br><br>

        <label>Correo electrónico:<br>
            <input type="email" name="email" required>
        </label>
        <br><br>

        <label>Mensaje:<br>
            <textarea name="mensaje" rows="6" required></textarea>
        </label>
        <br><br>

        <button type="submit" name="enviar">Enviar</button>
    </form>
</body>
</html>