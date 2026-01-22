<?php
namespace App\Clases;

use PDO;
use PDOException;

class ConexionBD {
    // Variable estática para guardar la conexión única
    private static $instancia = null;
    
    // El constructor es privado para que nadie pueda hacer "new ConexionBD()" desde fuera
    private function __construct() {}

    public static function getConexion(): PDO {

        // Si la instancia es null, significa que es la primera vez. Creamos la conexión.
        if (self::$instancia === null) {

            try{
            $opciones = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
            // Aquí se crea la conexión REAL
            self::$instancia = new PDO(
                    dsn: $_ENV['DB_DSN'],
                    username: $_ENV['DB_USERNAME'],
                    password: $_ENV['DB_PASSWORD'],
                    options:$opciones
                );

            
            return self::$instancia;

              } catch (PDOException $e){
            die("Error de conexión a la base de datos: " . $e->getMessage());
              }
        }
          // Si ya existía, simplemente la devolvemos sin conectar de nuevo
        return self::$instancia;
    }
}
       

?>

