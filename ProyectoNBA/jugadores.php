<?php
require_once "funcionesBD.php";

$equipos = getEquipos();
$jugadores = getJugadores();

// Equipo seleccionado (si existe)
$equipoSeleccionado = $_GET["equipo"] ?? null;
$jugadorSeleccionado = $_GET["jugador"] ?? null;

$jugadores = [];
if ($equipoSeleccionado) {
    $jugadores = getJugadoresPorEquipo($equipoSeleccionado);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./estilos.css">
    <title>Jugadores NBA</title>

 
       
</head>

<body>
<div class="contenedor">
    
    <h1>Jugadores NBA</h1>

    <form method="GET">
        <label for="equipo">Selecciona un equipo:</label>
        <select name="equipo" id="equipo">
            <option value="">-- Selecciona --</option>

            <?php foreach ($equipos as $equipo): ?>
                <option value="<?= $equipo ?>" 
                        <?= $equipoSeleccionado === $equipo ? "selected" : "" ?>>
                    <?= $equipo ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Mostrar jugadores</button>
    </form>

    <?php if ($equipoSeleccionado): ?>
        <h2>Equipo: <?= htmlspecialchars($equipoSeleccionado) ?></h2>

        <?php if (!empty($jugadores)): ?>

        <table>
            <tr>
                <th>Nombre</th>
                <th>Peso</th>
            </tr>

            <?php foreach ($jugadores as $jugador): ?>
                <tr>
                    <td><?= htmlspecialchars($jugador["nombre"]) ?></td>
                    <td><?= htmlspecialchars($jugador["peso"]) ?> kg</td>
                </tr>
            <?php endforeach; ?>

        </table>

        <?php else: ?>

            <p>No hay jugadores registrados para este equipo.</p>

        <?php endif; ?>
    <?php endif; ?>

    <hr>
<h2>Alta y Baja de Jugadores</h2>

<form action="jugadores.php" method="POST">

    <!-- 1. Selección del equipo -->
    <label for="equipo_baja">Selecciona un equipo:</label>
    <select name="equipo_baja" id="equipo_baja" required onchange="this.form.submit()">
        <option value="">-- Selecciona equipo --</option>

        <?php foreach ($equipos as $eq): ?>
            <option value="<?= $eq ?>"
                <?= (isset($_POST['equipo_baja']) && $_POST['equipo_baja'] === $eq) ? "selected" : "" ?>>
                <?= $eq ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php
// Si ya seleccionó un equipo, mostramos los jugadores del equipo
if (isset($_POST['equipo_baja'])):

    $equipoSeleccionado = $_POST['equipo_baja'];
    $jugadoresEquipo = getJugadoresPorEquipo($equipoSeleccionado);

    if (empty($jugadoresEquipo)):
        echo "<p>No hay jugadores en este equipo.</p>";
    else:
?>
<form action="procesa.php" method="POST">

    <input type="hidden" name="equipo_baja" value="<?= $equipoSeleccionado ?>">

    <!-- 2. Selección del jugador que será dado de baja -->
    <label for="jugador_baja">Jugador que causará baja:</label>
    <select name="jugador_baja" id="jugador_baja" required>
        <?php foreach ($jugadoresEquipo as $jug): ?>
            <option value="<?= $jug['nombre'] ?>"><?= $jug['nombre'] ?></option>
        <?php endforeach; ?>
    </select>

    <hr>

    <!-- 3. Datos del NUEVO JUGADOR -->
    <h3>Datos del nuevo jugador</h3>

    <label>Nombre:</label>
    <input type="text" name="nuevo_nombre" required>

    <label>Peso:</label>
    <input type="number" name="nuevo_peso" required min="50" max="200">

    <label>Procedencia:</label>
    <input type="text" name="nuevo_procedencia" required>

    <label>Altura (cm):</label>
    <input type="number" name="nuevo_altura" required min="150" max="250">

    <br><br>

    <button type="submit">Aplicar alta y baja</button>

</form>
<?php
    endif;
endif;
?>

</div>
</body>
</html>
