<?php
/*
 * zona_horaria_getdate.php
 * - Establece zona horaria y muestra la fecha usando getdate().
 * - getdate() retorna un array asociativo con componentes de la fecha/hora.
 */
date_default_timezone_set('Europe/Madrid');

$info = getdate();
/* $info contiene claves como:
 * 'seconds','minutes','hours','mday','wday','mon','year','yday','weekday','month','0'
 */

echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>zona_horaria_getdate</title></head><body>";
echo "Hoy es {$info['weekday']}, {$info['mday']} de {$info['month']} de {$info['year']} ";
echo "y son las {$info['hours']}:{$info['minutes']}:{$info['seconds']}.";
echo "</body></html>";
