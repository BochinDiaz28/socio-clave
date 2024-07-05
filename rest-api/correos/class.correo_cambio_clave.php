<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
date_default_timezone_set('America/Argentina/Buenos_Aires');

$email = $email; 

require("class.phpmailer.php");
require("class.smtp.php");
//ENVIO EMAIL USUARIOS
$asunto = "Bienvenido a ".$nombrePro;
$cuerpo = '<!DOCTYPE html>
<html lang="es" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <title></title>
  <style>
    table, td, div, h1, p {font-family: Arial, sans-serif;}
  </style>
</head>
<body>
  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
    <tr>
      <td align="center" style="padding:0;">
        <table role="presentation" style="width:602px;border-collapse:collapse;border:0px solid #ffffff;border-spacing:0;text-align:left;">
          <tr>
            <td align="center" style="padding:40px 0 30px 0;background:#ffffff;">
              <img src="http://testpaquteria.sistema-online.cl/public/img/logo_bienvenida.png" alt="" width="100" style="height:auto;display:block;" />
            </td>
          </tr>
          <tr>
            <td style="padding:36px 30px 42px 30px;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                <tr>
                  <td style="padding:0 0 36px 0;color:#153643;">
                    <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hola '.$nombre.'.</h1>
                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                      Tu clave de Full delivery express a cambiado!.<br>
                    </p>
                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                      USUARIO: <b>'.$email.'</b>
                    </p>
                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                      CLAVE: <b>'.$password_enviar.'</b>
                    </p>
                    
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td style="padding:30px;background:#6AACED;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                <tr>
                  <td style="padding:0;width:50%;" align="left">
                    <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                      &reg; FDE 
                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>';

$nombre  = "Cambio de Clave en ".$nombrePro;
$mensaje = $cuerpo;

// Datos de la cuenta de correo utilizada para enviar vía SMTP
$smtpHost    = "fde.sistema-online.cl";//$smtpHost0;    //"mail.arriendanow.com";  // Dominio alternativo brindado en el email de alta 
$smtpUsuario = "noreply@fde.sistema-online.cl"; //$smtpUsuario0; //"notificaciones-no-reply@arriendanow.com"; 
$smtpClave   = "qcAGxr*CoCH]";//$smtpClave0;   //"6ai7USJe==yk";

// Email de destino cliente
$emailDestino = $email;

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth   = true;
$mail->Port       = 465;//$smtpPuerto0; 
$mail->SMTPSecure = 'ssl';
$mail->IsHTML(true); 
$mail->CharSet    = "utf-8";

// VALORES A MODIFICAR //
$mail->Host     = $smtpHost; 
$mail->Username = $smtpUsuario; 
$mail->Password = $smtpClave;

$mail->From     = "noreply@fde.sistema-online.cl";//$smtpUsuario0; //"noreply@fde.sistema-online.cl";//$email; // Email desde donde envío el correo.
$mail->FromName = $nombre;
$mail->AddAddress($emailDestino); // Esta es la dirección a donde enviamos los datos del formulario

$mail->Subject = $asunto;//"DonWeb - Ejemplo de formulario de contacto"; // Este es el titulo del email.
//$mensajeHtml = nl2br($mensaje);
$mail->Body = "{$mensaje}"; // Texto del email en formato HTML
// FIN - VALORES A MODIFICAR //

$estadoEnvio = $mail->Send(); 
/*
if($estadoEnvio){
    //echo "El correo fue enviado correctamente.";
    $respuesta []= array("rta" => 1); 
} else {
    //echo "Ocurrió un error inesperado.";
    $respuesta []= array("rta" => 2); 
}
header("Content-Type: application/json");
echo json_encode($respuesta);
http_response_code(200);
*/
?>
