<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';
$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['panolGET'])){ //SOLICITA UN DATO ESPECIFICO POR ID
        $id    = $_GET['panolGET'];
        $query = "SELECT * FROM panol WHERE id=$id";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200); 
    }else if(isset($_GET['panolClienteGET'])){
        $empresaID = $_GET['panolClienteGET'];
        $query     = "SELECT * FROM panol WHERE idcliente=$empresaID";
        $resp      = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }else if(isset($_GET['dtPanolGET'])){ #|->LISTA DE PAÑOLES FILTRADAS POR CLIENTES
        $empresaID = $_GET['dtPanolGET']; #| idcliente
        require_once 'clases/dt/dt.Panol.php'; 
    }else{
        
    }
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['usuarioID']) || !isset($datos['nombre']) || !isset($datos['codigo'])){
        $resp=$_respuestas->error_400();
    }else{
        # FECHA FORMATO 
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date("Y-m-d H:i:s");
        $usuarioID = htmlspecialchars($datos['usuarioID']);
        $clienteID = htmlspecialchars($datos['clienteID']);
        $nombre    = htmlspecialchars($datos['nombre']);
        $codigo    = htmlspecialchars($datos['codigo']);
        $tipo      = htmlspecialchars($datos['tipo']);
        $cantidad  = htmlspecialchars($datos['cantidad']);
        $combo     = htmlspecialchars($datos['combo']);
        //INSERTO PRODUCTO
        $query2     = "INSERT INTO panol (`idcliente`, `codigo`, `producto`, `tipo_producto`, `cantidad`, `combo`) 
                              VALUES ('$clienteID','$codigo','$nombre','$tipo','$cantidad','$combo')"; 
        $resp2      = metodoPOST($query2);      
        $productoID = $resp2[0]['retornoID'];
        //INSERTO ARQUEO
        $query      = "INSERT INTO panol_arqueo (`origen`, `productoID`, `fecha`, `detalle`, `cantidad`, `idusuario`) 
                              VALUES ('0','$productoID','$fecha','Ingreso Producto','$cantidad','$usuarioID')"; 
        $resp       = metodoPOST($query);
    } 
    header('Content-Type: application/json');
    echo json_encode($resp2);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['panolID']) || !isset($datos['nombre']) || !isset($datos['codigo'])){
        $resp=$_respuestas->error_400();
    }else{
        # FECHA FORMATO 
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date("Y-m-d H:i:s");

        $clienteID = htmlspecialchars($datos['clienteID']);
        $panolID   = htmlspecialchars($datos['panolID']);
        $nombre    = htmlspecialchars($datos['nombre']);
        $codigo    = htmlspecialchars($datos['codigo']);
        $tipo      = htmlspecialchars($datos['tipo']);
        $cantidad  = htmlspecialchars($datos['cantidad']);
        $combo     = htmlspecialchars($datos['combo']);
        $query = "UPDATE panol SET idcliente='$clienteID', codigo='$codigo', producto='$nombre', tipo_producto='$tipo', cantidad='$cantidad', combo='$combo' WHERE id=$panolID"; 
        $resp  = metodoPUT($query);
    } 
    header('Content-Type: application/json');
    echo json_encode($resp);
    http_response_code(200);
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
        $query   = "DELETE FROM panol WHERE id=$panolID";
        $resp    = metodoDELETE($query);

        $query2   = "DELETE FROM panol_arqueo WHERE productoID=$panolID";
        $resp2    = metodoDELETE($query2); 
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