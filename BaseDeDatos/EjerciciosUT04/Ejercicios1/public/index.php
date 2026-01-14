<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Clases\ConexionBD;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$pdo = ConexionBD::getConexion();

// lista de equipos para el select
$stmt = $pdo->query("SELECT nombre FROM equipos ORDER BY nombre");
$equipos = $stmt->fetchAll(PDO::FETCH_COLUMN);

// equipo seleccionado (GET para recargar lista de jugadores en el select)
$equipoSeleccionado = isset($_GET['equipo']) ? (string) $_GET['equipo'] : '';

// jugadores del equipo (solo código y nombre para el select de baja)
$jugadores = [];
if ($equipoSeleccionado !== '') {
    $stmt = $pdo->prepare("SELECT codigo, nombre FROM jugadores WHERE nombre_equipo = ? ORDER BY nombre");
    $stmt->execute([$equipoSeleccionado]);
    $jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function h(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Gestión de jugadores</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 30px auto; padding: 0 20px; color: #222; }
        h1 { color: #1a5f9a; }
        form { margin-bottom: 20px; display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
        select, input, button { padding:8px 10px; font-size:1rem; border:1px solid #bbb; border-radius:4px; }
        button { background:#1a5f9a; color:#fff; border:none; cursor:pointer; }
        button:hover { background:#15507a; }
        .grid { display:grid; grid-template-columns: 1fr 1fr; gap:12px; align-items:start; }
        .box { padding:12px; border:1px solid #eee; border-radius:6px; background:#fafafa; }
        label { display:block; margin-bottom:6px; font-weight:600; }
        .nota { color:#666; margin-top:10px; }
        .sin-datos { color:#b00; margin-top:10px; }
        .success { color: #155724; background: #d4edda; border: 1px solid #c3e6cb; padding: 10px; border-radius: 4px; margin-bottom: 12px; }
    </style>
</head>
<body>
    <h1>Gestión de jugadores</h1>

    <?php if (isset($_GET['success']) && $_GET['success'] === '1'): ?>
        <div class="success">Alta-baja realizada con éxito.</div>
    <?php endif; ?>

    <!-- Selección del equipo (GET) -->
    <form method="get" action="index.php" aria-label="Seleccionar equipo">
        <label for="equipo">Equipo:</label>
        <select name="equipo" id="equipo" required onchange="this.form.submit()">
            <option value="">-- Selecciona un equipo --</option>
            <?php foreach ($equipos as $eq): ?>
                <option value="<?= h($eq) ?>" <?= $eq === $equipoSeleccionado ? 'selected' : '' ?>><?= h($eq) ?></option>
            <?php endforeach; ?>
        </select>
        <noscript><button type="submit">Seleccionar</button></noscript>
    </form>

    <?php if ($equipoSeleccionado === ''): ?>
        <p class="nota">Selecciona un equipo para poder elegir un jugador para dar de baja y añadir uno nuevo.</p>
    <?php else: ?>
        <h2>Equipo: <?= h($equipoSeleccionado) ?></h2>

        <div class="grid">
            <div class="box">
                <h3>Jugador a dar de baja</h3>
                <form method="post" action="procesar.php">
                    <input type="hidden" name="equipo" value="<?= h($equipoSeleccionado) ?>">

                    <label for="jugador_baja">Selecciona jugador</label>
                    <select name="jugador_baja" id="jugador_baja" required>
                        <option value="">-- Selecciona jugador --</option>
                        <?php foreach ($jugadores as $j): ?>
                            <option value="<?= (int)$j['codigo'] ?>"><?= h($j['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>

                    <?php if (empty($jugadores)): ?>
                        <p class="sin-datos">No hay jugadores en este equipo.</p>
                    <?php else: ?>
                        <p class="nota">El jugador seleccionado será dado de baja (sus estadísticas se eliminarán antes).</p>
                    <?php endif; ?>
            </div>

            <div class="box">
                <h3>Alta de nuevo jugador</h3>

                    <!-- Se elimina el campo 'codigo' porque lo gestiona la base de datos -->
                    <label for="nombre_nuevo">Nombre</label>
                    <input type="text" name="nombre_nuevo" id="nombre_nuevo" required>

                    <label for="procedencia_nueva">Procedencia</label>
                    <input type="text" name="procedencia_nueva" id="procedencia_nueva">

                    <label for="altura_nueva">Altura (m) — formato 1.98</label>
                    <input type="text" name="altura_nueva" id="altura_nueva" pattern="^\d+(\.\d+)?$" required>

                    <label for="peso_nuevo">Peso (kg)</label>
                    <input type="text" name="peso_nuevo" id="peso_nuevo" pattern="^\d+(\.\d+)?$" required>

                    <label for="posicion_nueva">Posición</label>
                    <input type="text" name="posicion_nueva" id="posicion_nueva">

                    <div style="margin-top:12px">
                        <button type="submit" name="accion" value="swap">Realizar baja+alta</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>
