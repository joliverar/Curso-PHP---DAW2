<?php
declare(strict_types=1);

// Autoload de Composer (asegúrate de haber ejecutado composer require phpmailer/phpmailer)
require_once __DIR__ . '/../vendor/autoload.php';

use App\Clases\ProveedorMailtrap;
use App\Clases\ServicioCorreo;

// Validar método y campos mínimos
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['enviar'])) {
    header('Location: index.php');
    exit;
}

$nombre  = trim((string)($_POST['nombre'] ?? ''));
$email   = trim((string)($_POST['email'] ?? ''));
$mensaje = trim((string)($_POST['mensaje'] ?? ''));

// Campos obligatorios
if ($nombre === '' || $email === '' || $mensaje === '') {
    header('Location: index.php?error=1');
    exit;
}

// Validar email
if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    header('Location: index.php?error=2');
    exit;
}

// Preparar asunto y cuerpo (puedes modificar formato)
$asunto = "Contacto web: " . $nombre;
$cuerpo = "<p>Has recibido un mensaje desde el formulario de contacto:</p>"
        . "<p><strong>Nombre:</strong> " . htmlspecialchars($nombre, ENT_QUOTES) . "</p>"
        . "<p><strong>Email:</strong> " . htmlspecialchars($email, ENT_QUOTES) . "</p>"
        . "<p><strong>Mensaje:</strong><br>" . nl2br(htmlspecialchars($mensaje, ENT_QUOTES)) . "</p>";



// Destinatario: puedes usar cualquier email (Mailtrap capturará)
$destinatario = $email;

// Instanciar proveedor y servicio
$proveedor = new ProveedorMailtrap();
$servicio  = new ServicioCorreo($proveedor);

// Enviar y redirigir según resultado
$ok = $servicio->enviarCorreo($destinatario, $asunto, $cuerpo);

if ($ok) {
    header('Location: index.php?success=1');
    exit;
} else {
    header('Location: index.php?error=3');
    exit;
}