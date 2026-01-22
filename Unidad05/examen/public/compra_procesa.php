<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Clases\ConexionBD;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$pdo = ConexionBD::getConexion();

$nombre = trim($_POST['nombre'] ?? '');
$pelicula_id = (int)($_POST['pelicula_id'] ?? 0);
$sala_id = (int)($_POST['sala_id'] ?? 0);
$cantidad = (int)($_POST['cantidad'] ?? 0);

$msg = '';

if ($nombre === '' || $pelicula_id <= 0 || $sala_id <= 0 || $cantidad <= 0) {
    die('Datos inválidos');
}

try {
    // --------------------
    // TRANSACCIÓN
    // --------------------
    $pdo->beginTransaction();

    // Precio película
    $stmt = $pdo->prepare(
        'SELECT precio FROM peliculas WHERE id = :id'
    );
    $stmt->execute([':id' => $pelicula_id]);
    $precio = (float)$stmt->fetchColumn();

    // Aforo libre
    $stmt = $pdo->prepare(
        'SELECT aforo_libre FROM salas WHERE id = :id FOR UPDATE'
    );
    $stmt->execute([':id' => $sala_id]);
    $aforo_libre = (int)$stmt->fetchColumn();

    if ($cantidad > $aforo_libre) {
        throw new Exception('No hay aforo suficiente');
    }

    $total = $cantidad * $precio;

    // Insertar venta
    $stmt = $pdo->prepare(
        'INSERT INTO ventas
        (nombre_comprador, pelicula_id, sala_id, cantidad, total)
        VALUES (:nombre, :pelicula, :sala, :cantidad, :total)'
    );
    $stmt->execute([
        ':nombre' => $nombre,
        ':pelicula' => $pelicula_id,
        ':sala' => $sala_id,
        ':cantidad' => $cantidad,
        ':total' => $total
    ]);

    // Actualizar aforo
    $stmt = $pdo->prepare(
        'UPDATE salas
         SET aforo_libre = aforo_libre - :cantidad
         WHERE id = :id'
    );
    $stmt->execute([
        ':cantidad' => $cantidad,
        ':id' => $sala_id
    ]);

    $pdo->commit();
    $msg = 'Compra realizada correctamente';

} catch (Exception $e) {
    $pdo->rollBack();
    $msg = 'Error en la compra: ' . $e->getMessage();
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Resultado compra</title>
</head>
<body>

<h1>Resultado</h1>

<p><?= htmlspecialchars($msg) ?></p>

<a href="compra.php">Volver</a>

</body>
</html>
