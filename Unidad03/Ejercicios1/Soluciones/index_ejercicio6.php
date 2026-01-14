<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
use App\Clases\ConexionBD;

// Conexión
$pdo = ConexionBD::getConexion();

// Obtener lista de equipos para el select
$stmt = $pdo->query("SELECT nombre FROM equipos ORDER BY nombre");
$equipos = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Equipo seleccionado (por seguridad, usar valor enviado por GET)
$equipoSeleccionado = isset($_GET['equipo']) ? (string) $_GET['equipo'] : '';

// Si se ha seleccionado un equipo válido, obtener sus jugadores
$jugadores = [];
if ($equipoSeleccionado !== '') {
    // Prepared statement para evitar inyección
    $stmt = $pdo->prepare("SELECT nombre, peso FROM jugadores WHERE nombre_equipo = ? ORDER BY nombre");
    $stmt->execute([$equipoSeleccionado]);
    $jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Helper para escapar salida HTML
function h(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Jugadores por Equipo</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 30px auto; padding: 0 20px; color: #222; }
        h1 { color: #1a5f9a; }
        form { margin-bottom: 20px; display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
        select, button { padding:8px 10px; font-size:1rem; border:1px solid #bbb; border-radius:4px; }
        button { background:#1a5f9a; color:#fff; border:none; cursor:pointer; }
        button:hover { background:#15507a; }
        table { width:100%; border-collapse: collapse; margin-top: 12px; }
        th, td { padding:8px 10px; border:1px solid #ddd; text-align:left; }
        th { background:#f5f7fb; color:#333; }
        tr:nth-child(even) td { background:#fbfbfc; }
        .nota { color:#666; margin-top:10px; }
        .sin-datos { color:#b00; margin-top:10px; }
    </style>
</head>
<body>
    <h1>Jugadores por equipo</h1>

    <form method="get" action="index.php" aria-label="Seleccionar equipo">
        <label for="equipo">Equipo:</label>
        <select name="equipo" id="equipo" required>
            <option value="">-- Selecciona un equipo --</option>
            <?php foreach ($equipos as $eq): ?>
                <option value="<?= h($eq) ?>" <?= $eq === $equipoSeleccionado ? 'selected' : '' ?>><?= h($eq) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Mostrar jugadores</button>
    </form>

    <?php if ($equipoSeleccionado === ''): ?>
        <p class="nota">Selecciona un equipo para ver sus jugadores.</p>
    <?php else: ?>
        <h2>Equipo: <?= h($equipoSeleccionado) ?></h2>

        <?php if (empty($jugadores)): ?>
            <p class="sin-datos">No se han encontrado jugadores para este equipo.</p>
        <?php else: ?>
            <table aria-describedby="tabla-jugadores">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Peso (kg)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jugadores as $j): ?>
                        <tr>
                            <td><?= h((string)$j['nombre']) ?></td>
                            <td><?= h((string)$j['peso']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
