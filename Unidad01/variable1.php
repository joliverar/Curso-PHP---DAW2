<?php
/*
 * variable1.php
 * - Define tres enteros.
 * - Crea un string con interpolación (sustitución en tiempo de ejecución).
 * - Usa h1, h2 y p generados desde PHP para explicar el programa.
 */

// 1) Definimos tres variables enteras
$ancho  = 8;
$alto   = 5;
$prof   = 3;

// 2) String con interpolación: en comillas dobles, PHP sustituye variables por sus valores
$descripcion = "Caja de ${ancho}x${alto}x${prof} (ancho x alto x profundidad)";

// 3) Calculamos un dato para mostrar que es dinámico
$volumen = $ancho * $alto * $prof;

// 4) Imprimimos la “página” completa desde PHP
echo "<!DOCTYPE html>";
echo "<html lang='es'><head><meta charset='UTF-8'><title>Variables e interpolación</title></head><body>";

echo "<h1>Variables enteras e interpolación</h1>"; // h1
echo "<h2>Descripción generada dinámicamente</h2>"; // h2
echo "<p>La variable \$descripcion se construye con los valores de \$ancho, \$alto y \$prof mientras el script se ejecuta.</p>"; // p
echo "<p><strong>Resultado:</strong> {$descripcion}</p>";
echo "<p>Volumen calculado: <strong>{$volumen}</strong> unidades cúbicas.</p>";

echo "</body></html>";
