<?php
/* 
 * holamundo.php
 * - Muestra título y mensajes usando HTML y PHP.
 * - Configura la codificación de salida a UTF-8.
 */
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"><!-- Asegura caracteres españoles -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mi primera página web</title>
</head>
<body>
  <!-- Título en HTML -->
  <h1>Mi primera página web</h1>

  <!-- Mensaje en HTML puro -->
  <p>Codificando en HTML y PHP</p>

  <!-- Bloque PHP que imprime texto -->
  <?php
    // echo envía texto al cliente (navegador)
    echo "<p>¡Hola mundo!</p>";
  ?>
</body>
</html>
