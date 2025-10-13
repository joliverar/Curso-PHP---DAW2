<?php
/*
 * par_impar.php
 * - Comprueba si un número es par o impar con el operador módulo (%).
 */

$numero = 14;

// Un número es par si su resto al dividir entre 2 es 0
$mensaje = ($numero % 2 === 0) ? "par" : "impar";

echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>par_impar</title></head><body>";
echo "El número {$numero} es {$mensaje}.";
echo "</body></html>";
