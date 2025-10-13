<?php
/*
 * suma_global.php
 * - Suma dos variables definidas fuera de la función usando 'global'.
 */

// Variables “globales” (ámbito de archivo)
$a = 7;
$b = 13;

function sumarGlobales() {
    // Declaramos que dentro de la función usaremos las globales $a y $b
    global $a, $b;
    return $a + $b;
}

echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>suma_global</title></head><body>";
echo "Suma (global): " . sumarGlobales();
echo "</body></html>";
