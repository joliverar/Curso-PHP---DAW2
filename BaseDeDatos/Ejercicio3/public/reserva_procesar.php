<?php
// Activa el modo estricto de tipos para evitar conversiones automáticas
declare(strict_types=1);

// Carga el autoload de Composer para poder usar clases y librerías externas
require_once __DIR__ . '/../vendor/autoload.php';

// Importamos las clases que vamos a utilizar
use Dotenv\Dotenv;              // Para leer el archivo .env
use App\Clases\ConexionBD;      // Para obtener la conexión a la base de datos

// Creamos el objeto Dotenv indicando la ruta donde está el archivo .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');

// Cargamos las variables del archivo .env en la superglobal $_ENV
$dotenv->load();

// Comprobación de seguridad:
// - La petición debe ser POST
// - Debe venir del botón "reservar" del formulario
// Si no se cumple, redirigimos al formulario de reserva
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['reservar'])) {
    header('Location: reserva.php');
    exit; // Detiene la ejecución del script
}

// Recogemos los datos enviados por el formulario de forma segura

// DNI: se fuerza a string, se eliminan espacios y se evita error si no existe
$dni = trim((string)($_POST['dni'] ?? ''));

// Nombre: mismo tratamiento que el DNI
$nombre = trim((string)($_POST['nombre'] ?? ''));

// Plaza: si existe se convierte a entero, si no se asigna 0
$plaza = isset($_POST['plaza']) ? (int)$_POST['plaza'] : 0;

// Variable donde guardaremos el mensaje final para el usuario
$msg = '';

// Validación básica de datos:
// - DNI no vacío
// - Nombre no vacío
// - Plaza válida (> 0)
if ($dni === '' || $nombre === '' || $plaza <= 0) {

    // Mensaje de error si faltan datos
    $msg = 'Faltan datos. Todos los campos son obligatorios.';

} else {

    // Obtenemos la conexión PDO usando la clase ConexionBD
    $pdo = ConexionBD::getConexion();

    try {
        // Preparamos la llamada al procedimiento almacenado
        // Usamos parámetros nombrados para mayor seguridad
        $stmt = $pdo->prepare(
            'CALL sp_reservar(:dni, :nombre, :numero)'
        );

        // Ejecutamos el procedimiento pasando los valores reales
        $stmt->execute([
            ':dni'    => $dni,
            ':nombre' => $nombre,
            ':numero' => $plaza
        ]);

        // Mensaje de éxito si la reserva se realiza correctamente
        $msg = "Plaza reservada: $plaza para $nombre (DNI $dni).";

    } catch (PDOException $e) {

        // Si el error contiene el mensaje lanzado desde el procedimiento
        // significa que el DNI ya existe en la base de datos
        if (strpos($e->getMessage(), 'DNI ya existe') !== false) {

            $msg = 'Error: ya existe un pasajero con ese DNI.';

        } else {
            // Cualquier otro error de base de datos
            $msg = 'Error al reservar: ' . $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><title>Resultado reserva</title></head>
<body>
    <h1>Resultado reserva</h1>
    <p><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></p>
    <p><a href="reserva.php">&larr; Volver a reservas</a></p>
    <p><a href="index.php">&larr; Menú</a></p>
</body>
</html>