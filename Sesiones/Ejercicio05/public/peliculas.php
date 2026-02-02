<?php declare(strict_types=1);

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use App\Clases\ConexionBD;
use Dotenv\Dotenv;

Dotenv::createImmutable(__DIR__ . '/../')->safeLoad();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$pdo = ConexionBD::getConexion();
$peliculas = $pdo->query('SELECT * FROM peliculas')->fetchAll();

$cookieName = 'last_vist';
$prevtimestamp = isset($_COOKIE[$cookieName]) ? (int) $_COOKIE[$cookieName] : 0;

$lastVisitMsg = '';

if ($prevtimestamp === 0) {
    $lastVisitMsg = 'Bien venido es su primera visita';
} else {
    $lastVisitMsg = 'Bienvenido su ultima visita fue ' . date('d/m/Y H:i:s', $prevtimestamp);
}

setcookie($cookieName, (string) time(), [
    'expires' => time() + 30 * 60 * 60 * 24,
    'path' => '/',
    'httponly' => true,
    'samesite' => 'lax'
]);

?>
<!DOCTYPE html>
<html>
<body>

<h2>Películas</h2>

<p><?= htmlspecialchars($lastVisitMsg) ?></p>

<?php if (isset($_SESSION['flash'])): ?>
<p><?= $_SESSION['flash'] ?></p>
<?php unset($_SESSION['flash']);
endif; ?>

<ul>
<?php foreach ($peliculas as $p): ?>
<li>
<?= htmlspecialchars($p['titulo']) ?>
<a href="reserva.php?pelicula_id=<?= $p['id'] ?>">Reservar</a>

</li>
<?php endforeach; ?>
</ul>

<a href="logout.php">Cerrar sesión</a>

</body>
</html>
