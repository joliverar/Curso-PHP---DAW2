<?php

echo "<h2>Informacion dle servidor</h2>";
echo "<p>Navegador del usuario: " .$_SERVER['HTTP_USER_AGENT']."</p>";

echo "<p>Ip de usuario: " .$_SERVER['REMOTE_ADDR']."</p>";

echo "<p>Ruta de script: " .$_SERVER['PHP_SELF']."</p>";
?>