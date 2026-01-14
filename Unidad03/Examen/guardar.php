<?php
session_start();
$cont = 0;
$_SESSION['usuario'] = 'Jino Olivra';
$_SESSION['visitas'] = $cont++;

echo "nombre guardado en sesion";

if($_COOKIE['primera']){
    echo "bienvenido";
} else {
    echo "Tu visita fue";
}
?>