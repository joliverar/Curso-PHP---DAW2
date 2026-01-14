<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;
use App\Clases\ConexionBD;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$pdo = ConexionBD::getConexion();
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    try {
        $pdo->beginTransaction();
        foreach ($_POST['precio'] as $numero => $precio) {
            $stmt = $pdo->prepare('UPDATE plazas SET precio = ? WHERE numero = ?');
            $stmt->execute([ (float)$precio, (int)$numero ]);
        }
        $pdo->commit();
        $msg = 'Precios actualizados.';
    } catch (PDOException $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        $msg = 'Error: ' . $e->getMessage();
    }
}

$plazas = $pdo->query('SELECT numero, reservada, precio FROM plazas ORDER BY numero')->fetchAll();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Gestión de plazas - Funicular Bulnes</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
 <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <main class="container" role="main" aria-labelledby="title">
        <header>
            <div class="logo">FB</div>
            <div>
                <h1 id="title">Gestión de plazas</h1>
                <p class="lead">Visualiza y actualiza los precios de las plazas del funicular.</p>
            </div>
        </header>

        <?php if ($msg !== ''): ?>
            <div class="msg <?= strpos($msg, 'Error') === 0 ? 'error' : 'success' ?>" role="status">
                <?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="post" action="plazas.php">
            <table aria-describedby="title">
                <thead>
                    <tr>
                        <th>Plaza</th>
                        <th>Reservada</th>
                        <th>Precio (€)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($plazas as $p): ?>
                        <tr>
                            <td data-label="Plaza"><?= (int)$p['numero'] ?></td>
                            <td data-label="Reservada"><?= ((int)$p['reservada']) ? 'Sí' : 'No' ?></td>
                            <td data-label="Precio">
                                <input type="text" name="precio[<?= (int)$p['numero'] ?>]" value="<?= htmlspecialchars((string)$p['precio'], ENT_QUOTES, 'UTF-8') ?>">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="controls">
                <button type="submit" name="actualizar">Actualizar precios</button>
                <a class="link" href="index.php">&larr; Volver al menú</a>
            </div>
        </form>
    </main>
</body>
</html>