<?php
namespace App\Interfaces;

interface InterfazCorreo
{
    public function enviar(array $datos): bool;
}
