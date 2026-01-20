<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Clases\ConexionBD;
use PHPUnit\Event\Test\Prepared;

$doten = Dotenv::createImmutable(__DIR__ . '/../');

$doten ->load();

$pdo = ConexionBD::getConexion();
$msg = '';
try {
    $stmt = $pdo -> query('
    select count(*) from plazas;

    ');

    $total = $stmt->fetchColumn();

} catch (PDOException $e) {
    //throw $th;
    $msg = "Error en la coxion: ".$e->getMessage();

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if($msg !== ''): ?>
    <p> <?= htmlspecialchars($smg, ENT_QUOTES, 'UTF-8') ?></p>
    <?php else: ?>
    <p><?= (int)$total ?></p>
    <p style="color:green">✔ Conexión a la base de datos correcta</p>
    <?php endif; ?>
<header>
    <nav>
        <div>
            <h2>Reservar Plazas</h2>
        <a href="reservar.php">Reservar</a>
    </div>
        <div><h2>Gestion de Plazas</h2><a href="plazas.php">Plazas disponibles</a></div>
        <div><h2>Llegada a destino</h2><a href="llegada.php">Legada</a></div>
        
    </nav>
</header>
   
</body>
</html>