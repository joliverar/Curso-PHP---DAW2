<?php
/*
 * variable4.php
 * - Define variables de distintos tipos y las imprime, una por línea.
 */

$miEntero  = 42;             // integer
$miReal    = 3.1416;         // double/float
$miCadena  = "PHP";          // string
$miBoolean = true;           // boolean

echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>variable4</title></head><body>";
// Para booleans, var_export los convierte a 'true'/'false'
echo "Entero: {$miEntero}<br>";
echo "Real: {$miReal}<br>";
echo "Cadena: {$miCadena}<br>";
echo "Booleano: " . var_export($miBoolean, true) . "<br>";
echo "</body></html>";
