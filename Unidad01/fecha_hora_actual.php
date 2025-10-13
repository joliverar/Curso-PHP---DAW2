<?php
/*
 * fecha_hora_actual.php
 * - Muestra fecha y hora actual. Fijamos explícitamente la zona horaria.
 */
date_default_timezone_set('Europe/Madrid'); // Ajusta a tu zona

echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>fecha_hora_actual</title></head><body>";
echo "Fecha y hora actual: " . date('Y-m-d H:i:s');
echo "</body></html>";
