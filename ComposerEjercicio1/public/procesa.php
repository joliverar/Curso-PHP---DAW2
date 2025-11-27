<?php
declare(strict_types=1); // Fuerza tipos estrictos en este archivo

require_once __DIR__ . '/../vendor/autoload.php'; // Carga el autoloader generado por Composer (vendor/autoload.php)

use App\Clases\AdaptadorGeneradorPassword; // Importa la clase AdaptadorGeneradorPassword del namespace App\Clases

function h(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); } // Helper para escapar salida HTML

// Si la petición NO es POST o no viene el botón 'generar', redirige al formulario
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['generar'])) {
    header('Location: index.php'); // Envía cabecera Location para redirigir al index (comportamiento PRG simple)
    exit; // Termina la ejecución tras la redirección
}

// Recoge y valida la longitud solicitada (por defecto 12, y la limita entre 4 y 128)
$length = (int) ($_POST['length'] ?? 12); // Convierte a entero y usa 12 si no viene
$length = max(4, min(128, $length)); // Asegura que queda en el rango permitido

// Construye el array de opciones leyendo los checkbox del formulario
$options = [
    'length'  => $length,
    'upper'   => isset($_POST['upper']),   // true si se pidió mayúsculas
    'lower'   => isset($_POST['lower']),   // true si se pidió minúsculas
    'numbers' => isset($_POST['numbers']), // true si se pidió números
    'symbols' => isset($_POST['symbols']), // true si se pidió símbolos
];

// Crea el adaptador que implementa la interfaz del generador de contraseñas
$adaptador = new AdaptadorGeneradorPassword();

// Genera la contraseña usando las opciones proporcionadas
$password = $adaptador->generar($options);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Contraseña generada</title>
</head>
<body>
    <a href="index.php">&larr; Volver</a> <!-- Enlace para volver al formulario -->
    <h1>Contraseña generada</h1>
    <p><strong><?= h($password) ?></strong></p> <!-- Muestra la contraseña escapada -->
</body>
</html>