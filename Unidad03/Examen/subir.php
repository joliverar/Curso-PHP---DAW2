<?php

$nombre = $_FILES["archivo"]["name"];
$tipo = $_FILES["archivo"]["type"];
$tamano = $_FILES["archivo"]["size"];

echo "<p>Nombre del archivo: .$nombre</p>";
echo "<p>Tipo del archivo: .$tipo</p>";
echo "<p>Tamano del archivo: .$tamano</p>";

?>