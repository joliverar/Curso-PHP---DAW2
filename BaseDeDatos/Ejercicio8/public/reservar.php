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

$nombre = trim((string)($_POST['nombre'] ?? ''));
$dni    = trim((string)($_POST['dni'] ?? ''));
$plaza  = (int)($_POST['plaza'] ?? 0);

$msg = '';

if ($nombre === '' || $dni === '' || $plaza <= 0) {
    $msg = "Todos los datos son obligatorios";
} else {
    try {
        $pdo = ConexionBD::getConexion();

        $stmt = $pdo->prepare(
            'CALL sp_reservar(:nombre, :dni, :numero)'
        );

        $stmt->execute([
            ':nombre' => $nombre,
            ':dni'    => $dni,
            ':numero' => $plaza
        ]);

        $msg = "La reserva fue exitosa para $nombre";

    } catch (PDOException $e) {

        if (strpos($e->getMessage(), 'DNI existe') !== false) {
            $msg = 'Ya existe una reserva con ese DNI';
        } else {
            $msg = 'Error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado reserva</title>
</head>
<body>
<main>
    <section>
        <div>
            <?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?>
        </div>
    </section>
</main>
</body>
</html>
