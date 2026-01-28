<?php
declare(strict_types=1);

/*
 * Página protegida que muestra información del usuario conectado.
 * - Comprueba la sesión
 * - Si no hay sesión válida redirige al controlador con un mensaje flash
 * - Si hay sesión muestra el id del usuario y enlace para desconectarse
 */

require_once __DIR__ . '/../helper.php'; // funciones globales: iniciar_sesion, flash, etc.

iniciar_sesion(); // Asegura que la sesión esté iniciada antes de usar $_SESSION

// Comprobar que existe la clave de sesión que indica usuario logueado.
// Si no existe, crear un mensaje flash y redirigir al index para que muestre el login.
if (!isset($_SESSION['usuario_id'])) {
    flash('error', 'No tienes acceso a esta página'); // mensaje que se mostrará en la página de login
    header('Location: index.php?action=paginaLogin'); // redirección al controlador
    exit;
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Conectado</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <!-- Estilos mínimos -->
  <style>
    body{font-family:Arial,Helvetica,sans-serif;margin:20px}
  </style>
</head>
<body>
  <!-- Contenido visible sólo cuando el usuario está autenticado -->
  <h1>Te has conectado</h1>

  <!-- Mostrar el identificador de usuario almacenado en la sesión -->
  <p>Hola, tu id de usuario es <?= (int)$_SESSION['usuario_id'] ?></p>

  <!-- Enlace para cerrar sesión: redirige al controlador que destruye la sesión -->
  <p><a href="index.php?action=desconectarse">Desconectarse</a></p>
</body>
</html>