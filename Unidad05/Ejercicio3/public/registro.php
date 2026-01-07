<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Document</title>
</head>
<body>
    <main class="main">
    <section class="section">
        <h2>Registro</h2>
        
        <form class="form" method="POST" action="procesa.php">
            <label>Usuario</label>
            <input id="user" name="user" type="text" required>
            <label>Contraseña</label>
            <input id="pass" name="pass" type="password" required>
            <label>Repetir Contraseña</label>
            <input id="pass" name="pass" type="password" required>
            <button type="submit">Registrar</button>
            <button>Cancelar</button>
        </form>
        </section>
    </main>
</body>
</html>