<?php

declare(strict_types=1);
//inicia session
session_start();
//vacia variables de sesion
$_SESSION = [];
//destruir session
session_destroy();
//redirigir al login
header('Location: login.php');
exit;