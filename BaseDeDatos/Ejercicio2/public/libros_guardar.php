<?php
declare(strict_types=1);

//Ver archivo leer
require_once __DIR__ . '/../app/bootstrap.php';

use function App\Helpers\insertarLibro;


function redirectLink(string $url, string $text = 'Volver') {
    echo '<p><a href="'.htmlspecialchars($url).'">'.$text.'</a></p>';
}

$errors = [];

// Recibir y sanitizar entrada
$titulo = trim($_POST['titulo'] ?? '');
$anyo_edicion = trim($_POST['anyo_edicion'] ?? '');
$precio = trim($_POST['precio'] ?? '');
$fecha_adquisicion = trim($_POST['fecha_adquisicion'] ?? '');

// Validaciones
if ($titulo === '') {
    $errors[] = 'El título es obligatorio.';
} elseif (mb_strlen($titulo) > 50) {
    $errors[] = 'El título no puede superar 50 caracteres.';
}

if ($anyo_edicion === '' || !ctype_digit(str_replace('-', '', $anyo_edicion))) {
    $errors[] = 'El año de edición es obligatorio y debe ser un número entero.';
} else {
    $anio = (int)$anyo_edicion;
    if ($anio < 0 || $anio > 9999) $errors[] = 'Año de edición fuera de rango.';
}

if ($precio === '' || !preg_match('/^\d+(\.\d{1,2})?$/', $precio)) {
    $errors[] = 'Precio no válido. Debe ser un número con hasta 2 decimales.';
} else {
    $precioFloat = (float) $precio;
    if ($precioFloat <= 0) $errors[] = 'El precio debe ser mayor que cero.';
}

if ($fecha_adquisicion === '') {
    $errors[] = 'Fecha de adquisición obligatoria.';
} else {
    $parts = explode('-', $fecha_adquisicion);
    if (count($parts) !== 3) {
        $errors[] = 'Fecha con formato incorrecto.';
    } else {
        [$y, $m, $d] = $parts;
        if (!ctype_digit($y) || !ctype_digit($m) || !ctype_digit($d) || !checkdate((int)$m, (int)$d, (int)$y)) {
            $errors[] = 'Fecha de adquisición no es una fecha válida.';
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Libros - Guardar</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family:Arial,Helvetica,sans-serif;background:#f6f8fb;padding:20px}
    .card{max-width:720px;margin:0 auto;background:#fff;padding:18px;border-radius:8px;box-shadow:0 6px 20px rgba(0,0,0,.06)}
    .ok{background:#e9f7ef;border:1px solid #c7eed4;color:#124825;padding:12px;border-radius:6px}
    .error{background:#fff2f2;border:1px solid #f2c2c2;color:#7a1b1b;padding:12px;border-radius:6px}
    a{color:#2b7cff;text-decoration:none}
  </style>
</head>
<body>
  <main class="card">
<?php
if (!empty($errors)) {
    echo '<div class="error"><strong>Errores:</strong><ul>';
    foreach ($errors as $e) {
        echo '<li>' . htmlspecialchars($e) . '</li>';
    }
    echo '</ul></div>';
    redirectLink('index.php', 'Volver al formulario');
    echo '</main></body></html>';
    exit;
}

$data = [
    'titulo' => $titulo,
    'anyo_edicion' => (int)$anyo_edicion,
    'precio' => number_format((float)$precio, 2, '.', ''),
    'fecha_adquisicion' => $fecha_adquisicion,
];

try {
    $ok = insertarLibro($data);
    if ($ok) {
        echo '<div class="ok">Datos guardados correctamente.</div>';
    } else {
        echo '<div class="error">No se han podido guardar los datos.</div>';
    }
} catch (\Exception $ex) {
    echo '<div class="error">Error al guardar: ' . htmlspecialchars($ex->getMessage()) . '</div>';
}

redirectLink('index.php', 'Volver al formulario');
redirectLink('libros_datos.php', 'Ver todos los libros');
?>
  </main>
</body>
</html>