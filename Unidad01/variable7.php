<?php
/*
 * variable7.php
 * - Suma int + float y muestra el tipo de $resultado.
 * - En PHP, int + float => float (double).
 */

$mi_entero = 3;
$mi_real   = 2.3;
$resultado = $mi_entero + $mi_real;

echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>variable7</title></head><body>";
// gettype devuelve el tipo como string (por ejemplo "double")
echo "Valor de \$resultado: {$resultado}<br>";
echo "Tipo de \$resultado: " . gettype($resultado) . "<br>";
// Alternativamente, var_dump muestra tipo y valor
// var_dump($resultado);
echo "</body></html>";
