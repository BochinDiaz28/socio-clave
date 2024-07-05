<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';
$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['sucursalID'])){ //SOLICITA UN DATO ESPECIFICO POR ID
        $id    = $_GET['sucursalID'];
        $query = "SELECT * FROM retail WHERE id=$id";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);   
    }else if(isset($_GET['sucursalesGET'])){
        $id    = $_GET['sucursalesGET'];
        $query = "SELECT * FROM retail WHERE idempresa=$id";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);  
    }else if(isset($_GET['sucursalesClientesGET'])){ #|->SUCURSALES ASOCIADAS A CLIENTES
        $clienteID = $_GET['sucursalesClientesGET'];
        $empresaID = $_GET['empresaID'];
        $query     = "SELECT a.id,a.idretail,c.canal,c.cod_local,c.local 
                      FROM clientes_retails a, clientes b, retail c 
                      WHERE a.idempresa=$empresaID
                      AND a.idcliente=$clienteID
                      AND a.idcliente=b.id
                      AND a.idretail=c.id";
        $resp      = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);  
    }else if(isset($_GET['dtretailGET'])){ //LISTA DE RETAILS
        $empresaID = $_GET['dtretailGET'];
        require_once 'clases/dt/dt.Retail.php'; 
    }else{
        /*
        $query = "SELECT id,username,nombre,email,rol FROM usuarios";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
        */
    }
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['usuarioID']) || !isset($datos['canal']) || !isset($datos['codigo'])){
        $resp=$_respuestas->error_400();
    }else{
        # FECHA FORMATO 
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date("Y-m-d H:i:s");
        $canal     = htmlspecialchars($datos['canal']);
        $codigo    = htmlspecialchars($datos['codigo']);
        $cadena    = htmlspecialchars($datos['cadena']);
        $local     = htmlspecialchars($datos['local']);
        $direccion = htmlspecialchars($datos['direccion']);
        $formato   = htmlspecialchars($datos['formato']);
        $empresaID = htmlspecialchars($datos['empresaID']);
        #|-CREAR SUCURSAL     
        $query   = "SELECT COUNT(*)AS Total FROM retail WHERE idempresa='$empresaID' AND cod_local LIKE'$codigo'";
        $resp00  = metodoGET($query);
        $valores = json_encode($resp00);
        $valores = json_decode($valores, true);
        $total   = $valores[0]['Total']; 
        if($total>0){
            $resp2 []= array("error" => "EL Codigo ya existe!");
        }else{
            $query2      = "INSERT INTO retail (`idempresa`, `canal`, `cod_local`, `cadena`, `local`, `direccion`, `lat`, `lon`, `formato_local`) 
                                VALUES ('$empresaID','$canal','$codigo','$cadena','$local','$direccion','0','0','$formato')"; 
            $resp2       = metodoPOST($query2);
        }            
    } 
    header('Content-Type: application/json');
    echo json_encode($resp2);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['sucursalID']) || !isset($datos['canal']) || !isset($datos['codigo'])){
        $resp=$_respuestas->error_400();
    }else{
        # FECHA FORMATO 
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date("Y-m-d H:i:s");
        $canal      = htmlspecialchars($datos['canal']);
        $codigo     = htmlspecialchars($datos['codigo']);
        $cadena     = htmlspecialchars($datos['cadena']);
        $local      = htmlspecialchars($datos['local']);
        $direccion  = htmlspecialchars($datos['direccion']);
        $formato    = htmlspecialchars($datos['formato']);
        $empresaID  = htmlspecialchars($datos['empresaID']);
        $sucursalID = htmlspecialchars($datos['sucursalID']);
        
        $query = "UPDATE retail SET canal='$canal', cod_local='$codigo', cadena='$cadena', local='$local', direccion='$direccion', formato_local='$formato' WHERE id=$sucursalID"; 
        $resp  = metodoPUT($query);
    } 
    header('Content-Type: application/json');
    echo json_encode($resp);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    $headers = getallheaders();
    if(isset($headers["userID"])){
        $send = [
            "userID" =>$headers["userID"]
        ];
        $postBody = json_encode($send);
    }else{
        $postBody = file_get_contents("php://input");
    }
    $datos = json_decode($postBody,true);
    if(!isset($datos['userID'])){
        $resp=$_respuestas->error_400(); //si no envio id usuario devuelve error
    }else{
        $userID     = $datos['userID'];
        $query  = "DELETE FROM retail WHERE id=$userID";
        $resp   = metodoDELETE($query);
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