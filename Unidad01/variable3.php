<?php
/*
 * variable3.php
 * - Reutiliza cadenas y las muestra en negrita (HTML <strong> o <b>).
 */

$nombre    = "Ana";
$apellido1 = "García";
$apellido2 = "López";
$nombreCompleto = $nombre . " " . $apellido1 . " " . $apellido2;

echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>variable3</title></head><body>";
// <strong> semánticamente recomendado sobre <b>
echo "<p>Nombre completo en <strong>negrita</strong>: <strong>" . $nombreCompleto . "</strong></p>";
echo "</body></html>";
