<?php
/* 
 * index.php
 * - Índice de ejercicios para navegar desde el navegador.
 */
header('Content-Type: text/html; charset=UTF-8');
$archivos = [
  "holamundo.php" => "1) Hola mundo + HTML",
  "variable1.php" => "2) Interpolación y explicación con h1/h2/p",
  "variable2.php" => "3) Cadenas y concatenación",
  "variable3.php" => "4) Cadenas en negrita",
  "variable4.php" => "5) Tipos básicos y salida",
  "variable7.php" => "7) Tipo de resultado int+float",
  "suma.php" => "8) Suma de dos números",
  "par_impar.php" => "9) Par o impar",
  "tipos_is.php" => "10) is_int, is_float, is_string, is_bool",
  "variables_definidas.php" => "11) Verificar variables definidas (isset/empty)",
  "fecha_hora_actual.php" => "12) Fecha y hora actual",
  "zona_horaria_getdate.php" => "13) Zona horaria + getdate()",
  "comparar_fechas.php" => "14) Comparar fechas con strtotime() (ternario)",
  "dia_semana.php" => "15) Día de la semana de una fecha",
  "edad_aproximada.php" => "16) Calcular edad aproximada",
  "suma_global.php" => "17) Función con 'global'",
  "suma_globals_array.php" => "18) Función con $GLOBALS",
  "contador_llamadas.php" => "19) Función con 'static' (contador)"
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Índice de ejercicios PHP</title>
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; padding: 2rem; }
    h1 { margin-top: 0; }
    ol { line-height: 1.9; }
    a { text-decoration: none; }
    a:hover { text-decoration: underline; }
    code { background: #f4f4f4; padding: .15rem .35rem; border-radius: 4px; }
  </style>
</head>
<body>
  <h1>Índice de ejercicios PHP (básicos)</h1>
  <p>Haz clic en un ejercicio para ejecutarlo:</p>
  <ol>
    <?php foreach ($archivos as $file => $label): ?>
      <li><a href="<?= htmlspecialchars($file, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></a></li>
    <?php endforeach; ?>
  </ol>

  <hr>
  <h2>Cómo ejecutar con el servidor embebido de PHP</h2>
  <pre><code>php -S localhost:8000 -t <?= basename(__DIR__) ?></code></pre>
  <p>Luego abre: <a href="http://localhost:8000/index.php">http://localhost:8000/index.php</a></p>
</body>
</html>
