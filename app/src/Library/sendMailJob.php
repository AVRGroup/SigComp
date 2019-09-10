<?php
namespace App\Library;
require_once('MailSender.php');

$mail = new MailSender;

$mail->sendMail();
