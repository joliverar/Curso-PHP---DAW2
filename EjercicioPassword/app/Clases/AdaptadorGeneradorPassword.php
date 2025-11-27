<?php
namespace App\Clases;

use App\Interfaces\InterfazGeneradorPassword;

class AdaptadorGeneradorPassword implements InterfazGeneradorPassword
{
    public function generar($longitud, $mayus, $minus, $nums, $simbolos)
    {
        return GeneradorPassword::crearPassword(
            $longitud,
            $mayus,
            $minus,
            $nums,
            $simbolos
        );
    }
}
