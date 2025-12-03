<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <title>Document</title>
</head>

<body>
    <?php
    require_once "funcionesBD.php";

    $equipos = getEquipos();
    $jugadores = getJugadores();
    ?>

  
    <div class="contenedor">
      
              <h1>Equipos de la NBA</h1>
            <ul>
                <?php foreach ($equipos as $equipo): ?>
                    <li><?= $equipo ?></li>
                <?php endforeach; ?>
            </ul>
            <hr>
        
        <div class="jugadores">
            <h1>Jugadores de la NBA</h1>
            <ul>
                <?php foreach ($jugadores as $jugador): ?>
                    <li><?= $jugador ?></li>
                <?php endforeach ?>
        </div>
    </div>
    <hr>
    </ul>
    <?php probarFetchModes(); ?>
</body>

</html>