<?php
namespace App\Clases;

use App\Interfaces\InterfazCorreo;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EnviaCorreo implements InterfazCorreo
{
    public function enviar(array $datos): bool
    {
        $mail = new PHPMailer(true); // Cartero profesional

        try {
            // CONFIGURAR SMTP DE MAILTRAP
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = 'a4280778d0e3e1';
            $mail->Password = 'c8703cdeafdd12';
            $mail->Port = 587;

            // QUIÉN ENVÍA
            $mail->setFrom($datos['email'], $datos['nombre']);

            // QUIÉN RECIBE
            $mail->addAddress("destinatario@ejemplo.com");

            // CONTENIDO DE LA CARTA
            $mail->Subject = "Nuevo mensaje de contacto";
            $mail->Body    = $datos['mensaje'];

            // ENVIAR
            return $mail->send();

        } catch (Exception $e) {
            return false;
        }
    }
}
