<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Clases\ConexionBD;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$pdo = ConexionBD::getConexion();

$msg = '';
$peliculaEditar = null;

// --------------------
// CREAR PELÍCULA
// --------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
    $titulo = trim($_POST['titulo'] ?? '');
    $precio = (float)($_POST['precio'] ?? 0);

    if ($titulo !== '' && $precio >= 0) {
        $stmt = $pdo->prepare(
            'INSERT INTO peliculas (titulo, precio) VALUES (:titulo, :precio)'
        );
        $stmt->execute([
            ':titulo' => $titulo,
            ':precio' => $precio
        ]);
        $msg = 'Película creada correctamente';
    }
}

// --------------------
// ELIMINAR PELÍCULA
// --------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $id = (int)($_POST['id'] ?? 0);

    if ($id > 0) {
        $stmt = $pdo->prepare(
            'DELETE FROM peliculas WHERE id = :id'
        );
        $stmt->execute([':id' => $id]);
        $msg = 'Película eliminada correctamente';
    }
}

// --------------------
// CARGAR PELÍCULA PARA EDITAR
// --------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $id = (int)($_POST['id'] ?? 0);

    if ($id > 0) {
        $stmt = $pdo->prepare(
            'SELECT id, titulo, precio FROM peliculas WHERE id = :id'
        );
        $stmt->execute([':id' => $id]);
        $peliculaEditar = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// --------------------
// ACTUALIZAR PELÍCULA
// --------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    $id = (int)($_POST['id'] ?? 0);
    $titulo = trim($_POST['titulo'] ?? '');
    $precio = (float)($_POST['precio'] ?? 0);

    if ($id > 0 && $titulo !== '' && $precio >= 0) {
        $stmt = $pdo->prepare(
            'UPDATE peliculas SET titulo = :titulo, precio = :precio WHERE id = :id'
        );
        $stmt->execute([
            ':titulo' => $titulo,
            ':precio' => $precio,
            ':id' => $id
        ]);
        $msg = 'Película actualizada correctamente';
    }
}

// --------------------
// LISTADO
// --------------------
$stmt = $pdo->query('SELECT id, titulo, precio FROM peliculas');
$peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Películas</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family:Arial;margin:20px}
    table{border-collapse:collapse}
    td,th{padding:6px;border:1px solid #ddd}
  </style>
</head>
<body>

<h1>Películas</h1>
<a href="index.php">&larr; Volver</a>

<?php if ($msg): ?>
    <p style="color:green"><?= htmlspecialchars($msg) ?></p>
<?php endif; ?>

<!-- -------------------- -->
<!-- FORMULARIO CREAR / EDITAR -->
<!-- -------------------- -->
<h2><?= $peliculaEditar ? 'Editar película' : 'Crear película' ?></h2>

<form method="post" novalidate>
    <?php if ($peliculaEditar): ?>
        <input type="hidden" name="id" value="<?= (int)$peliculaEditar['id'] ?>">
    <?php endif; ?>

    <label>Título:
        <input name="titulo" required
               value="<?= htmlspecialchars($peliculaEditar['titulo'] ?? '') ?>">
    </label><br><br>

    <label>Precio:
        <input name="precio" type="number" step="0.01" min="0" required
               value="<?= htmlspecialchars((string)($peliculaEditar['precio'] ?? '')) ?>">
    </label><br><br>

    <?php if ($peliculaEditar): ?>
        <button type="submit" name="actualizar">Actualizar</button>
        <a href="peliculas.php">Cancelar</a>
    <?php else: ?>
        <button type="submit" name="crear">Crear</button>
    <?php endif; ?>
</form>

<!-- -------------------- -->
<!-- LISTADO -->
<!-- -------------------- -->
<h2>Listado</h2>

<?php if (empty($peliculas)): ?>
    <p>No hay películas.</p>
<?php else: ?>
<table>
<thead>
<tr>
    <th>ID</th>
    <th>Título</th>
    <th>Precio</th>
    <th>Acciones</th>
</tr>
</thead>
<tbody>
<?php foreach ($peliculas as $p): ?>
<tr>
    <td><?= (int)$p['id'] ?></td>
    <td><?= htmlspecialchars($p['titulo']) ?></td>
    <td><?= number_format((float)$p['precio'], 2) ?> €</td>
    <td>
        <form method="post" style="display:inline">
            <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
            <button type="submit" name="editar">Editar</button>
        </form>

        <form method="post" style="display:inline">
            <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
            <button type="submit" name="eliminar"
                onclick="return confirm('¿Eliminar película?')">
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
