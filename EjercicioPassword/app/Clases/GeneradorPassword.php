<?php
namespace App\Clases;

use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;

class GeneradorPassword
{
    public static function crearPassword($longitud, $mayus, $minus, $nums, $simbolos)
    {
        $generator = new ComputerPasswordGenerator();

           // configurar opciones disponibles en la librería
        $generator->setLength($longitud);
        $generator->setUppercase($mayus);
        $generator->setLowercase($minus);
        $generator->setNumbers($nums);
        $generator->setSymbols($simbolos);
    
        
        return $generator-> generatePassword();
    }
}

