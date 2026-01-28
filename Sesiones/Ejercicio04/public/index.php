<?php
declare(strict_types=1);

// Cargar el autoload generado por Composer (clases de vendor y nuestro src)
require_once __DIR__ . '/../vendor/autoload.php';

// Helper con funciones globales (flash, iniciar_sesion, etc.)
require_once __DIR__ . '/../helper.php';

use Dotenv\Dotenv;
use App\Autenticarse;

// Cargar variables de entorno desde la raíz del proyecto (.env)
// createImmutable recibe el directorio donde buscar .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad(); // safeLoad no lanza excepción si falta el .env

// Inicializar la parte de sesiones / estado para el sistema de autenticación
Autenticarse::inicializar();

// Crear/asegurar la tabla de usuarios y datos iniciales (si es necesario)
Autenticarse::configurar();

// Ejecutar la acción solicitada vía ?action=... (controlador)
Autenticarse::runAccion();