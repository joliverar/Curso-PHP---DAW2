<?php
// Activa el modo estricto de tipos en PHP.
// Evita conversiones automáticas implícitas y mejora la calidad del código.
declare(strict_types=1);

// Carga el autoload de Composer.
// Permite usar clases propias (ConexionBD) y librerías externas (Dotenv)
// sin necesidad de hacer require manual de cada archivo.
require_once __DIR__ . '/../vendor/autoload.php';

// Importamos las clases necesarias
use Dotenv\Dotenv;              // Para cargar variables de entorno desde .env
use App\Clases\ConexionBD;      // Para gestionar la conexión a la base de datos

// Creamos una instancia de Dotenv indicando la ruta donde se encuentra el archivo .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');

// Cargamos las variables del archivo .env en la superglobal $_ENV
$dotenv->load();

// Obtenemos la conexión a la base de datos mediante la clase ConexionBD
// Se utiliza PDO y el patrón Singleton para reutilizar la conexión
$pdo = ConexionBD::getConexion();

// Variable para almacenar el mensaje que se mostrará al usuario
$msg = '';

// Comprobamos si la petición es POST y si se ha pulsado el botón "actualizar"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {

    try {
        // Iniciamos una transacción para asegurar que todos los cambios
        // se realizan de forma conjunta
        $pdo->beginTransaction();

        // Recorremos el array de precios enviado desde el formulario
        // $_POST['precio'] tiene la forma:
        // [numero_plaza => nuevo_precio]
        foreach ($_POST['precio'] as $numero => $precio) {

            // Preparamos la consulta SQL para actualizar el precio de una plaza
            $stmt = $pdo->prepare(
                'UPDATE plazas SET precio = ? WHERE numero = ?'
            );

            // Ejecutamos la consulta pasando los valores:
            // - el precio se convierte a float
            // - el número de plaza se convierte a entero
            $stmt->execute([
                (float) $precio,
                (int) $numero
            ]);
        }

        // Si todas las actualizaciones se realizan correctamente,
        // confirmamos la transacción
        $pdo->commit();

        // Mensaje de éxito para el usuario
        $msg = 'Precios actualizados.';

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

// Realizamos una consulta para obtener todas las plazas,
// incluyendo su número, si están reservadas y su precio
// Los resultados se ordenan por número de plaza
$plazas = $pdo->query(
    'SELECT numero, reservada, precio FROM plazas ORDER BY numero'
)->fetchAll();

// El array $plazas se utilizará posteriormente para mostrar
// los datos en una tabla y permitir la modificación de precios
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Gestión de plazas - Funicular Bulnes</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="css/style.css">

</head>
<body>
    <main class="container" role="main" aria-labelledby="title">
        <header>
            <div class="logo">FB</div>
            <div>
                <h1 id="title">Gestión de plazas</h1>
                <p class="lead">Visualiza y actualiza los precios de las plazas del funicular.</p>
            </div>
        </header>

        <?php if ($msg !== ''): ?>
            <div class="msg <?= strpos($msg, 'Error') === 0 ? 'error' : 'success' ?>" role="status">
                <?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="post" action="plazas.php">
            <table aria-describedby="title">
                <thead>
                    <tr>
                        <th>Plaza</th>
                        <th>Reservada</th>
                        <th>Precio (€)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($plazas as $p): ?>
                        <tr>
                            <td data-label="Plaza"><?= (int)$p['numero'] ?></td>
                            <td data-label="Reservada"><?= ((int)$p['reservada']) ? 'Sí' : 'No' ?></td>
                            <td data-label="Precio">
                                <input type="text" name="precio[<?= (int)$p['numero'] ?>]" value="<?= htmlspecialchars((string)$p['precio'], ENT_QUOTES, 'UTF-8') ?>">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="controls">
                <button type="submit" name="actualizar">Actualizar precios</button>
                <a class="link" href="index.php">&larr; Volver al menú</a>
            </div>
        </form>
    </main>
</body>
</html>