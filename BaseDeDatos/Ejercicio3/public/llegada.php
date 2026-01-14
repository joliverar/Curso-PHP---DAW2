<?php
// Activa el modo estricto de tipos en PHP.
// Evita conversiones automáticas implícitas y mejora la calidad del código.
declare(strict_types=1);

// Carga el autoload de Composer.
// Permite usar clases propias y librerías externas (Dotenv)
// sin necesidad de hacer require manual de cada archivo.
require_once __DIR__ . '/../vendor/autoload.php';

// Importamos las clases que vamos a utilizar
use Dotenv\Dotenv;              // Para cargar las variables de entorno desde el archivo .env
use App\Clases\ConexionBD;      // Para obtener la conexión a la base de datos con PDO

// Creamos una instancia de Dotenv indicando la ruta donde se encuentra el archivo .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');

// Cargamos las variables del archivo .env en la superglobal $_ENV
$dotenv->load();

// Variable donde se almacenará el mensaje que se mostrará al usuario
$msg = '';

// Comprobamos si la petición HTTP es de tipo POST
// Esto ocurre cuando el usuario pulsa el botón "Llegada"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtenemos la conexión a la base de datos usando la clase ConexionBD
    $pdo = ConexionBD::getConexion();

    try {
        // Iniciamos una transacción para garantizar que todas las operaciones
        // se realicen de forma conjunta
        $pdo->beginTransaction();

        // Eliminamos todos los registros de la tabla pasajeros
        // Esto simula que el funicular ha llegado a su destino
        $pdo->exec('DELETE FROM pasajeros');

        // Actualizamos todas las plazas y las marcamos como no reservadas
        $pdo->exec('UPDATE plazas SET reservada = 0');

        // Si ambas operaciones se ejecutan correctamente,
        // confirmamos la transacción
        $pdo->commit();

        // Mensaje de éxito que se mostrará al usuario
        $msg = 'Operación realizada: pasajeros borrados y plazas liberadas.';

    } catch (PDOException $e) {

        // Si ocurre un error y la transacción está activa,
        // se deshacen todos los cambios realizados
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        // Mensaje de error que se mostrará al usuario
        $msg = 'Error: ' . $e->getMessage();
    }
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Llegada - Funicular Bulnes</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="css/style.css">

</head>
<body>
    <main class="card" role="main" aria-labelledby="title">
        <h1 id="title">Llegada al destino</h1>
        <p class="lead">Al confirmar la llegada se eliminarán los pasajeros y se liberarán todas las plazas.</p>

        <?php if ($msg !== ''): ?>
            <div class="msg <?= strpos($msg, 'Error') === 0 ? 'error' : 'success' ?>" role="status">
                <?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="post" action="llegada.php" onsubmit="return confirm('¿Confirmas que el funicular ha llegado y deseas vaciar pasajeros y liberar plazas?');">
            <button type="submit" name="llegada">Confirmar llegada</button>
            <a class="link" href="index.php" style="margin-left:auto;align-self:center;">Volver al menú</a>
        </form>

        <div class="meta">Operación realizada dentro de una transacción. Asegúrate de tener copias si hace falta.</div>
    </main>
</body>
</html>