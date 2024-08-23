<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';
$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
       
    if(isset($_GET['consultaGET'])){
        $tareaID = $_GET['consultaGET'];
        if($_GET['consultaGET']){
            //SOLICITUD DE UNA BODEGA
            $query = "SELECT a.id, a.tarea, a.ubicacion, a.nota, a.fecha_sol, a.hora_inicio, (b.nombre) AS Agente, (c.nombre) AS Cliente, c.cuit, a.checklist, a.cerradaAgente,a.cerradaCliente, a.notaCliente, a.idcliente, c.foto_pefil
                      FROM tareas a, agentes b, clientes c 
                      WHERE a.idagente=b.id AND a.idcliente=c.id AND a.id=$tareaID";
            $resp = metodoGET($query);      
        }else{
            $resp []= array("Token" => "No enviado");   
        }
        //RESPUESTA TIPO JSON
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }
    if(isset($_GET['extrasGET'])){
        $clienteID = $_GET['extrasGET'];
        $tareaID = $_GET['tareaGET'];
        if($_GET['extrasGET']){
            //SOLICITUD DE UNA BODEGA
            $query = "SELECT a.id,a.idcliente,a.lbl,b.dato_valor 
                      FROM clientes_formulario_tarea a, tareas_clientes_especiales b  
                      WHERE a.id=b.idform
                      AND a.idcliente=$clienteID
                      AND b.idtarea=$tareaID";
            $resp = metodoGET($query);      
        }else{
            $resp []= array("error" => "No envio cliente");   
        }
        //RESPUESTA TIPO JSON
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }
    //

}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //ESTE ABM NO SE ESTA TRABAJANDO
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