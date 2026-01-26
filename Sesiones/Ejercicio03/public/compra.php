<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Clases\ConexionBD;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$pdo = ConexionBD::getConexion();

// Películas
$stmt = $pdo->query('SELECT id, titulo, precio FROM peliculas');
$peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Salas con aforo libre
$stmt = $pdo->query(
    'SELECT s.id, s.nombre, s.aforo_libre, s.pelicula_id, p.titulo
     FROM salas s
     JOIN peliculas p ON s.pelicula_id = p.id
     WHERE s.aforo_libre > 0'
);
$salas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Comprar entradas</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family:Arial;margin:20px}
  </style>
</head>
<body>

<h1>Comprar entradas</h1>
<a href="index.php">&larr; Volver</a>

<h2>Nueva compra</h2>

<form method="post" action="compra_procesa.php" novalidate>

    <label>Nombre comprador:
        <input name="nombre" required>
    </label><br><br>

    <label>Película:
        <select name="pelicula_id" required>
            <option value="">Seleccionar</option>
            <?php foreach ($peliculas as $p): ?>
                <option value="<?= (int)$p['id'] ?>">
                    <?= htmlspecialchars($p['titulo']) ?> (<?= (float)$p['precio'] ?> €)
                </option>
            <?php endforeach; ?>
        </select>
    </label><br><br>

    <label>Sala:
        <select name="sala_id" required>
            <option value="">Seleccionar</option>
            <?php foreach ($salas as $s): ?>
                <option value="<?= (int)$s['id'] ?>">
                    <?= htmlspecialchars($s['nombre']) ?>
                    (Libre: <?= (int)$s['aforo_libre'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </label><br><br>

    <label>Cantidad:
        <input type="number" name="cantidad" min="1" required>
    </label><br><br>

    <button type="submit">Comprar</button>
</form>

</body>
</html>
