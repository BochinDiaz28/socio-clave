<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';
$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
       
    if(isset($_GET['consultaGET'])){
        $consulta = $_GET['consultaGET'];
        if($consulta<>""){
            //SOLICITUD DE UNA BODEGA
            $query = "SELECT UsuarioId,Token,Estado,Fecha
                        FROM usuarios_token
                        WHERE Token LIKE'$consulta'";
            $resp = metodoGET($query);      
        }else{
            $resp []= array("Token" => "No enviado");   
        }
        //RESPUESTA TIPO JSON
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }
        

}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //ESTE ABM NO SE ESTA TRABAJANDO
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