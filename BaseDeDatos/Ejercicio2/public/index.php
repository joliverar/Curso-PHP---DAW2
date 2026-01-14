<?php

//Ver archivo leer
require_once __DIR__ . '/../app/bootstrap.php';


?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Nuevo libro</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family:Arial,Helvetica,sans-serif;margin:20px;background:#f6f8fb;color:#222}
    .card{max-width:600px;margin:0 auto;background:#fff;padding:16px;border-radius:6px;border:1px solid #e6e9ee}
    h1{margin:0 0 12px;font-size:18px}
    label{display:block;margin:10px 0 4px;font-size:14px}
    input[type="text"], input[type="number"], input[type="date"]{width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;box-sizing:border-box}
    .actions{margin-top:12px;display:flex;gap:8px;align-items:center}
    button{padding:8px 12px;border:0;border-radius:4px;background:#2b7cff;color:#fff;cursor:pointer}
    a{color:#2b7cff;text-decoration:none;font-size:14px}
  </style>
</head>
<body>
  <main class="card">
    <h1>Alta de libro</h1>

    <form method="post" action="libros_guardar.php">
      <label for="titulo">Título</label>
      <input id="titulo" name="titulo" type="text" maxlength="50" required>

      <label for="anyo_edicion">Año de edición</label>
      <input id="anyo_edicion" name="anyo_edicion" type="number" min="0" required>

      <label for="precio">Precio (€)</label>
      <input id="precio" name="precio" type="text" required>

      <label for="fecha_adquisicion">Fecha de adquisición</label>
      <input id="fecha_adquisicion" name="fecha_adquisicion" type="date" required>

      <div class="actions">
        <button type="submit">Guardar</button>
        <a href="libros_datos.php">Ver libros</a>
      </div>
    </form>
  </main>
</body>
</html>