<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Clases\ConexionBD;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$pdo = ConexionBD::getConexion();

$msg = '';
$salaEditar = null;

// --------------------
// CREAR SALA
// --------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {

    $nombre = trim($_POST['nombre'] ?? '');
    $aforo_total = (int)($_POST['aforo_total'] ?? 0);
    $pelicula_id = (int)($_POST['pelicula_id'] ?? 0);

    if ($nombre !== '' && $aforo_total > 0 && $pelicula_id > 0) {

        // En examen: aforo_libre = aforo_total
        $stmt = $pdo->prepare(
            'INSERT INTO salas (nombre, aforo_total, aforo_libre, pelicula_id)
             VALUES (:nombre, :aforo_total, :aforo_libre, :pelicula_id)'
        );

        $stmt->execute([
            ':nombre' => $nombre,
            ':aforo_total' => $aforo_total,
            ':aforo_libre' => $aforo_total,
            ':pelicula_id' => $pelicula_id
        ]);

        $msg = 'Sala creada correctamente';
    }
}

// --------------------
// ELIMINAR SALA
// --------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {

    $id = (int)($_POST['id'] ?? 0);

    if ($id > 0) {
        $stmt = $pdo->prepare('DELETE FROM salas WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $msg = 'Sala eliminada correctamente';
    }
}

// --------------------
// CARGAR SALA PARA EDITAR
// --------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {

    $id = (int)($_POST['id'] ?? 0);

    if ($id > 0) {
        $stmt = $pdo->prepare(
            'SELECT id, nombre, aforo_total, pelicula_id
             FROM salas WHERE id = :id'
        );
        $stmt->execute([':id' => $id]);
        $salaEditar = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// --------------------
// ACTUALIZAR SALA
// --------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {

    $id = (int)($_POST['id'] ?? 0);
    $nombre = trim($_POST['nombre'] ?? '');
    $aforo_total = (int)($_POST['aforo_total'] ?? 0);
    $pelicula_id = (int)($_POST['pelicula_id'] ?? 0);

    if ($id > 0 && $nombre !== '' && $aforo_total > 0 && $pelicula_id > 0) {

        // Ajustamos aforo_libre al nuevo total (criterio examen)
        $stmt = $pdo->prepare(
            'UPDATE salas
             SET nombre = :nombre,
                 aforo_total = :aforo_total,
                 aforo_libre = :aforo_libre,
                 pelicula_id = :pelicula_id
             WHERE id = :id'
        );

        $stmt->execute([
            ':nombre' => $nombre,
            ':aforo_total' => $aforo_total,
            ':aforo_libre' => $aforo_total,
            ':pelicula_id' => $pelicula_id,
            ':id' => $id
        ]);

        $msg = 'Sala actualizada correctamente';
    }
}

// --------------------
// LISTADOS
// --------------------

// Salas + título de película (JOIN = punto extra)
$stmt = $pdo->query(
    'SELECT s.id, s.nombre, s.aforo_total, s.aforo_libre,
            p.titulo AS pelicula
     FROM salas s
     LEFT JOIN peliculas p ON s.pelicula_id = p.id'
);
$salas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Películas para el select
$stmt = $pdo->query('SELECT id, titulo FROM peliculas');
$peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Salas</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family:Arial;margin:20px}
    table{border-collapse:collapse}
    td,th{padding:6px;border:1px solid #ddd}
  </style>
</head>
<body>

<h1>Salas</h1>
<a href="index.php">&larr; Volver</a>

<?php if ($msg): ?>
    <p style="color:green"><?= htmlspecialchars($msg) ?></p>
<?php endif; ?>

<!-- -------------------- -->
<!-- FORMULARIO CREAR / EDITAR -->
<!-- -------------------- -->
<h2><?= $salaEditar ? 'Editar sala' : 'Crear sala' ?></h2>

<form method="post" novalidate>
    <?php if ($salaEditar): ?>
        <input type="hidden" name="id" value="<?= (int)$salaEditar['id'] ?>">
    <?php endif; ?>

    <label>Nombre:
        <input name="nombre" required
               value="<?= htmlspecialchars($salaEditar['nombre'] ?? '') ?>">
    </label><br><br>

    <label>Aforo total:
        <input name="aforo_total" type="number" min="1" required
               value="<?= htmlspecialchars((string)($salaEditar['aforo_total'] ?? '')) ?>">
    </label><br><br>

    <label>Película:
        <select name="pelicula_id" required>
            <option value="">Seleccionar</option>
            <?php foreach ($peliculas as $p): ?>
                <option value="<?= (int)$p['id'] ?>"
                    <?= isset($salaEditar) && $salaEditar['pelicula_id'] == $p['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['titulo']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br><br>

    <?php if ($salaEditar): ?>
        <button type="submit" name="actualizar">Actualizar</button>
        <a href="salas.php">Cancelar</a>
    <?php else: ?>
        <button type="submit" name="crear">Crear</button>
    <?php endif; ?>
</form>

<!-- -------------------- -->
<!-- LISTADO -->
<!-- -------------------- -->
<h2>Listado</h2>

<?php if (empty($salas)): ?>
    <p>No hay salas.</p>
<?php else: ?>
<table>
<thead>
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Aforo total</th>
    <th>Aforo libre</th>
    <th>Película</th>
    <th>Acciones</th>
</tr>
</thead>
<tbody>
<?php foreach ($salas as $s): ?>
<tr>
    <td><?= (int)$s['id'] ?></td>
    <td><?= htmlspecialchars($s['nombre']) ?></td>
    <td><?= (int)$s['aforo_total'] ?></td>
    <td><?= (int)$s['aforo_libre'] ?></td>
    <td><?= htmlspecialchars($s['pelicula'] ?? '-') ?></td>
    <td>
        <form method="post" style="display:inline">
            <input type="hidden" name="id" value="<?= (int)$s['id'] ?>">
            <button type="submit" name="editar">Editar</button>
        </form>

        <form method="post" style="display:inline">
            <input type="hidden" name="id" value="<?= (int)$s['id'] ?>">
            <button type="submit" name="eliminar"
                onclick="return confirm('¿Eliminar sala?')">
                Eliminar
            </button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php endif; ?>

</body>
</html>
