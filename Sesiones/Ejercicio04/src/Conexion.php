<?php
declare(strict_types=1);

namespace App;

use PDO;
use PDOException;
use RuntimeException;

class Conexion
{
    private static ?PDO $instancia = null;

    private function __construct() {}

    public static function get(): PDO
    {
        if (self::$instancia === null) {
            $dsn = $_ENV['DB_DSN'] ?? getenv('DB_DSN') ?: '';
            $user = $_ENV['DB_USERNAME'] ?? getenv('DB_USERNAME') ?: '';
            $pass = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?: '';

            if ($dsn === '') {
                throw new RuntimeException('DB_DSN no definido. Carga .env antes de usar la conexión.');
            }

            try {
                $opts = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                self::$instancia = new PDO($dsn, $user, $pass, $opts);
            } catch (PDOException $e) {
                throw new RuntimeException('Error de conexión a la BD: ' . $e->getMessage(), 0, $e);
            }
        }
        return self::$instancia;
    }
}