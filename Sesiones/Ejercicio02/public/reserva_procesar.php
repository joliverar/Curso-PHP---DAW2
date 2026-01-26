<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;
use App\Clases\ConexionBD;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['reservar'])) {
    header('Location: reserva.php');
    exit;
}

$dni = trim((string)($_POST['dni'] ?? ''));
$nombre = trim((string)($_POST['nombre'] ?? ''));
$plaza = isset($_POST['plaza']) ? (int)$_POST['plaza'] : 0;
$msg = '';

if ($dni === '' || $nombre === '' || $plaza <= 0) {
    $msg = 'Faltan datos.';
} else {
    $pdo = ConexionBD::getConexion();
    try {
        $stmt = $pdo->prepare('CALL sp_reservar(:dni, :nombre, :numero)');
        $stmt->execute([':dni' => $dni, ':nombre' => $nombre, ':numero' => $plaza]);
        $msg = "Plaza reservada: $plaza para $nombre (DNI $dni).";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'DNI ya existe') !== false) {
            $msg = 'Error: ya existe un pasajero con ese DNI.';
        } else {
            $msg = 'Error al reservar: ' . $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><title>Resultado reserva</title></head>
<body>
    <h1>Resultado reserva</h1>
    <p><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></p>
    <p><a href="reserva.php">&larr; Volver a reservas</a></p>
    <p><a href="index.php">&larr; Menú</a></p>
</body>
</html>