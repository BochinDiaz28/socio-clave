<?php
require_once '../clases/respuestas.class.php';
require_once '../clases/conexion/bd.php';
$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){   
    
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    if (is_array($_FILES) && count($_FILES) > 0) {
        #|->SUBIMOS Y RENOMBRAMOS EL EXCEL
        $archivo = $_FILES['file']['name'];
        $tipo    = $_FILES['file']['type'];
        $destino = "../tmpExcel/cop_ret".$archivo; 
        $rta = "tmpExcel/cop_ret".$archivo; 
        if (copy($_FILES['file']['tmp_name'],$destino)) echo $rta;
        else echo "Error Al Cargar el Archivo";
              
    }else{
        echo "Error Al Cargar el Archivo";
    }
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