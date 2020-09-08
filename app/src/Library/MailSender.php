<?php
namespace App\Library;
use PHPMailer\PHPMailer\PHPMailer;

require_once(__DIR__ . '/../../../vendor/phpmailer/phpmailer/src/PHPMailer.php');
require_once(__DIR__ . '/../../../vendor/phpmailer/phpmailer/src/SMTP.php');

class MailSender
{
    protected $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer;
        $this->mail->isSMTP();
        $this->mail->SMTPDebug = 0;
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->Port = 465;
        $this->mail->SMTPSecure = 'ssl';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = "gamificacaoufjf@gmail.com";
        $this->mail->Password = "prj#game";
        $this->mail->CharSet = "utf-8";
    }

    public function sendMail($numeroCertificados)
    {
        $mail = $this->mail;

        $mail->setFrom('gamificacaoufjf@gmail.com', 'Gamificacao UFJF');
        $mail->addAddress('bolsistacomputacaonoturno@gmail.com', 'Bolsista');

        $mail->Subject = 'SigComp - Novos Certificados para Validação';
        $mail->isHTML(true);
        $mail->Body =
            "<p> Prezado(a) bolsista, </p>
             <p>Há novos certificados no sistema <a href='http://sigcomp.nrc.ice.ufjf.br'>SigComp</a> para avaliação.</p>";

        $mail->send();
    }

    public function sendMailAlunos($emailToSend, $nome)
    {
        $mail = $this->mail;

        $mail->setFrom('gamificacaoufjf@gmail.com', 'Gamificacao UFJF');
        $mail->addAddress($emailToSend, $nome);

        $mail->isHTML(true);
        $mail->Subject = 'SigComp - Avalição Gamificação!';
        $mail->Body = "   Prezado(a) $nome,";
        $mail->Body .= "entre em nosso sistema SigComp - Gamificação para finalizar as avaliações!\n";
        $mail->Body .= "<p><a href='http://sigcomp.nrc.ice.ufjf.br' class='button'> Acessar o sistema </a></p>";
        $mail->Body .= "<p><i>Por favor, não responda esse e-mail.</i></p> \n";

        return $mail->send();
    }
}