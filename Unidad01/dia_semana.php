<?php
/*
 * dia_semana.php
 * - Muestra el día de la semana (en español) de una fecha específica.
 */

date_default_timezone_set('Europe/Madrid');

$fecha = "2025-12-06"; // ejemplo

// Obtenemos número de día: 1=lunes ... 7=domingo
$numeroDia = (int) date('N', strtotime($fecha));

// Mapa en español
$dias = [1=>"Lunes", 2=>"Martes", 3=>"Miércoles", 4=>"Jueves", 5=>"Viernes", 6=>"Sábado", 7=>"Domingo"];

echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>dia_semana</title></head><body>";
echo "La fecha {$fecha} cae en: " . $dias[$numeroDia];
echo "</body></html>";
