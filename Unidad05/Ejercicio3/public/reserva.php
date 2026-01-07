<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;
use App\Clases\ConexionBD;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$pdo = ConexionBD::getConexion();
$stmt = $pdo->query('SELECT numero, precio FROM plazas WHERE reservada = 0 ORDER BY numero');
$plazas = $stmt->fetchAll();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reservar plaza - Funicular Bulnes</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        :root{
            --bg:#f4f6f8;
            --card:#fff;
            --accent:#2b7cff;
            --muted:#6b7280;
            --text:#222;
            --radius:8px;
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
        .card{
            width:100%;
            max-width:720px;
            background:var(--card);
            border-radius:var(--radius);
            box-shadow:0 8px 24px rgba(0,0,0,0.06);
            padding:20px;
        }
        header{display:flex;gap:12px;align-items:center;margin-bottom:12px}
        .logo{
            width:48px;height:48px;border-radius:6px;background:var(--accent);color:#fff;
            display:flex;align-items:center;justify-content:center;font-weight:700;
        }
        h1{margin:0;font-size:18px}
        p.lead{margin:6px 0 14px;color:var(--muted);font-size:13px}

        form{display:grid;grid-template-columns:1fr 1fr;gap:12px}
        label{display:block;font-weight:600;margin-bottom:6px;font-size:13px;color:var(--muted)}
        input[type="text"],
        input[type="number"],
        select{
            width:100%;
            padding:10px 12px;
            border:1px solid #dbe3ef;
            border-radius:6px;
            font-size:14px;
            background:#fff;
        }
        .full{grid-column:1 / -1}
        .actions{display:flex;gap:8px;align-items:center;margin-top:10px}
        button{
            background:var(--accent);
            color:#fff;
            border:0;
            padding:10px 14px;
            border-radius:6px;
            font-weight:600;
            cursor:pointer;
        }
        a.link{margin-left:auto;color:var(--muted);text-decoration:none;font-size:14px}
        .note{font-size:13px;color:var(--muted);margin-top:10px}
        @media (max-width:640px){
            form{grid-template-columns:1fr}
            .actions{flex-direction:column}
            a.link{margin-left:0}
        }
    </style>
</head>
<body>
    <main class="card" role="main" aria-labelledby="title">
        <header>
            <div class="logo">FB</div>
            <div>
                <h1 id="title">Reservar plaza</h1>
                <p class="lead">Introduce DNI y nombre, y selecciona una plaza libre.</p>
            </div>
        </header>

        <?php if (empty($plazas)): ?>
            <p class="note">No hay plazas libres en este momento.</p>
            <p><a class="link" href="index.php">&larr; Volver al menú</a></p>
        <?php else: ?>
            <form method="post" action="reserva_procesar.php" novalidate>
                <div>
                    <label for="dni">DNI</label>
                    <input id="dni" name="dni" type="text" required maxlength="12" pattern="[A-Za-z0-9\-]{3,12}" title="DNI">
                </div>

                <div>
                    <label for="nombre">Nombre</label>
                    <input id="nombre" name="nombre" type="text" required maxlength="25">
                </div>

                <div class="full">
                    <label for="plaza">Plaza</label>
                    <select id="plaza" name="plaza" required>
                        <option value="">-- Selecciona plaza --</option>
                        <?php foreach ($plazas as $p): ?>
                            <option value="<?= (int)$p['numero'] ?>">Plaza <?= (int)$p['numero'] ?> — €<?= htmlspecialchars((string)$p['precio'], ENT_QUOTES, 'UTF-8') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="full actions">
                    <button type="submit" name="reservar">Reservar plaza</button>
                    <a class="link" href="index.php">&larr; Volver al menú</a>
                </div>
                <div class="full note">Nota: el campo sexo se guardará por defecto como "-" y la reserva se realiza en transacción.</div>
            </form>
        <?php endif; ?>
    </main>
</body>
</html>