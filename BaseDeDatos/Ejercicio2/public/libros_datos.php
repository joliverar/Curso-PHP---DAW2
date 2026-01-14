<?php
declare(strict_types=1);

//Ver archivo leer
require_once __DIR__ . '/../app/bootstrap.php';

use function App\Helpers\obtenerLibros;


$rows = [];
$error = '';
try {
    $rows = obtenerLibros();
} catch (\Exception $e) {
    $error = $e->getMessage();
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Libros - Datos</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family:Arial,Helvetica,sans-serif;background:#f6f8fb;padding:20px;color:#222}
    .card{max-width:960px;margin:0 auto;background:#fff;padding:18px;border-radius:8px;box-shadow:0 6px 20px rgba(0,0,0,.06)}
    table{width:100%;border-collapse:collapse}
    th, td{padding:10px;border-bottom:1px solid #eef1f4;text-align:left}
    th{background:#fbfdff;color:#666}
    caption{font-weight:600;margin-bottom:8px;text-align:left}
    .no-data{padding:12px;color:#666}
    a{color:#2b7cff;text-decoration:none}
  </style>
</head>
<body>
  <main class="card">
    <h1>Listado de libros</h1>
    <?php if (!empty($error)): ?>
        <div class="no-data">Error al obtener los datos: <?= htmlspecialchars($error) ?></div>
    <?php elseif (empty($rows)): ?>
        <div class="no-data">No hay libros en la base de datos.</div>
    <?php else: ?>
        <table aria-describedby="Listado de libros">
            <caption>Libros registrados</caption>
            <thead>
                <tr>
                    <th>Núm. ejemplar</th>
                    <th>Título</th>
                    <th>Año edición</th>
                    <th>Precio (€)</th>
                    <th>Fecha adquisición</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r): ?>
                    <tr>
                        <td><?= (int)($r['numero_ejemplar'] ?? 0) ?></td>
                        <td><?= htmlspecialchars((string)($r['titulo'] ?? '')) ?></td>
                        <td><?= (int)($r['anyo_edicion'] ?? 0) ?></td>
                        <td><?= htmlspecialchars(number_format((float)($r['precio'] ?? 0), 2, '.', '')) ?></td>
                        <td><?= htmlspecialchars((string)($r['fecha_adquisicion'] ?? '')) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p style="margin-top:12px"><a href="index.php">&larr; Volver al formulario</a></p>
  </main>
</body>
</html>