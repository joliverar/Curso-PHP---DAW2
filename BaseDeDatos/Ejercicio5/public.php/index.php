<?php

declare(strict_types=1);

//var_dump($_ENV);

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
<nav class="menu">
<div class="menu__gestion"><h2 class="menu__titulo">Reservar Plaza</h2>
<p>Reservar una plaza libre con DNI y nombre</p>
<a class="btn" href="reserva.php">Reservar</a>
</div>
<div class="menu__gestion"><h2 class="menu__titulo">Llegada a destino</h2>
<p>Borrar pasajeros y liberar todas las plazas(transaccion)</p>
<a class="btn" href="llegada.php">Llegada</a></div>
<div class="menu__gestion"><h2 class="menu__titulo">Gestión de plazas</h2>
<p>Ver y actualizar precios de las plasas</p>
<a class="btn" href="plazas.php">Gestionar</a></div>

</nav>
<footer><div class="pie">&copy; <?= date('Y') ?>2025 Furnicular bulnes</div></footer>
    </main>
</body>
</html>