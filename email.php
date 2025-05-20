<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMAILER/Exception.php';
require 'PHPMAILER/PHPMailer.php';
require 'PHPMAILER/SMTP.php';


$cuerpoMensaje = "<p>Apreciado/a ".$_SESSION["nombre_usuario"].": </p><br>";
$cuerpoMensaje .= "<p>Este es el enlace necesario para que puedas acceder al servicio.</p><br>";  // .= concatena (+=)
$cuerpoMensaje .= "<p><a href='".$_SESSION["ruta"]."'>HAZ CLICK AQUI</a></p>";


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'INTRODUCIR EMAIL AQUI';                     //SMTP username
    $mail->Password   = 'mznnijqgphuuwxun';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('INTRODUCIR EMAIL AQUI', 'Mailer');   // REMITENTE
    $mail->addAddress($_SESSION["email"], $_SESSION["nombre_usuario"]);     // RECEPTOR
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');    // con copia oculta

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->CharSet = "UTF-8";    // para tildes
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Registro en APP COlores'; // Asunto del mensaje
    $mail->Body    = $cuerpoMensaje;
    $mail->AltBody = 'Para cuando el cliente de correro no acepte HTML se enviaría este mensaje';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}