<?php
declare(strict_types=1);
require_once __DIR__ .'/../vendor/autoload.php';
use Dotenv\Dotenv;
use App\Clases\ConexionBD;

$doten = Dotenv::createImmutable(__DIR__ .'/../');
$doten ->load();

$pdo = ConexionBD::getConexion();
$smtp = $pdo->query(
    'select numero, precio from plazas where reservada = 0 order by numero'
);
$plazas = $smtp->fetchAll();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar</title>
</head>
<body>
    <main>
    <section>
        <div></div>
        <div>
        <form method="post" action="reservar.php">
            <label>Nombre</label>
            <input name="nombre" type="text" required>
            <label>DNI</label>
            <input name="dni" type="text" required>
            <label>Plaza</label>
            <select name="plaza" required>
                <option valu="">Seleccionar plaza</option>
                <?php foreach ($plazas as $p): ?>
                    # code...
                    <option value="<?= (int)$p['numero'] ?>">
                        Numero: <?= (int)$p['numero']?> - Numero: <?= htmlspecialchars((string)$p['precio'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                
                <?php endforeach; ?>
            </select>
            <button type="submit" name="reservar">Reservar</button>
        </form>
        </div>   
            


    </section>
</main>
</body>
</html>