<?php
/*
 * edad_aproximada.php
 * - Calcula la edad aproximada (años) usando time() y strtotime().
 * - Aproximación: divide los segundos transcurridos entre 365.25 días.
 */

date_default_timezone_set('Europe/Madrid');

$nacimiento = "1990-04-15";      // fecha de nacimiento
$segundos   = time() - strtotime($nacimiento);
$edadAprox  = floor($segundos / (365.25 * 24 * 60 * 60)); // 365.25 contempla años bisiestos promedio

echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>edad_aproximada</title></head><body>";
echo "Edad aproximada para {$nacimiento}: {$edadAprox} años.";
echo "</body></html>";
