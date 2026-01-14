<?php
session_start();

echo "No del usuario es ".$_SESSION['usuario'];
echo "haz vistado la pagina ".$_SESSION['visitas']." Veces";
?>