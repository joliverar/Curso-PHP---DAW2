<?php
declare(strict_types=1);

namespace App\Clases;

use App\Interfaces\InterfazGeneradorPassword;

/**
 * Adaptador que implementa la interfaz InterfazGeneradorPassword.
 * Traduce el array de opciones recibido desde el formulario a
 * los parámetros esperados por la clase GeneradorPassword.
 */
class AdaptadorGeneradorPassword implements InterfazGeneradorPassword
{
    /**
     * Genera una contraseña según las opciones proporcionadas.
     *
     * @param array $opciones Array con claves:
     *                       - 'length'  => int   (longitud deseada)
     *                       - 'upper'   => bool  (incluir mayúsculas)
     *                       - 'lower'   => bool  (incluir minúsculas)
     *                       - 'numbers' => bool  (incluir números)
     *                       - 'symbols' => bool  (incluir símbolos)
     *
     * @return string contraseña generada
     */
    public function generar(array $opciones): string
    {
        // Extraer y normalizar la longitud (por defecto 12)
        $length = (int) ($opciones['length'] ?? 12);

        // Normalizar checkboxes a booleanos (true si están presentes y no vacíos)
        $upper   = !empty($opciones['upper']);   // mayúsculas
        $lower   = !empty($opciones['lower']);   // minúsculas
        $numbers = !empty($opciones['numbers']); // números
        $symbols = !empty($opciones['symbols']); // símbolos

        // Delegar la generación real a la clase GeneradorPassword
        // (método estático que encapsula la librería hackzilla/password-generator)
        return GeneradorPassword::generarPassword($length, $upper, $lower, $numbers, $symbols);
    }
}