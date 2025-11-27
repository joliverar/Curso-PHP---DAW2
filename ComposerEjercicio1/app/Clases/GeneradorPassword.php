<?php
declare(strict_types=1);

namespace App\Clases;

use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;

class GeneradorPassword
{
    /**
     * Genera una contraseña usando hackzilla/password-generator
     */
    public static function generarPassword(int $length, bool $upper, bool $lower, bool $numbers, bool $symbols): string
    {
        $generator = new ComputerPasswordGenerator();

        // configurar opciones disponibles en la librería
        $generator->setUppercase($upper);
        $generator->setLowercase($lower);
        $generator->setNumbers($numbers);
        $generator->setSymbols($symbols);

        $generator->setLength($length);
        
        return $generator->generatePassword();
    }
}