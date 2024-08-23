<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';

$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['datoID'])){ //SOLICITA UN DATO ESPECIFICO POR ID
        $id    = $_GET['datoID'];
        $query = "SELECT * FROM clientes_formulario_tarea WHERE id=$id";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }else if(isset($_GET['dtdatosGET'])){ //LISTA DE RETAILS
        $clienteID = $_GET['dtdatosGET'];
        require_once 'clases/dt/dt.FormExtra.php'; 
    }else{
        /*
        NO SE UTILIZA ESTE CAMINO
        */
    }
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    /*
    NO SE UTILIZA ESTE CAMINO
    */
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['formID']) || !isset($datos['etiqueta']) || !isset($datos['requerido'])){
        $resp=$_respuestas->error_400();
    }else{
        $formID     = htmlspecialchars($datos['formID']);
        $etiqueta   = htmlspecialchars($datos['etiqueta']);
        $requerido  = htmlspecialchars($datos['requerido']);
        $tipodato  = htmlspecialchars($datos['tipodato']);
        
        $query = "UPDATE clientes_formulario_tarea SET lbl='$etiqueta', requerido='$requerido', tipodato='$tipodato'
                  WHERE id=$formID"; 
        $resp  = metodoPUT($query);
    } 
    header('Content-Type: application/json');
    echo json_encode($resp);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    $headers = getallheaders();
    if(isset($headers["datoID"])){
        $send = [ "datoID" =>$headers["datoID"] ];
        $postBody = json_encode($send);
    }else{
        $postBody = file_get_contents("php://input");
    }
    $datos = json_decode($postBody,true);
    if(!isset($datos['datoID'])){
        $resp=$_respuestas->error_400();
    }else{
        $datoID     = $datos['datoID'];

        #|->ELIMINO FORMULARIO EXTRA DE TAREAS
        $query3  = "DELETE FROM clientes_formulario_tarea WHERE id=$datoID";
        $resp3   = metodoDELETE($query3);
      
    }
    header('Content-Type: application/json');
    echo json_encode($resp3);
    http_response_code(200); 
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>