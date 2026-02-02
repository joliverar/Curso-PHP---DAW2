<?php

namespace App\Clases;

use PDO;
use PDOException;

class ConexionBD
{
  private static $instancia = null;

  private function __construct() {}

  public static function getConexion(): PDO
  {
    if (self::$instancia === null) {
      try {
        $opciones = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        self::$instancia = new PDO(
          dsn: $_ENV['DB_DSN'],
          username: $_ENV['DB_USERNAME'],
          password: $_ENV['DB_PASSWORD'],
          options: $opciones
        );
        return self::$instancia;
      } catch (PDOException $e) {
        die('error en la conexion a la base de datos') . $e->getMessage();
      }
    }
    return self::$instancia;
  }
}
