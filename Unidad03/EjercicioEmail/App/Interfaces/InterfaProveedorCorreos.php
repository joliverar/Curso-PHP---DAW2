<?php
declare(strict_types=1);

namespace App\Interfaces;


interface InterfazProveedorCorreos
{

    public function enviarCorreo(string $paraQuien, string $asunto, string $cuerpoMensaje): bool;
}