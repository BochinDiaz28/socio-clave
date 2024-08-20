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
    if(!isset($datos['Email']) ){
        $resp=$_respuestas->error_400();
    }else{
        $Email = htmlspecialchars($datos['Email']);

        $queryE = "SELECT id,username,nombre,email,rol,activo FROM usuarios WHERE email LIKE '$Email'";
        $respE  = metodoGET($queryE);
        $usuarioID = $respE[0]['id'];
        $nombre    = $respE[0]['nombre'];

        $password   = "SC-".rand(1111,9999);
        $passCorreo = $password;
        $password   = encriptar($password);
        $query = "UPDATE usuarios SET password='$password' WHERE id=$usuarioID"; 
        $resp  = metodoPUT($query);
        #|->ENVIAR CORREO CON CLAVE NUEVA.
        $queryC = "SELECT host, usuario, clave, puerto FROM correo WHERE id=1";
        $respC  = metodoGET($queryC);
        
        $smtpHost    = $respC[0]['host'];
        $smtpUsuario = $respC[0]['usuario'];
        $smtpClave   = $respC[0]['clave'];
        $smtpPuerto  = $respC[0]['puerto'];
        require_once 'correos/class.correo_cambio_clave.php';
         
    } 
    header("Content-Type: application/json");
    echo json_encode($resp);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    //NO SE REALIZAN ACCIONES POR DELETE
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>