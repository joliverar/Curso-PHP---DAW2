<?php
declare(strict_types=1);

require_once __DIR__ .'\..\vendor\autoload.php';

use App\Clases\AdaptadorGeneradorPassword;

function h(string $s): string{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');

}

if($_SERVER('$REQUEST_METHOD')!=='POST' || !isset($_POST['generar'])){
    header('Location: index.php');
    exit;
}

$length = (int)($_POST['length']?? 12);
$length = max(4, min(128, $length));

$options = [
    'length' => $length,
    'upper' => isset($_POST['upper']),
    'lower' => isset($_POST['lower']),
    'number' => isset($_POST['number']),
    'symbols' => isset($_POST['symbols'])
];

$adaptador = new AdaptadorGeneradorPassword();
$password = $adaptador->generar($options);



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Pasword Generado</h2>
    <p><?= h($password) ?></p>
    <p><a href="./index.php"> volver</a></p>

</body>
</html>