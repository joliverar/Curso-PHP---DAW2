<?php
/*
 * variable2.php
 * - Declara cadenas y concatena con el operador punto (.)
 */

$nombre    = "Ana";
$apellido1 = "García";
$apellido2 = "López";

// Concatenación: el punto une cadenas
$nombreCompleto = $nombre . " " . $apellido1 . " " . $apellido2;

echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>variable2</title></head><body>";
echo "<p>Nombre completo: " . $nombreCompleto . "</p>";
echo "</body></html>";
