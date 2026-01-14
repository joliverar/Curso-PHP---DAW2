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
<link rel="stylesheet" href="css/style.css">

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