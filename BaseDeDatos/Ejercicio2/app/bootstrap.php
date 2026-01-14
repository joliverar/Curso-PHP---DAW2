<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Cargar .env desde la raíz del proyecto
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

// Incluir funciones de la aplicación
//Ver archivo leer
if (is_readable(__DIR__ . '/../app/Helpers/funcionesBD.php')) {
    require_once __DIR__ . '/../app/Helpers/funcionesBD.php';
}