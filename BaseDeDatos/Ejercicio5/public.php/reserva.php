<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;
use App\Clases\ConexionBD;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$pdo = ConexionBD::getConexion();
$stmt = $pdo->query('SELECT numero, precio FROM plazas WHERE reservada = 0 ORDER BY numero');
$plazas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Gestion de Furnicular</title>
</head>
<body>
<main class="contenedor">
<header>
<div class="logo">
    <span class="logo__isotipo">FB</span>
        <div class="logo__titulo">Furnicular Bulnes<div>
        <div class="logo__texto">Reservar, llegada y gestion de plazas</div>
    </div>
</header>

<section class="reserva">
<h2>Introduce tus datos y selecciona una plaza libre</h2>
<?php if(empty($plazas)):?>
    <p>No hay plazas disponibles en este momento</p>
    <p><a href="index.php">Volver al menu</a>
<?php else :?>
<form method="post" action="reserva_procesar.php">
    <label>DNI</label>
    <input type="text" name="dni" maxlength="15">
    <label>Nombre</label>
    <input type="text" name="nombre" maxlength="25">
    <label>Plaza</label>
    <select name="plaza">
        <option value="">Seleccione una plaza</option>
        <?php foreach($plazas as $plaza):?>
             <option value="<?php $plaza['numero']?>">

              plaza: <?= $plaza['numero'] ?> - <?= $plaza['precio'] ?>
             </option>

        
        <?php endforeach; ?>
       
       
    </select>
    <button type="submit" name="reservar">Reservar</button>
    <a class="btn">Volver al menu</a>
</form>
<?php endif; ?>
</section>
<footer><div class="pie">&copy; <?= date('Y') ?>2025 Furnicular bulnes</div></footer>
    </main>
</body>
</html>