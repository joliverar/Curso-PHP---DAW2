<?php 
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;
use App\Clases\ConexionBD;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv ->load();
$conexionOK = false;
$msg = '';
try {
    //code...
    $pdo = ConexionBD::getConexion();
    
    $stmt =$pdo->query('select * from plazas');
    $plazas =$stmt->fetchAll();
    $conexionOK = true;
} catch (PDOException $e) {
    //throw $th;
    $msg = 'Error'.$e->getMessage();
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
    <header>
        
        <nav>
        <div><h2>Reservar plazas</h2><a href="reservar.php">reservar</a></div>
        <div><h2>Gestionar plazas</h2><a href="plazas.php">plazas</a></div>
        <div><h2>Confirmar llegada</h2><a href="llegada.php">Legada</a></div>
    </nav>
</header>
<main>
    <section>
        <?php if($conexionOK):?>
            <div style="color: green">Base de datos conectada</div>
        <?php else: ?>
            <div style="color: red">Error en la conexion</div>
        <?php endif; ?>
    </section>
</main>
</body>
</html>