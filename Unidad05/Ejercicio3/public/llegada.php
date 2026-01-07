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
    <style>
        /* Estilos básicos */
        :root{
            --bg:#f5f7fa;
            --card:#ffffff;
            --primary:#2b7cff;
            --muted:#555;
            --radius:8px;
        }
        *{box-sizing:border-box}
        body{
            margin:0;
            font-family: Arial, Helvetica, sans-serif;
            background:var(--bg);
            color:#222;
            display:flex;
            align-items:center;
            justify-content:center;
            min-height:100vh;
            padding:20px;
        }
        .card{
            width:100%;
            max-width:680px;
            background:var(--card);
            border-radius:var(--radius);
            box-shadow:0 6px 18px rgba(0,0,0,0.06);
            padding:20px;
        }
        h1{margin:0 0 8px;font-size:20px}
        p.lead{margin:0 0 16px;color:var(--muted)}
        .msg{
            padding:12px;
            border-radius:6px;
            margin-bottom:14px;
        }
        .msg.success{background:#e9f7ef;border:1px solid #c7eed4;color:#124825}
        .msg.error{background:#fff0f0;border:1px solid #f2c2c2;color:#7a1b1b}
        form{display:flex;gap:12px;align-items:center;flex-wrap:wrap}
        button{
            background:var(--primary);
            color:#fff;
            border:0;
            padding:10px 16px;
            border-radius:6px;
            cursor:pointer;
            font-weight:600;
        }
        a.link{color:var(--muted);text-decoration:none;font-size:14px}
        .meta{margin-top:12px;color:var(--muted);font-size:13px}
        @media (max-width:520px){
            .card{padding:14px}
            form{flex-direction:column;align-items:stretch}
            button{width:100%}
        }
    </style>
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