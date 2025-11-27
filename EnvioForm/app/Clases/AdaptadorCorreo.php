<?php
namespace App\Clases;

use App\Interfaces\InterfazCorreo;

class AdaptadorCorreo
{
    public function preparar(array $post): array
    {
        return [
            'nombre'  => $post['nombre'] ?? '',
            'email'   => $post['email'] ?? '',
            'mensaje' => $post['mensaje'] ?? '',
        ];
    }
}
