<?php
 //Para esta parte del programa me he guiado de
 //la exposición de mis compañeros Valentino y Marcos.
 //session_start();
 //Añadimos archivos necesarios.
 require "../lib/PHPMailer/src/Exception.php";
 require "../lib/PHPMailer/src/PHPMailer.php";
 require "../lib/PHPMailer/src/SMTP.php";
 //Importamos librerias necesarias
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
 //Si el rol es diferente del de clientes, redirigimos.
 if ($_SESSION["rol"] != 0) {
    header("Location: ./inicio.php");
}
//Si no se ha creado una sesión con el nombre de usuario, redirigimos.
 if(!$_SESSION["username"]) {
     header("Location ../index.html");
 };
 
if (isset($_POST["contact"])) {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "joelvideoclub@gmail.com";
    //Contraseña de aplicación
    $mail->Password = "biluaxpxmofyihbo";
    $mail->SMTPSecure = "ssl";
    $mail->Port = 465;
    //Email emisor
    $mail->setFrom("joelvideoclub@gmail.com");
    //Dirección email que recibirá el mensaje
    $mail->addAddress($_POST["mail"]);
    $mail->isHTML(true);
    //Asunto del correo electrónico.
    $mail->Subject = "INCIDENCIA VIDEOCLUB" . strtoupper($_POST["name"]);
    $mail->Body = $_POST["text"];
    $mail->send();
    header("Location: ./inicio.php?contacto=true");
} else { header("Location: ./inicio.php"); }



