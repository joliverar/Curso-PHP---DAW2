<?php
declare(strict_types=1);

require_once __DIR__ .'/../vendor/autoload.php';
use Dotenv\Dotenv;
use App\Clases\ConexionBD;

$dotenv = Dotenv::createImmutable(__DIR__ .'/../');

$dotenv->load();

$pdo = ConexionBD::getConexion();
$conexionOk = false;
$msg ='';
try {
    $stmt = $pdo->query('select * from peliculas');
    $conexionOk = true;

} catch (PDOException $e) {
    //throw $th;
        $msg = "Error de conexion".$e->getMessage();
}

?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Cine - Menú</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>body{font-family:Arial;margin:20px}</style>
</head>
<body>

    <?php if($conexionOk):?>
        <div style="color: green">Conexion exitosa</div>
    <?php else:?>
        <div style="color: red">Conexion fallida</div>
        <?php endif;?>
  <h1>Gestión del Cine (examen)</h1>
  <ul>
    <li><a href="peliculas.php">Películas (listar / crear / actualizar / borrar)</a></li>
    <li><a href="salas.php">Salas (listar / crear / actualizar / borrar)</a></li>
    <li><a href="compra.php">Comprar entradas</a></li>
  </ul>
</body>
</html>