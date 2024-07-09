<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';
$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['dtPanolArqueoGET'])){ //LISTA DE panolS
        $productoID = $_GET['dtPanolArqueoGET'];
        require_once 'clases/dt/dt.PanolArqueo.php'; 
    }else{
        
    }
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['usuarioID']) || !isset($datos['panolID'])){
        $resp=$_respuestas->error_400();
    }else{
        # FECHA FORMATO 
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date("Y-m-d H:i:s");
        $usuarioID = htmlspecialchars($datos['usuarioID']);
        $empresaID = htmlspecialchars($datos['empresaID']);
        $panolID   = htmlspecialchars($datos['panolID']);

        $arqueo     = htmlspecialchars($datos['arqueo']);
        $detalle    = htmlspecialchars($datos['detalle']);
        $cantArqueo = htmlspecialchars($datos['cantArqueo']);
      
        //INSERTO ARQUEO
        $query = "INSERT INTO panol_arqueo (`origen`, `productoID`, `fecha`, `detalle`,`cantidad`, `idusuario`) 
                         VALUES ('$arqueo','$panolID','$fecha','$detalle','$cantArqueo','$usuarioID')"; 
        $resp  = metodoPOST($query);
        //ACTUALIZO PAÑOL
        if($arqueo==0){
            $queryU = "UPDATE panol SET  cantidad=cantidad+$cantArqueo WHERE id=$panolID"; 
            $respU  = metodoPUT($queryU);
        }else{
            $queryU = "UPDATE panol SET  cantidad=cantidad-$cantArqueo WHERE id=$panolID"; 
            $respU  = metodoPUT($queryU);
        }
    } 
    header('Content-Type: application/json');
    echo json_encode($resp);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>