<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';
$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
    
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //NO SE REALIZAN ACCIONES POR POST
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //DECODIFICAMOS LOS DATOS
    $datos = json_decode($postBody,true);
    if(!isset($datos['usuarioID']) ){
        $respuesta=$_respuestas->error_400();
    }else{

        $usuarioID = htmlspecialchars($datos['usuarioID']);
        $nPass     = htmlspecialchars($datos['nPass']);
        $oPass     = htmlspecialchars($datos['oPass']);
 
        $passCorreo=$nPass;
        $password = encriptar($nPass);

        $query    = "SELECT id,username,password,rol,activo FROM usuarios WHERE id=$usuarioID";
        $resp     = metodoGET($query);
        if($resp){
            #|->CONTROLAR PASSORD ANTERIOR
            if(password_verify($oPass,$resp[0]['password'])){
                $query = "UPDATE usuarios SET password='$password' WHERE id=$usuarioID"; 
                $resp = metodoPUT($query);
                //ENVIAR CORREO CON CLAVE NUEVA.
                $respuesta [] = array ("rta" => "Clave cambiada correctamente");
            }else{
                #|->CONTRASEÑA INCORRECTA
                $respuesta [] = array ("error" => "Error en el password anterior");
            }
           
        }else{
            #|->CONTRASEÑA INCORRECTA
            $respuesta [] = array ("error" => "Error en el envio de id usuario");
        }
         
    } 
    header("Content-Type: application/json");
    echo json_encode($respuesta);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    //NO SE REALIZAN ACCIONES POR DELETE
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>