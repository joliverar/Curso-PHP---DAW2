<?php
/*
 * variables_definidas.php
 * - Verifica que las variables haya sido definidas con isset().
 * - isset devuelve true si la variable existe y NO es null.
 */

$definida   = 123;
$indefinida = null; // simula que podría no estar definida o ser null

echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>variables_definidas</title></head><body>";
echo "¿\$definida está definida? "   . (isset($definida)   ? "sí" : "no") . "<br>";
echo "¿\$indefinida está definida? " . (isset($indefinida) ? "sí" : "no") . "<br>";

// empty() comprueba si es “vacía” (0, "", null, false, [], etc.)
$cadenaVacia = "";
echo "¿\$cadenaVacia está vacía? " . (empty($cadenaVacia) ? "sí" : "no") . "<br>";
echo "</body></html>";
