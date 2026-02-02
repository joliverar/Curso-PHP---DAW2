<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Clases\ConexionBD;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$pdo = ConexionBD::getConexion();

$stmt = $pdo->query('select count(*) from usuarios');
$conexionOk = false;
$msg = '';

try {
    if ($stmt->fetchColumn() > 0) {
        $conexionOk = true;
    }
} catch (\Throwable $th) {
    $th->getMessage();
}

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Funicular Bulnes</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
 <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <main class="wrap" aria-labelledby="title">
        <header>
            <div class="logo">FB</div>
            <div>
                <h1 id="title">Funicular Bulnes</h1>
                <p class="lead">Reservas, llegada y gestión de plazas.</p>
                <?php if ($conexionOk): ?>
                    <p style ="color:green">Conexion exitosa</p>
                <?php endif; ?>
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