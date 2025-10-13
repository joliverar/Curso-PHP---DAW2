<?php
/*
 * comparar_fechas.php
 * - Compara dos fechas con strtotime() y muestra resultado con un ternario.
 */

$f1 = "2025-09-01";
$f2 = "2025-09-25";

// strtotime convierte cadena a timestamp (segundos desde 1970-01-01)
$t1 = strtotime($f1);
$t2 = strtotime($f2);

// Ternario anidado para informar relación
$resultado = ($t1 === $t2) ? "iguales" : (($t1 < $t2) ? "la primera es anterior" : "la primera es posterior");

echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>comparar_fechas</title></head><body>";
echo "Comparando {$f1} y {$f2}: {$resultado}.";
echo "</body></html>";
