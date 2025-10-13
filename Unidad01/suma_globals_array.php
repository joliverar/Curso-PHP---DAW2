<?php
/*
 * suma_globals_array.php
 * - Accede a variables externas mediante el array superglobal $GLOBALS.
 * - $GLOBALS['nombre_variable'] referencia variables del ámbito global.
 */

$x = 20;
$y = 22;

function sumarConGLOBALS() {
    // Acceso a las variables globales sin 'global', usando $GLOBALS
    $suma = $GLOBALS['x'] + $GLOBALS['y'];
    return $suma;
}

echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>suma_globals_array</title></head><body>";
echo "Suma usando \$GLOBALS: " . sumarConGLOBALS();
echo "</body></html>";
