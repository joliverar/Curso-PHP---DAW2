<?php

declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Clases\ConexionBD;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');

$dotenv -> load();

if($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST["reservar"])){
    header('Location: index.php');
    exit;
}
$nombre = trim((string)$_POST['nombre']?? '');
$dni = trim((string)$_POST['dni']??'');
$plaza = (int)($_POST['plaza'] ?? 0);
$msg = '';
if($nombre === '' || $dni ==='' || $plaza <= 0){
    $msg = "Todos los datos son obligatorios";
} else {
try {
    $pdo = ConexionBD::getConexion();

    $stmt = $pdo->prepare('CALL sp_reservar(:dni, :nombre, :numero)');

    $stmt -> execute([
        ':dni' => $dni,
        ':nombre' => $nombre,
        
        ':numero' => $plaza

    ]);

    $msg = "Se realizo la reserva $plaza con exito para $nombre con $dni";
} catch (PDOException $e) {
   if(strpos($e->getMessage(), 'DNI ya existe') !== false){
    $msg = "Error: Ya existe una reserva con elste DNI";
   } else {
        $msg = "Error: ".$e->getMessage();
   }
}
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar reserva</title>
</head>
<body>
    <main>
 
    <section class="msg">
            <?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?>
    </section>
 

    </main>
</body>
</html>