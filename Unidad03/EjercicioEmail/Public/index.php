<?php
declare(strict_types=1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if(isset($_GET['error']) && $_GET['error'] === '1'):?>
    <p>Ingresar todos los datos del formulario</p>
    <?php elseif (isset($_GET['error']) && $_GET['error'] === '2'):?>
    <p>Ingresar un email correcto</p>
    <?php elseif (isset($_GET['error']) && $_GET['error'] === '3'):?>
    <p>Tuvo problemas con el email</p>
    <?php elseif (isset($_GET['success']) && $_GET['success'] === '1'):?>
    <p>Se envio el email de forma correcta</p>
    <?php endif; ?>

    <form action="procesa.php" method="post">
        <label>Nombre</label><br><br>
        <input type ="text" name ="nombre" require><br><br>
        <label>Email</label><br><br>
        <input type ="email" name ="email" require><br><br>
        <label>Mensaje</label><br><br>
        <textarea rows="6" name="mensaje"></textarea><br><br>
        <button type="submit" name="enviar">Enviar</button>

    </form>
</body>
</html>
