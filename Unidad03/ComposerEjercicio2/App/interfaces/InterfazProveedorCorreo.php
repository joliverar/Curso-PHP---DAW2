<?php
declare(strict_types=1);

namespace App\Interfaces;

/**
 * Interfaz para proveedores de envío de correo.
 * Implementaciones deben proporcionar enviarCorreo() y devolver true/false.
 */
interface InterfazProveedorCorreo
{
    /**
     * Envía un correo.
     *
     * @param string $paraQuien     Dirección destinatario
     * @param string $asunto        Asunto del correo
     * @param string $cuerpoMensaje Cuerpo (HTML o texto)
     * @return bool true si se envió correctamente, false en caso contrario
     */
    public function enviarCorreo(string $paraQuien, string $asunto, string $cuerpoMensaje): bool;
}