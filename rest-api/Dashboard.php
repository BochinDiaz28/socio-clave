<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';
$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['empresaID'])){ //SOLICITA UN DATO ESPECIFICO POR ID
        $empresaID = $_GET['empresaID'];
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha    = date("Y-m-d");
        $IncioMes = date("Y-m-01");
        $FinalMes = date("Y-m-t");
        #|-> TAREAS PARA HOY
        $inicio = $fecha;
        $final  = $fecha;
        $query = "SELECT COUNT(id) AS Total
                  FROM tareas
                  WHERE idempresa=$empresaID
                  AND estado=0 or estado=1
                  AND fecha_sol >= '$inicio' AND fecha_sol <= '$final'";
        $respHoy = metodoGET($query); 
        #|-> RESPONDER LAS VENTAS DEL DIA
        $hoy = $respHoy[0]['Total'];

        # |-> CONSULTAR LAS TAREAS DEL MES
        $principio = $IncioMes;
        $finMes    = $FinalMes;
        $query = "SELECT COUNT(id) AS Total
                  FROM tareas
                  WHERE idempresa=$empresaID
                  AND estado=4
                  AND fecha_sol >= '$principio' AND fecha_sol <= '$finMes'";
        $respMes = metodoGET($query); 
        #|-> RESPONDER LAS VENTAS DEL MES
        $mes     = $respMes[0]['Total'];

        # |-> CONSULTAR LAS TAREAS TOTAL
        $principio2 = '2023-01-01';
        $finMes2    = '2099-12-31';
        $query2 = "SELECT COUNT(id) AS Total
                   FROM tareas
                   WHERE idempresa=$empresaID
                   AND estado=4
                   AND fecha_sol >= '$principio2' AND fecha_sol <= '$finMes2'";
        $respMes = metodoGET($query2); 
        #|-> RESPONDER LAS VENTAS DEL MES
        $historial = $respMes[0]['Total'];

        # |-> CONSULTAR LAS TAREAS ACEPTADAS
        $query3 = "SELECT COUNT(id) AS Total
                   FROM tareas
                   WHERE idempresa=$empresaID
                   AND estado=2
                   AND fecha_sol >= '$principio2' AND fecha_sol <= '$finMes2'";
        $respAcp = metodoGET($query3); 
        #|-> RESPONDER TAREAS ACEPTADAS
        $aceptadas = $respAcp[0]['Total'];

        # |-> CONSULTAR LAS TAREAS ACEPTADAS
        $query4 = "SELECT COUNT(id) AS Total
                   FROM tareas
                   WHERE idempresa=$empresaID
                   AND estado=3
                   AND fecha_sol >= '$principio2' AND fecha_sol <= '$finMes2'";
        $respCur = metodoGET($query4); 
        #|-> RESPONDER TAREAS ACEPTADAS
        $curso = $respCur[0]['Total'];
      
        #|-> RESPONDER EL LLAMADO JSON
        $resp []= array( 'Total' => $hoy,
                          'Mes'  => $mes,
                          'Historial'=> $historial,
                          'Aceptadas'=>$aceptadas,
                          'Curso'=>$curso);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200); 
    }else if(isset($_GET['sucursalesGET'])){
       
    
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
   
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
   
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>