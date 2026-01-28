<?php
declare(strict_types=1);

// Cargar helper con funciones globales (iniciar_sesion, flash, redireccionar, etc.)
require_once __DIR__ . '/../helper.php';

// Asegurar que la sesión esté iniciada antes de usar $_SESSION
iniciar_sesion();

// Recuperar y consumir mensajes flash (si existen)
// flash('error') devuelve el mensaje y lo elimina de la sesión
$error = flash('error');
// flash('email') devuelve el email previamente guardado en flash (si procede) para repoblar el formulario
$oldEmail = flash('email') ?? '';

// Si ya existe usuario en sesión, evitar mostrar el formulario y redirigir a la página protegida
if (isset($_SESSION['usuario'])) {
    header('Location: index.php?action=paginaConectado');
    exit;
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    /* Estilos mínimos para el formulario de acceso */
    body{font-family:Arial,Helvetica,sans-serif;margin:20px}
    .card{max-width:420px;margin:0 auto;padding:16px;border:1px solid #ddd}
    .error{color:#a00;margin-bottom:12px}
  </style>
</head>
<body>
  <main class="card">
    <h1>Acceso</h1>

    <!-- Si hay un mensaje de error en flash, mostrarlo aquí -->
    <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

    <!--
      Formulario de login:
      - Método POST
      - Envia al controlador index.php?action=autenticar
      - Campos: email, password
    -->
    <form method="post" action="index.php?action=autenticar">
      <label for="email">Correo electrónico</label>
      <!--
        Recuperar el email previamente guardado en flash para que el usuario no tenga que reescribirlo
        htmlspecialchars para evitar XSS al repoblar el campo
      -->
      <input id="email" name="email" type="email" required value="<?= htmlspecialchars($oldEmail) ?>" style="width:100%;padding:8px;margin:6px 0">

      <label for="password">Contraseña</label>
      <input id="password" name="password" type="password" required style="width:100%;padding:8px;margin:6px 0">

      <div style="margin-top:10px">
        <button type="submit">Entrar</button>
      </div>
    </form>
  </main>
</body>
</html>