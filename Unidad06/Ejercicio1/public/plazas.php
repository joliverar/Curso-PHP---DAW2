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
    <style>
        :root{
            --bg: #f4f6f8;
            --card: #ffffff;
            --accent: #2b7cff;
            --muted: #6b7280;
            --text: #222;
            --radius: 8px;
        }
        *{box-sizing:border-box}
        body{
            margin:0;
            font-family: Arial, Helvetica, sans-serif;
            background:var(--bg);
            color:var(--text);
            -webkit-font-smoothing:antialiased;
            display:flex;
            align-items:center;
            justify-content:center;
            min-height:100vh;
            padding:20px;
        }
        .container{
            width:100%;
            max-width:980px;
            background:var(--card);
            border-radius:var(--radius);
            box-shadow:0 8px 24px rgba(0,0,0,0.06);
            padding:20px;
        }
        header{display:flex;align-items:center;gap:12px;margin-bottom:14px}
        .logo{
            width:48px;height:48px;border-radius:6px;background:var(--accent);color:#fff;
            display:flex;align-items:center;justify-content:center;font-weight:700;
        }
        h1{margin:0;font-size:18px}
        p.lead{margin:6px 0 0;color:var(--muted);font-size:13px}

        .msg{
            padding:12px;border-radius:6px;margin:12px 0;
            font-size:14px;
        }
        .msg.success{background:#e9f7ef;border:1px solid #c7eed4;color:#124825}
        .msg.error{background:#fff3f2;border:1px solid #f3c6c2;color:#7a1b1b}

        table{width:100%;border-collapse:collapse;margin-top:12px}
        th, td{padding:10px 12px;border-bottom:1px solid #eef1f4;text-align:left}
        thead th{background:#fbfdff;color:var(--muted);font-weight:600;font-size:13px}
        tr:last-child td{border-bottom:none}
        input[type="text"]{
            padding:8px 10px;border:1px solid #dbe3ef;border-radius:6px;width:100%;
            font-size:14px;
        }

        .controls{display:flex;gap:10px;align-items:center;margin-top:12px}
        button{
            background:var(--accent);color:#fff;border:0;padding:10px 14px;border-radius:6px;
            font-weight:600;cursor:pointer;
        }
        a.link{color:var(--muted);text-decoration:none;margin-left:auto;font-size:14px}
        @media (max-width:720px){
            table, thead, tbody, th, td, tr{display:block}
            thead{display:none}
            tr{margin-bottom:10px;border-bottom:1px dashed #e6edf6;padding-bottom:10px}
            td{padding:6px 0}
            td:before{content:attr(data-label);display:block;font-weight:600;color:var(--muted);margin-bottom:6px}
            .controls{flex-direction:column;align-items:stretch}
            a.link{margin-left:0}
        }
    </style>
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