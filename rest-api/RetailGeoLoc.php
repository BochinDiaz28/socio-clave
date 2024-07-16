<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';
$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
   /* */
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
   /* */
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['sucursalID']) || !isset($datos['direccion']) || !isset($datos['lat']) || !isset($datos['lon'])){
        $resp=$_respuestas->error_400();
    }else{
        # FECHA FORMATO 
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date("Y-m-d H:i:s");

        $lon        = htmlspecialchars($datos['lon']);
        $lat        = htmlspecialchars($datos['lat']);
        $direccion  = htmlspecialchars($datos['direccion']);
        $sucursalID = htmlspecialchars($datos['sucursalID']);
        
        $query = "UPDATE retail SET direccion='$direccion', lat='$lat', lon='$lon' WHERE id=$sucursalID"; 
        $resp  = metodoPUT($query);
    } 
    header('Content-Type: application/json');
    echo json_encode($resp);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
   /* */
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>