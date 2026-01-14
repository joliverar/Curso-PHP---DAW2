<?php
declare(strict_types=1); // Activa la verificación estricta de tipos en este archivo

namespace App\Clases; // Declara el espacio de nombres donde reside la clase

use App\Interfaces\InterfazProveedorCorreo; // Importa la interfaz que debe implementar esta clase
use PHPMailer\PHPMailer\PHPMailer; // Importa la clase PHPMailer de la librería externa
use PHPMailer\PHPMailer\Exception; // Importa la excepción de PHPMailer para manejo de errores

/**
 * Implementación de InterfazProveedorCorreo usando PHPMailer y Mailtrap.
 * Reemplaza las credenciales del constructor por las tuyas (Mailtrap).
 */
class ProveedorMailtrap implements InterfazProveedorCorreo
{
    private array $config; // Propiedad que almacena la configuración SMTP (host, puerto, credenciales, remitente)

    /**
     * $config puede contener:
     *  host, port, username, password, from_email, from_name, smtp_secure (tls/ssl)
     */
    public function __construct()
    {
        $defaults = [
            'host'       => 'sandbox.smtp.mailtrap.io', // Host SMTP por defecto (Mailtrap sandbox)
            'port'       => 2525,                         // Puerto SMTP por defecto
            'username'   => 'a4280778d0e3e1',           // Usuario SMTP (debe reemplazarse por tus credenciales)
            'password'   => 'c8703cdeafdd12',           // Contraseña SMTP (debe reemplazarse por tus credenciales)
            'from_email' => 'no-reply@example.com',     // Dirección "From" por defecto
            'from_name'  => 'Jino Mailtrap',           // Nombre remitente por defecto
            'smtp_secure'=> '',                         // Protocolo de seguridad ('tls'/'ssl') si procede
        ];

        $this->config = $defaults; // Asigna la configuración por defecto a la propiedad $config
    }

    /**
     * Envía el correo usando PHPMailer. Devuelve true si envío ok, false si fallo.
     */
    public function enviarCorreo(string $paraQuien, string $asunto, string $cuerpoMensaje): bool
    {
        $mail = new PHPMailer(true); // Crea una instancia de PHPMailer; true permite lanzar excepciones en errores

        try {
            // Configuración SMTP
            $mail->isSMTP(); // Indica que se usará transporte SMTP
            $mail->Host       = $this->config['host']; // Establece el servidor SMTP
            $mail->SMTPAuth   = true; // Activa autenticación SMTP
            $mail->Username   = $this->config['username']; // Usuario SMTP
            $mail->Password   = $this->config['password']; // Contraseña SMTP
            $mail->Port       = (int)$this->config['port']; // Puerto SMTP (forzado a entero)
            if (!empty($this->config['smtp_secure'])) {
                $mail->SMTPSecure = $this->config['smtp_secure']; // Si se indicó, usa 'tls' o 'ssl'
            }

            // Remitente y destinatario
            $mail->setFrom($this->config['from_email'], $this->config['from_name']); // Define el remitente
            $mail->addAddress($paraQuien); // Añade el destinatario pasado como argumento

            // Contenido
            $mail->isHTML(true); // Indica que el cuerpo será HTML
            $mail->Subject = $asunto; // Asigna el asunto
            $mail->Body    = $cuerpoMensaje; // Asigna el cuerpo HTML
            $mail->AltBody = strip_tags($cuerpoMensaje); // Versión en texto plano del cuerpo

            $mail->send(); // Intenta enviar el correo mediante PHPMailer

            return true; // Si no se lanza excepción, devuelve true (envío correcto)
        } catch (Exception $e) {
            // En desarrollo podrías registrar $e->getMessage() para depuración
            return false; // Si ocurre cualquier excepción, devuelve false (fallo en el envío)
        }
    }
}