<?php
declare(strict_types=1);
namespace App\Clases;

use App\Interfaces\InterfazProveedorCorreos;

class ServicioCorreo {

    private InterfazProveedorCorreos $proveedor;

    public function __construct(InterfazProveedorCorreos $proveedor)
    {
        $this->proveedor = $proveedor;
    }

    public function enviarCorreo(string $paraQuien, string $asunto, string $cuerpoMensaje): bool
    {
        return $this->proveedor->enviarCorreo($paraQuien, $asunto, $cuerpoMensaje);
    }
}
?>
