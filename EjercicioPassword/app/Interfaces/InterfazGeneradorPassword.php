<?php
namespace App\Interfaces;

interface InterfazGeneradorPassword {
    public function generar($longitud, $mayus, $minus, $nums, $simbolos);
}
