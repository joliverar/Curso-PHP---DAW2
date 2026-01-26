<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Funicular Bulnes</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        /* Estilos básicos y limpios */
        :root{
            --bg:#f4f6f8;
            --card:#ffffff;
            --accent:#2b7cff;
            --text:#222;
            --muted:#666;
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
        .wrap{
            width:100%;
            max-width:860px;
            background:var(--card);
            border-radius:var(--radius);
            box-shadow:0 6px 18px rgba(0,0,0,0.06);
            padding:20px;
        }
        header{display:flex;gap:12px;align-items:center;margin-bottom:12px}
        .logo{
            width:48px;height:48px;border-radius:6px;background:var(--accent);color:#fff;
            display:flex;align-items:center;justify-content:center;font-weight:700;
        }
        h1{font-size:18px;margin:0}
        p.lead{margin:4px 0 0;color:var(--muted);font-size:13px}

        .menu{display:flex;gap:12px;margin-top:16px;flex-wrap:wrap}
        .item{
            flex:1 1 220px;
            background:#fafafa;
            border:1px solid #eee;
            padding:14px;
            border-radius:6px;
        }
        .item h3{margin:0 0 6px;font-size:15px}
        .item p{margin:0;color:var(--muted);font-size:13px}
        .item .actions{margin-top:10px}
        a.btn{
            display:inline-block;padding:8px 12px;border-radius:6px;background:var(--accent);
            color:#fff;text-decoration:none;font-weight:600;font-size:13px;
        }
        footer{margin-top:14px;text-align:right;color:var(--muted);font-size:13px}
        @media (max-width:600px){
            header{flex-direction:column;align-items:flex-start}
            .menu{flex-direction:column}
            footer{text-align:left}
        }
    </style>
</head>
<body>
    <main class="wrap" aria-labelledby="title">
        <header>
            <div class="logo">FB</div>
            <div>
                <h1 id="title">Funicular Bulnes</h1>
                <p class="lead">Reservas, llegada y gestión de plazas.</p>
            </div>
        </header>

        <nav class="menu" aria-label="Menú principal">
            <div class="item" role="region" aria-labelledby="r1">
                <h3 id="r1">Reservar plaza</h3>
                <p>Reservar una plaza libre con DNI y nombre.</p>
                <div class="actions">
                    <a class="btn" href="reserva.php">Reservar</a>
                </div>
            </div>

            <div class="item" role="region" aria-labelledby="r2">
                <h3 id="r2">Llegada al destino</h3>
                <p>Borrar pasajeros y liberar todas las plazas (transacción).</p>
                <div class="actions">
                    <a class="btn" href="llegada.php">Llegada</a>
                </div>
            </div>

            <div class="item" role="region" aria-labelledby="r3">
                <h3 id="r3">Gestión de plazas</h3>
                <p>Ver y actualizar precios de las plazas.</p>
                <div class="actions">
                    <a class="btn" href="plazas.php">Gestionar</a>
                </div>
            </div>
        </nav>

        <footer>&copy; <?= date('Y') ?> Funicular Bulnes</footer>
    </main>
</body>
</html>