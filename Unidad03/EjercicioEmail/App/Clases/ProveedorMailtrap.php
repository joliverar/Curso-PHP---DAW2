<?php
declare(strict_types=1);
namespace App\Clases;

use App\Interfaces\InterfazProveedorCorreos;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ProveedorMailtrap implements InterfazProveedorCorreos {

    private array $config;

    public function __construct()
    {
        $default = [
            "host"=> "sandbox.smtp.mailtrap.io",
            "port"=> 2525,
            "username"=>"a4280778d0e3e1",
            "password" => "c8703cdeafdd12",
            "from_email" =>"jino@gmail.com",
            "from_name" => "Jino Olivera",
            "smtp_secure"=>""
        ];

        $this->config = $default;
    }

    public function enviarCorreo(string $paraQuien, string $asunto, string $cuerpoMensaje): bool
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $this->config['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $this->config['username'];
            $mail->Password = $this->config['password'];
            $mail->Port = (int)$this->config['port'];

            if (!empty($this->config['smtp_secure'])) {
                $mail->SMTPSecure = $this->config['smtp_secure'];
            }

            $mail->setFrom($this->config['from_email'], $this->config['from_name']);
            $mail->addAddress($paraQuien);

            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body = $cuerpoMensaje;
            $mail->AltBody = strip_tags($cuerpoMensaje);

            $mail->send();
            return true;

        } catch (Exception $e) {
            return false;
        }
    }
}
?>
