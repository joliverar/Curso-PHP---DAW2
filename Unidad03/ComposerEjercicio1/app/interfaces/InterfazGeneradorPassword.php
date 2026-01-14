<?php
declare(strict_types=1);

namespace App\Interfaces;

interface InterfazGeneradorPassword
{
    /**
     * Genera una contraseña según opciones.
     * $opciones: ['length'=>int, 'upper'=>bool, 'lower'=>bool, 'numbers'=>bool, 'symbols'=>bool]
     */
    public function generar(array $opciones): string;
}