<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;
use App\Clases\ConexionBD;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = ConexionBD::getConexion();
    try {
        $pdo->beginTransaction();
        $pdo->exec('DELETE FROM pasajeros');
        $pdo->exec('UPDATE plazas SET reservada = 0');
        $pdo->commit();
        $msg = 'Operación realizada: pasajeros borrados y plazas liberadas.';
    } catch (PDOException $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        $msg = 'Error: ' . $e->getMessage();
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Llegada - Funicular Bulnes</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="css/style.css">

</head>
<body>
    <main class="card" role="main" aria-labelledby="title">
        <h1 id="title">Llegada al destino</h1>
        <p class="lead">Al confirmar la llegada se eliminarán los pasajeros y se liberarán todas las plazas.</p>

        <?php if ($msg !== ''): ?>
            <div class="msg <?= strpos($msg, 'Error') === 0 ? 'error' : 'success' ?>" role="status">
                <?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="post" action="llegada.php" onsubmit="return confirm('¿Confirmas que el funicular ha llegado y deseas vaciar pasajeros y liberar plazas?');">
            <button type="submit" name="llegada">Confirmar llegada</button>
            <a class="link" href="index.php" style="margin-left:auto;align-self:center;">Volver al menú</a>
        </form>

        <div class="meta">Operación realizada dentro de una transacción. Asegúrate de tener copias si hace falta.</div>
    </main>
</body>
</html>