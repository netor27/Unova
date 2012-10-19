<?php

function sendMail($text, $html, $subject, $from, $to) {
    $text = utf8_decode($text);
    $html = utf8_decode($html);
    
    $subject = utf8_decode($subject);
    //return sendMailSMTP($text, $html, $subject, $from, $to);
    return sendMailConSendGrid($text, $html, $subject, $from, $to);
}

function sendMailConSendGrid($text, $html, $subject, $from, $to) {
    include_once "lib/php/swift/swift_required.php";
    $username = 'unovamx';
    $password = 'LanzamientoUnova2012';
    // Setup Swift mailer parameters
    $transport = Swift_SmtpTransport::newInstance('smtp.sendgrid.net', 587);
    $transport->setUsername($username);
    $transport->setPassword($password);
    $swift = Swift_Mailer::newInstance($transport);

    // Create a message (subject)
    $message = new Swift_Message($subject);

    // attach the body of the email
    $message->setFrom($from);
    $message->setBody($html, 'text/html');
    $message->setTo($to);
    $message->addPart($text, 'text/plain');
    

    // send message 
    $recipients = $swift->send($message, $failures);
    if ($recipients <= 0) {
        echo "Something went wrong - ";
        print_r($failures);
        $recipients = 0;
    }
    return $recipients;
}

function sendMailSMTP($text, $html, $subject, $from, $to) {
    require_once "modulos/email/clases/class.phpmailer.php";
    require_once "modulos/email/clases/class.smtp.php";

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;
    $mail->Username = 'contacto@unova.mx';
    $mail->Password = 'LanzamientoUnova2012';

    $mail->From = $from;
    $mail->FromName = "Unova Edu";
    $mail->Subject = $subject;
    $mail->AltBody = $text;
    
    
    $mail->MsgHTML($html);
    $mail->AddAddress($to);
    $mail->IsHTML(true);

    return $mail->Send();
}

?>