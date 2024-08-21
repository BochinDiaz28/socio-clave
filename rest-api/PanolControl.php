<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';
$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['panolControlGET'])){      //SOLICITA UN DATO ESPECIFICO POR ID
        $tareaID  = $_GET['panolControlGET'];
        $queryCtl = "SELECT * FROM tarea_productos WHERE idtarea=$tareaID";
        $resp     = metodoGET($queryCtl);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200); 
    }
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['productoID']) || !isset($datos['tareaID'])){
        $resp=$_respuestas->error_400();
    }else{
        #|-> FECHA FORMATO 
        date_default_timezone_set('America/Santiago');
        $fecha      = date("Y-m-d H:i:s");
        $tareaID    = htmlspecialchars($datos['tareaID']);
        $productoID = htmlspecialchars($datos['productoID']);
        $Cantidad   = htmlspecialchars($datos['Cantidad']);
        $arqueo     = htmlspecialchars($datos['arqueo']);
        $detCtrl    = htmlspecialchars($datos['detalle']);
        $lote       = htmlspecialchars($datos['lote']);
        #|-> SELEC DE PRODUCTOS PARA SACAR LOS DATOS.
        $queryP  = "SELECT * FROM panol WHERE id=$productoID";
        $respP   = metodoGET($queryP);
        $barcode = $respP[0]['codigo'];
        $detalle = $respP[0]['producto'];
        $cantX   = $respP[0]['cantidad'];
        #|-> INSERTO MOVIMIENTO
        $queryCtl  = "SELECT COUNT(*) AS Total FROM tarea_productos WHERE idtarea=$tareaID AND idproducto=$productoID";
        $respCtl   = metodoGET($queryCtl);
        $control   = $respCtl[0]['Total'];
        if($control==0){
            $query = "INSERT INTO tarea_productos (`idtarea`, `idproducto`, `codigo`, `producto`, `cantidad`, `dato1`, `dato2`) 
                             VALUES ('$tareaID','$productoID','$barcode','$detalle','$Cantidad','$detCtrl','$lote')"; 
            $resp  = metodoPOST($query);
        }else{
            $resp[] = array("error" => "Ya controlo este producto");
        }
        //ACTUALIZO PAÑOL
        if($arqueo==0){
            //$queryU = "UPDATE panol SET  cantidad=cantidad+$cantArqueo WHERE id=$productoID"; 
            //$respU  = metodoPUT($queryU);
        }else{
            //$queryU = "UPDATE panol SET  cantidad=cantidad-$Cantidad WHERE id=$productoID"; 
            //$respU  = metodoPUT($queryU);
        }
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
        $query   = "DELETE FROM tarea_productos WHERE id=$panolID";
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