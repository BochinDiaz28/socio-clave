<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';

$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['consultaGET'])){ //SOLICITA UN DATO ESPECIFICO POR ID
        $id    = $_GET['consultaGET'];
        $query = "SELECT * FROM correo WHERE id=$id";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['correoID']) || !isset($datos['host']) || !isset($datos['clave']) || !isset($datos['usuario']) || !isset($datos['puerto'])){
        $resp=$_respuestas->error_400();
    }else{
        # FECHA FORMATO 
        date_default_timezone_set('America/Lima');
        $fecha    = date("Y-m-d H:i:s");
        $correoID = htmlspecialchars($datos['correoID']);
        $host     = htmlspecialchars($datos['host']);
        $clave    = htmlspecialchars($datos['clave']);
        $usuario  = htmlspecialchars($datos['usuario']);
        $puerto   = htmlspecialchars($datos['puerto']);

        $query = "UPDATE correo SET host='$host', usuario='$usuario', clave='$clave', puerto='$puerto' WHERE id=$correoID"; 
        $resp  = metodoPUT($query);
    } 
    header('Content-Type: application/json');
    echo json_encode($resp);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>