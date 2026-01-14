<?php

print_r($_POST);

$error = "";
$nombre = "";
if(!empty($_POST['nombre'])){
    $nombre = trim($nombre);
    $nombre = htmlspecialchars($nombre);
    $nombre = strip_tags($nombre);
 

 
} else {
    $error .= "Por favor ingrese su nombre<br>";
}

$anio = "";
if(!empty($_POST['anio'])){
    $anio = trim($anio);
    $anio = htmlspecialchars($anio);
  //  if(isset($_POST['anio'] )){
  //      FILTER_VALIDATE_FLOAT($anio);
  //  }
} else {
    $error .= "Por favor ingrese el año<br>";
}

$precio = "";
if(!empty($_POST['precio'])){
    $precio = trim($precio);
    $precio = htmlspecialchars($precio);
 
} else {
    $error .= "Por favor ingrese el precio<br>";
}

$fecha = "";
if(!empty($_POST['fecha'])){
    $fecha = trim($fecha);
    $fecha = htmlspecialchars($fecha);
 
} else {
    $error .= "Por favor ingrese la fecha de publicación<br>";
}
?>
<?php
require_once 'libros.php';
?>