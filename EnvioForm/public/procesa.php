<?php
require_once "../vendor/autoload.php";

use App\Clases\AdaptadorCorreo;
use App\Clases\EnviaCorreo;

$adaptador = new AdaptadorCorreo();
$datos = $adaptador->preparar($_POST);

$correo = new EnviaCorreo();
$enviado = $correo->enviar($datos);

if ($enviado) {
    echo "Correo enviado con éxito";
} else {
    echo "Error al enviar correo";
}
