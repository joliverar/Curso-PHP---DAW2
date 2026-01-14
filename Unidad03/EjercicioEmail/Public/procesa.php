<?php
declare(strict_types=1);

use App\Clases\ProveedorMailtrap;
use App\Clases\ServicioCorreo;

require_once __DIR__ . '/../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['enviar'])) {
    header('Location: index.php');
    exit;
}

$nombre = trim((string)($_POST['nombre'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$mensaje = trim((string)($_POST['mensaje'] ?? ''));

if ($nombre === '' || $email === '' || $mensaje === '') {
    header('Location: index.php?error=1');
    exit;
}

if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    header('Location: index.php?error=2');
    exit;
}

$asunto = "Contacto web: " . $nombre;

$cuerpo = "<p>Envio desde formulario:</p>"
        . "<p><strong>Nombre:</strong> " . htmlspecialchars($nombre, ENT_QUOTES) . "</p>"
        . "<p><strong>Email:</strong> " . htmlspecialchars($email, ENT_QUOTES) . "</p>"
        . "<p><strong>Mensaje:</strong><br>" . nl2br(htmlspecialchars($mensaje, ENT_QUOTES)) . "</p>";

$destinatario = $email;

$proveedor = new ProveedorMailtrap();
$servicio = new ServicioCorreo($proveedor);

$ok = $servicio->enviarCorreo($destinatario, $asunto, $cuerpo);

if ($ok) {
    header('Location: index.php?success=1');
    exit;
} else {
    header('Location: index.php?error=3');
    exit;
}
?>

