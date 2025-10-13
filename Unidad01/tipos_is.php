<?php
/*
 * tipos_is.php
 * - Usa funciones is_int, is_float, is_string, is_bool, etc. para verificar tipos.
 */

$entero = 10;
$real   = 2.5;
$texto  = "hola";
$bool   = false;

echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>tipos_is</title></head><body>";
echo "entero is_int? "  . (is_int($entero)  ? "sí" : "no") . "<br>";
echo "entero is_float? ". (is_float($entero)? "sí" : "no") . "<br>";

echo "real is_float? "  . (is_float($real)  ? "sí" : "no") . "<br>";
echo "real is_int? "    . (is_int($real)    ? "sí" : "no") . "<br>";

echo "texto is_string? ". (is_string($texto)? "sí" : "no") . "<br>";
echo "bool is_bool? "   . (is_bool($bool)   ? "sí" : "no") . "<br>";
echo "</body></html>";
