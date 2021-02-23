<?php

namespace AnexusPHP\Core\Tools;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class Email
{
    public static function send($toEmails, $subject, $message, $fromEmail, $fromName)
    {
        $smtp_url = 'smtp.umbler.com';
        $smtp_port = 587;
        $smtp_pwd = 'Lauv@1029';
        $smtp_user = 'contato@lauvishoes.com.br';
        $smtp_fromEmail = $fromEmail;
        $smtp_fromName = $fromName;

        $transport = (new Swift_SmtpTransport($smtp_url, (int) $smtp_port,'tls'))
            ->setUsername($smtp_user)
            ->setPassword($smtp_pwd);

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);
        $emails = array();
        foreach ($toEmails as $email => $name) {
            $emails[$email] = $name;
        }

        // Create a message
        $message = (new Swift_Message($subject))
            ->setFrom([$smtp_user => $smtp_fromName])
            ->setTo($emails)
            ->setBody($message, 'text/html')
            ->setReplyTo($smtp_fromEmail,$smtp_fromName);

        // Send the message
        return $mailer->send($message);
    }
}
