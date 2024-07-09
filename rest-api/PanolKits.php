<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';
$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['dtPanolKitsGET'])){ //LISTA DE panolS
        $panolID = $_GET['dtPanolKitsGET'];
        require_once 'clases/dt/dt.PanolKits.php'; 
    }else if(isset($_GET['elementoesKitsGET'])){
        $id    = $_GET['elementoesKitsGET'];
        $query = " SELECT a.id,b.codigo,b.producto, a.cantidad
                   FROM panol_kits a, panol b
                   WHERE a.productoID =b.id
                   AND a.panolID=$id";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200); 
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

        $producto   = htmlspecialchars($datos['producto']);
        $cantArqueo = htmlspecialchars($datos['cantArqueo']);
        
        //INSERTO ELEMENTOS AL KIT
        $query = "INSERT INTO panol_kits (`panolID`, `productoID`, `cantidad`) 
                         VALUES ('$panolID','$producto',' $cantArqueo')"; 
        $resp  = metodoPOST($query);
       
    } 
    header('Content-Type: application/json');
    echo json_encode($resp);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    $headers = getallheaders();
    if(isset($headers["panolID"])){
        $send = [
            "panolID" =>$headers["panolID"]
        ];
        $postBody = json_encode($send);
    }else{
        $postBody = file_get_contents("php://input");
    }
    $datos = json_decode($postBody,true);
    if(!isset($datos['panolID'])){
        $resp=$_respuestas->error_400(); //si no envio id usuario devuelve error
    }else{
        $panolID = $datos['panolID'];
        $query   = "DELETE FROM panol_kits WHERE id=$panolID";
        $resp    = metodoDELETE($query);
    }
    header('Content-Type: application/json');
    echo json_encode($resp);
    http_response_code(200); 
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>