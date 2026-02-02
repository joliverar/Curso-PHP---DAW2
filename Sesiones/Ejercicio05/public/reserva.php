<?php declare(strict_types=1);

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use App\Clases\ConexionBD;
use Dotenv\Dotenv;

// Cargar variables de entorno
Dotenv::createImmutable(__DIR__ . '/../')->safeLoad();

// Control de acceso
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$pdo = ConexionBD::getConexion();

// Obtener la película (viene por GET al entrar y por POST al enviar)
$peliculaId = (int) ($_GET['pelicula_id'] ?? $_POST['pelicula_id'] ?? 0);

if ($peliculaId === 0) {
    $_SESSION['flash'] = 'Película no válida';
    header('Location: peliculas.php');
    exit;
}

// PROCESAR RESERVA
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plaza = (int) ($_POST['plaza'] ?? 0);

    if ($plaza === 0) {
        $_SESSION['flash'] = 'Debe seleccionar una plaza';
        header('Location: reserva.php?pelicula_id=' . $peliculaId);
        exit;
    }

    try {
        // Iniciar transacción
        $pdo->beginTransaction();

        // Bloquear la plaza
        $stmt = $pdo->prepare(
            'SELECT reservada FROM plazas WHERE id = :id FOR UPDATE'
        );
        $stmt->execute(['id' => $plaza]);
        $estado = $stmt->fetchColumn();

        if ($estado === false || (int) $estado === 1) {
            throw new Exception('Plaza ocupada');
        }

        // Insertar reserva
        $stmt = $pdo->prepare(
            'INSERT INTO reservas (usuario, pelicula_id, plaza, fecha_reserva)
             VALUES (:usuario, :pelicula, :plaza, NOW())'
        );
        $stmt->execute([
            'usuario' => $_SESSION['usuario'],
            'pelicula' => $peliculaId,
            'plaza' => $plaza
        ]);

        // Marcar plaza como reservada
        $stmt = $pdo->prepare(
            'UPDATE plazas SET reservada = 1 WHERE id = :id'
        );
        $stmt->execute(['id' => $plaza]);

        // Confirmar transacción
        $pdo->commit();

        $_SESSION['flash'] = 'Reserva realizada correctamente';
        header('Location: peliculas.php');
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['flash'] = 'Plaza no disponible';
        header('Location: reserva.php?pelicula_id=' . $peliculaId);
        exit;
    }
}

// OBTENER PLAZAS DISPONIBLES
$plazas = $pdo->query(
    'SELECT id, numero FROM plazas WHERE reservada = 0 ORDER BY numero'
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservar plaza</title>
</head>
<body>

<h2>Reservar plaza</h2>

<?php if (isset($_SESSION['flash'])): ?>
    <p><?= htmlspecialchars($_SESSION['flash']) ?></p>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<form method="post">
    <input type="hidden" name="pelicula_id" value="<?= $peliculaId ?>">

    <label>Plaza:</label>
    <select name="plaza" required>
        <option value="">-- Seleccione una plaza --</option>
        <?php foreach ($plazas as $p): ?>
            <option value="<?= $p['id'] ?>">
                Plaza <?= htmlspecialchars((string) $p['numero']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <br><br>
    <button type="submit">Reservar</button>
</form>

<p><a href="peliculas.php">Volver a películas</a></p>

</body>
</html>
