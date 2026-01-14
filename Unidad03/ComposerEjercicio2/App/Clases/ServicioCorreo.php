<?php
declare(strict_types=1);

namespace App\Clases;

use App\Interfaces\InterfazProveedorCorreo;

/**
 * Servicio que orquesta el envío de correos usando un proveedor que implemente la interfaz.
 */
class ServicioCorreo
{
    private InterfazProveedorCorreo $proveedor;

    public function __construct(InterfazProveedorCorreo $proveedor)
    {
        $this->proveedor = $proveedor;
    }

    /**
     * Delegar el envío al proveedor.
     */
    public function enviarCorreo(string $paraQuien, string $asunto, string $cuerpoMensaje): bool
    {
        return $this->proveedor->enviarCorreo($paraQuien, $asunto, $cuerpoMensaje);
    }
}