<?php

declare(strict_types=0);
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Clases\ConexionBD;

$doten = Dotenv::createImmutable(__DIR__ . '/../');

$doten -> load();

$pdo = ConexionBD::getConexion();
$stmt = $pdo->query('select numero, precio from plazas where reservada = 0 order by numero');
$plaza = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Reserva</title>
</head>
<body>
    <main>
        <?php if(empty($plaza)): ?>
    <section class="msg">
        
            <div style="color: red">No hay plazas dispnibles</div>
        

    </section>
    <?php else: ?>
    <section class="formulario">
    <form class="form" method="post" action="procesar_reserva.php">
        <label>Nombre</label>
        <input type="text" name="nombre">
        <label>DNI</label>
        <input type="text" name="dni">
        <label>Plaza</label>
        <select name="plaza">
            <option value="">seleccionar una plaza</option>
            <?php foreach($plaza as $p): ?>
            <option value="<?=(int)$p['numero'] ?>"> Numero:  <?=  (int)$p['numero'] ?> - Precio: <?=htmlspecialchars((string)$p['precio'], ENT_QUOTES, 'UTF-8') ?></option>
            <?php endforeach; ?>
        </select>
       <button type="submit" name="reservar">Reservar</button>
       
    </form>
    </section>
    <?php endif; ?>
    </main>
</body>
</html>