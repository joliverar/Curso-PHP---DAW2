<?php
// Activa el modo estricto de tipos en PHP.
// Evita conversiones automáticas peligrosas y mejora la calidad del código.
declare(strict_types=1);

session_start();
if (empty($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// Carga el autoload de Composer.
// Permite usar clases propias y librerías externas sin hacer require manuales.
require_once __DIR__ . '/../vendor/autoload.php';

// Importamos las clases que vamos a utilizar
use App\Clases\ConexionBD;  // Clase que gestiona la conexión a la base de datos
use Dotenv\Dotenv;  // Clase para cargar variables de entorno desde .env

// Creamos una instancia de Dotenv indicando la ruta donde se encuentra el archivo .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');

// Cargamos las variables del archivo .env en la superglobal $_ENV
$dotenv->load();

// Obtenemos la conexión a la base de datos mediante la clase ConexionBD
// Se usa PDO y el patrón Singleton para reutilizar la conexión
$pdo = ConexionBD::getConexion();

// Ejecutamos una consulta SQL para obtener las plazas que no están reservadas
// Solo se seleccionan el número de plaza y su precio
$stmt = $pdo->query(
    'SELECT numero, precio FROM plazas WHERE reservada = 0 ORDER BY numero'
);

// Recuperamos todos los resultados de la consulta en un array asociativo
// Cada elemento del array representa una plaza libre
$plazas = $stmt->fetchAll();

$cookieName = 'last_visit';
$prevTimestamp = isset($_COOKIE[$cookieName]) ? (int) $_COOKIE[$cookieName] : 0;
$lastVisitMsg = '';

if ($prevTimestamp === 0) {
    $lastVisitMsg = 'Bienvenido es su prmera vez en la plataforma';
} else {
    $lastVisitMsg = 'Bienvenido, su ultima visita fue el ' . date('d/m/Y H:i:s', $prevTimestamp);
}

setcookie($cookieName, (string) time(), [
    'expires' => time() + 60 * 60 * 30 * 24,
    'path' => '/',
    'httponly' => '',
    'samesite' => 'lax'
]);
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
        <p style="color: green;"><?= htmlspecialchars($lastVisitMsg) ?></p>
        <a href="logout.php">Salir</a>
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
                            <option value="<?= (int) $p['numero'] ?>">Plaza <?= (int) $p['numero'] ?> — €<?= htmlspecialchars((string) $p['precio'], ENT_QUOTES, 'UTF-8') ?></option>
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