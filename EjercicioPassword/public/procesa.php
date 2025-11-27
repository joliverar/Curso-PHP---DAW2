<?php

require_once "../vendor/autoload.php";

use App\Clases\AdaptadorGeneradorPassword;

$longitud = $_POST['longitud'];
$mayus = isset($_POST['mayus']);
$minus = isset($_POST['minus']);
$nums = isset($_POST['nums']);
$simbolos = isset($_POST['simbolos']);

$generador = new AdaptadorGeneradorPassword();

$password = $generador->generar(
    $longitud, $mayus, $minus, $nums, $simbolos
);

echo "<h1>Contraseña generada:</h1>";
echo "<h2>$password</h2>";
