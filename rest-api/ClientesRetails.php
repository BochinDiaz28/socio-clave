<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';
$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['sucursalGET'])){ //SOLICITA UN DATO ESPECIFICO POR ID
        /*
        $id    = $_GET['sucursalGET'];
        $query = "SELECT * FROM clientes WHERE id=$id";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
        */
    }else if(isset($_GET['dtclientesRetailGET'])){ //LISTA DE RETAILS
        $empresaID = $_GET['dtclientesRetailGET'];
        $clienteID = $_GET['clienteID'];
        require_once 'clases/dt/dt.ClientesRetails.php'; 
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
    if(!isset($datos['usuarioID']) || !isset($datos['clienteID']) || !isset($datos['sucursalID'])){
        $resp=$_respuestas->error_400();
    }else{
        # FECHA FORMATO 
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date("Y-m-d H:i:s");
        $usuarioID  = htmlspecialchars($datos['usuarioID']);
        $clienteID  = htmlspecialchars($datos['clienteID']);
        $sucursalID = htmlspecialchars($datos['sucursalID']);
        $empresaID  = htmlspecialchars($datos['empresaID']);

        $query   = "SELECT COUNT(*)AS Total FROM clientes_retails 
                    WHERE idempresa='$empresaID' AND idcliente='$clienteID' AND idretail='$sucursalID'";
        $resp00  = metodoGET($query);
        $valores = json_encode($resp00);
        $valores = json_decode($valores, true);
        $total   = $valores[0]['Total']; 
        if($total>0){
            $resp2 []= array("error" => "La sucursal esta asociada!");
        }else{
            $query2     = "INSERT INTO clientes_retails (`idempresa`, `idcliente`, `idretail`) 
                                VALUES ('$empresaID','$clienteID','$sucursalID')"; 
            $resp2      = metodoPOST($query2);
        }
    } 
    header('Content-Type: application/json');
    echo json_encode($resp2);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    
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

        $query  = "DELETE FROM clientes_retails WHERE id=$userID";
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