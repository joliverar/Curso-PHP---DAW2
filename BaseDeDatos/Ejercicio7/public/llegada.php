<?php

declare(strict_types=1);

require_once __DIR__ .'/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Clases\ConexionBD;

$dotenv = Dotenv::createImmutable(__DIR__ .'/../');
$dotenv  -> load();
$msg = '';

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['llegada'])){
    try {
        $pdo = ConexionBD::getConexion();
        $pdo ->beginTransaction();
        $pdo ->exec('delete from pasajeros');
        $pdo ->exec('update plazas set reservada = 0');
        $pdo ->commit();
        $msg = 'Se limpio las reservas';
    } catch (PDOException $e) {
        if($pdo -> inTransaction()){
            $pdo ->rollBack();
        }
        $msg = 'Error: '. $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar llegada</title>
</head>
<body>
    <main>

    <?php if($msg !== ''): ?>
    <section class="msg <?= strpos($msg, 'Error')=== 0?"error":"success" ?>">
            <?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?>
    </section>
        <?php endif; ?>

     <section class="">
           <form method="post" action="llegada.php" onsubmit="return confirm('desea confirmar la llegada')">
            <button type="submit" name="llegada" >Confirma llegada</button>
            <a href="index.php">Volver al inicio</a>
           </form>
    </section>   

    </main>
</body>
</html>