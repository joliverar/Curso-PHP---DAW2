<?php
declare(strict_types=1);

// Cargamos el bootstrap del proyecto:
// - autoload de Composer
// - variables de entorno (.env)
// - configuración común
require_once __DIR__ . '/../app/bootstrap.php';

use App\Clases\ConexionBD;

// Iniciamos la sesión para poder acceder a $_SESSION
session_start();

// Comprobación de acceso:
// si el usuario no está logueado, se redirige al login
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// Gestión de la cookie de última visita
// Si existe, la guardamos para mostrarla
$ultimaVisita = $_COOKIE['ultima_visita'] ?? null;

// Creamos o actualizamos la cookie de última visita
// Duración: 30 días
setcookie(
    'ultima_visita',
    date('Y-m-d H:i:s'),
    time() + (30 * 24 * 60 * 60)
);

// Obtenemos conexión con la base de datos
$pdo = ConexionBD::getConexion();

// Consulta para obtener las plazas libres
$stmt = $pdo->query(
    'SELECT numero, precio FROM plazas WHERE reservada = 0 ORDER BY numero'
);

// Recuperamos todas las plazas como array asociativo
$plazas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reservar plaza - Funicular Bulnes</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="estilo.css">
    <!-- Estilos embebidos para simplificar el ejercicio -->
    <style>
        /* estilos omitidos por brevedad (no cambian) */
    </style>
</head>
<body>
<main class="card" role="main" aria-labelledby="title">

    <!-- Cabecera -->
    <header>
        <div class="logo">FB</div>
        <div>
            <h1 id="title">Reservar plaza</h1>

            <!-- Usuario logueado -->
            <p>Bienvenido, <?= htmlspecialchars($_SESSION['usuario']) ?></p>

            <!-- Información de última visita -->
            <?php if ($ultimaVisita): ?>
                <p>Última visita: <?= htmlspecialchars($ultimaVisita) ?></p>
            <?php else: ?>
                <p>Esta es tu primera visita</p>
            <?php endif; ?>

            <a href="logout.php">Cerrar sesión</a>

            <p class="lead">
                Introduce DNI y nombre, y selecciona una plaza libre.
            </p>
        </div>
    </header>

    <!-- Si no hay plazas disponibles -->
    <?php if (empty($plazas)): ?>
        <p class="note">No hay plazas libres en este momento.</p>
        <p><a class="link" href="index.php">&larr; Volver al menú</a></p>
    <?php else: ?>

        <!-- Formulario de reserva -->
        <!-- Los datos se envían por POST a reserva_procesar.php -->
        <form method="post" action="reserva_procesar.php" novalidate>

            <div>
                <label for="dni">DNI</label>
                <input
                    id="dni"
                    name="dni"
                    type="text"
                    required
                    maxlength="12"
                    pattern="[A-Za-z0-9\-]{3,12}"
                >
            </div>

            <div>
                <label for="nombre">Nombre</label>
                <input
                    id="nombre"
                    name="nombre"
                    type="text"
                    required
                    maxlength="25"
                >
            </div>

            <div class="full">
                <label for="plaza">Plaza</label>
                <select id="plaza" name="plaza" required>
                    <option value="">-- Selecciona plaza --</option>

                    <!-- Listado dinámico de plazas libres -->
                    <?php foreach ($plazas as $p): ?>
                        <option value="<?= (int)$p['numero'] ?>">
                            Plaza <?= (int)$p['numero'] ?> —
                            €<?= htmlspecialchars((string)$p['precio']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="full actions">
                <button type="submit" name="reservar">Reservar plaza</button>
                <a class="link" href="index.php">&larr; Volver al menú</a>
            </div>

            <div class="full note">
                Nota: el campo sexo se guardará por defecto como "-" y la reserva se realiza en transacción.
            </div>

        </form>
    <?php endif; ?>

</main>
</body>
</html>
