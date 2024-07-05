<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';
$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
       
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['usuarioID']) || !isset($datos['empresaID'])){
        $res=$_respuestas->error_400();
    }else{
        # FECHA FORMATO 
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha      = date("Y-m-d H:i:s");
        $usuarioID  = htmlspecialchars($datos['usuarioID']);
        $empresaID  = htmlspecialchars($datos['empresaID']);
        $Token      = $datos['Token'];
        $query      = "SELECT id,username,nombre,email,rol FROM usuarios WHERE id=$usuarioID";
        $resp       = metodoGET($query);
        $rol        =  $resp[0]['rol'];
        require_once 'Notif/SendRegistro.php';
        #|-> JSON ESTANDAR PARA IDENTIFICAR USUARIOS
        $json    = '{"userID":"'.$usuarioID.'","rol":"'.$rol.'","token":"'.$Token.'"}';
        #|-> url de la base de datos firebase
        $url     = 'https://sistemaonline-79c63-default-rtdb.firebaseio.com/SocioClave.json';
        $envio   = new aFireBase($json,$url);
        #|-> consultar si existe el token antesde enviar a guardarlo.
        $datos   = $envio->obtenerTokens();
        if (empty($datos)) {
            #|-> Si $datos está vacío, insertar un token
            $resultado = $envio->enviarDataFireBase();
            $res[] = array("retornoID" => "Token Insertado");
        } else {
            #|-> Si $datos no está vacío, realizar la búsqueda en el arreglo
            $tokenEncontrado = false; // Variable para rastrear si se encontró el token
            foreach ($datos as $clave => $valor) {
                #|-> Comparar el userID y el Token con los valores del arreglo
                if ($valor["userID"] === $usuarioID && $valor["token"] === $Token) {                  
                    $res[] = array("retornoID" => "Existe Token");
                    $tokenEncontrado = true;
                    break; #|-> Salir del bucle si se encuentra el token
                }
            }
            if (!$tokenEncontrado) {
                #|-> Si no se encontró el token en el bucle, insertar un token
                $resultado = $envio->enviarDataFireBase();
                $res[] = array("retornoID" => "Token Insertado");
            }
        }
        
    } 
    header('Content-Type: application/json');
    echo json_encode($res);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    //ESTE ABM NO SE ESTA TRABAJANDO
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    //ESTE ABM NO SE ESTA TRABAJANDO
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>