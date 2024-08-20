<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';
$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
  
}else if($_SERVER['REQUEST_METHOD'] == "POST"){

}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    //RECIBIMOS LOS DATOS ENVIADOS
    $postBody = file_get_contents("php://input");
    //DECODIFICAMOS LOS DATOS
    $datos = json_decode($postBody,true);
    if(!isset($datos['clienteID'])) {
        $resp=$_respuestas->error_400();
    }else{
        $clienteID = $datos['clienteID'];      
        $Foto      = htmlspecialchars($datos['Foto']);

        $query0 = "SELECT * FROM agentes
                   WHERE id=$clienteID";
        $resp0   = metodoGET($query0);    
        $valores = json_encode($resp0);
        $valores = json_decode($valores, true);
        $imagen  = $valores[0]['foto_pefil']; 

        if( strcasecmp ($imagen, $Foto)<>0){
            $Path = "../public/img/perfil/".$imagen;
            if (file_exists($Path)){
                if (unlink($Path)) {
                   
                }
            }
        }

        $query = "UPDATE agentes 
                  SET foto_pefil='$Foto ' 
                  WHERE id=$clienteID"; 
        $resp = metodoPUT($query);
        $respuesta [] = array ("rta" => "cambiada correctamente!");
    } 
    header("Content-Type: application/json");
    echo json_encode($resp);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>