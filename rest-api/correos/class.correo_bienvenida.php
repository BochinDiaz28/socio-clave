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
                      Bienvenido (a) a Full delivery express, acabas de hacer la mejor elección para la solución de tus envíos en Santiago.<br>
                      <i> ¡Desde ahora somos tu mejor Aliado para lo que necesites!</i>
                    </p>
                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                      USUARIO: <b>'.$email.'</b>
                    </p>
                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                      CLAVE: <b>'.$password_enviar.'</b>
                    </p>
                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                    <b>CONSEJOS PARA TU PRIMER ENVÍO</b>
                    </p>
                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                    1. EMBALAJE IDEAL: Todos los paquetes deben ir cerrados herméticamente, no pueden tener espacios ni aberturas para evitar que salgan tus productos. No se aceptarán bolsas o cajas que no cumplan con este requisito.
                    </p>
                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                    2. IDENTIFICA TUS PAQUETES: Todos tus paquetes deben ir con el nombre de tu tienda y rotulados con la información del cliente.
                    </p>
                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                    3.  DATOS DEL CLIENTE: Todos los paquetes deben ir con los datos del cliente: Nombre, dirección, comuna, teléfono y una observación si es necesario.
                    </p>
                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                    3b. OBSERVACIONES: Si tu paquete requiere un trato especial debes indicarlo en el paquete y formulario, ejemplo: FRÁGIL, RECIBIR CAMBIO, MEDIDAS (80X50CM), TOMAR SOLO HORIZONTALMENTE, ETC.
                    </p>
                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                      4.INFORMAR A CLIENTE: Repartidores entregan sin horarios específicos, no entregamos en su lugar de trabajo o locales comerciales, No reciben Pagos y su tiempo de espera máximo es de 10min, cliente no puede revisar o probar el Producto, si tienen algún problema pueden hablar directamente con su tienda.
                    </p>

                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                      HORARIO DE RETIROS Y ENTREGAS
                    </p>
                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                    Todos los retiros se realizan entre las 19:30hrs a 22:30hrs y las entregas desde las 8:30hrs a 22:30hrs, en ambos casos el repartidor espera máximo 10min. Lo ideal esque publiques una historia en tus redes para que tus clientes esten atentos. <br>
                    El repartidor puede pasar desde las 19:31hrs a 22:30hrs, entre ese horario debes estar preparado(a) con la mercadería lista para su entrega.<br>
                    En el caso de no estar listo, no contestar el teléfono, o no salir del domicilio, y el repartidor se encuentra afuera o llegando, perderas el valor del retiro y solo se reembolsará el valor de los envíos no realizados.
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

$nombre  = "Bienvenido a ".$nombrePro;
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
