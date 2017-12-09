<?php
require("/PHPMailer/PHPMailerAutoload.php");

function sendMail($email, $subject, $body, $wordWrap) {


    $mail = new PHPMailer();
    $recipient = $email;
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'tls';
    $mail->Host = "smtp.office365.com";
    $mail->Port = 587; // or 587
    $mail->CharSet = "UTF-8";
    $mail->Username = "sis_cined@uned.ac.cr";
    $mail->Password = "SCU.2016";
    $mail->SetFrom("sis_cined@uned.ac.cr");
    $mail->AddAddress($recipient);
    $mail->Subject = $subject;
    $mail->IsHTML(true);
    $mail->Body = $body;
    $mail->WordWrap = $wordWrap;
	
    
    if(!$mail->send()){
        echo "error:". $mail->ErrorInfo;
    }else{
        echo "se envio con exito";
    }


}

$id = "115800918";
$clave = "hola";
$nombre = "Bryan";
$tipo = "asesor";
$email = "bryanr9418@hotmail.com";
$subject = "CINED - Credenciales de usuario";
$body = "<h3>" . $nombre . ":</h3><br />";

sendMail($email, $subject, $body, 50);

//$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
//
// $sqlEn = "SELECT correo FROM tfgencargados where id = 'encargado'" ;
//    $resultadoEn = mysqli_query($connection, $sqlEn);
//    $rowE = $resultadoEn->fetch_assoc();
//    
//    echo $rowE['correo'];

//$nombre = 'bryan';
//$tipo = 'nose';
//$link = 'fdsa';
//$clave= 'pero';
//$body = "<h3 style='color:#00519E'> Hola " . $nombre . ":</h3>";
//    $body .= "<p style=color:#00519E>Usted ha sido registrado como <b>" . $tipo . "</b> en el sistema del Centro de Investigación de la Escuela de Educación - CINED. </br></br> Su clave temporal es la siguiente:<b><font size='5'> " . $clave ."</font></b><br><br>"
//            . " Por favor haga click en el enlace para cambiar su clave: <a href='" . $link . "'>Ingrese aquí.</a></p>";
//echo $body
?>