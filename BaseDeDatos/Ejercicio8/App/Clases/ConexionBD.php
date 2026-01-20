<?php
namespace App\Clases;
use PDO;
use PDOException;

class ConexionBD {
    private static ?PDO $instancia = null;
    private function __construct(){}

    public static function getConexion(): PDO {
        if(self::$instancia === null){
            try {
                $opciones = [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION];
                self::$instancia = new PDO (
                    dsn: $_ENV['DB_DSN'],
                    username: $_ENV['DB_USERNAME'],
                    password: $_ENV['DB_PASSWORD'],
                    options: $opciones
                );
            } catch (PDOException $e) {
                die('Error en la conexion'). $e->getMessage();
            }
        }
        return self::$instancia;

    }
   
}
?>