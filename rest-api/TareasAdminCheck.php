<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';

$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
   /* */
}else if($_SERVER['REQUEST_METHOD'] == "POST"){ #|->CLONAR TAREAS FALLADAS
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['tareaID'])){
        $resp=$_respuestas->error_400();
    }else{       
        #-> FECHA FORMATO 
        date_default_timezone_set('America/Santiago');
        $fecha = date("Y-m-d H:i:s");
        #|-> RECUPERO LA TAREA A CLONAR
        $id     = htmlspecialchars($datos['tareaID']);
        $queryB = "SELECT * FROM tareas WHERE id=$id";
        $respB  = metodoGET($queryB);
        #|-> INDICO LOS DATOS A RELANZAR
        $empresaID  = $respB[0]['idempresa'];  
        $Cliente    = $respB[0]['idcliente']; 
        $Sucursal   = $respB[0]['idreail'];
        $Nombre     = $respB[0]['tarea'] ;
        $codigo     = $respB[0]['sucursal'];
        $Direccion  = $respB[0]['ubicacion'];
        $Nota       = $respB[0]['nota'];
        //fecha_alta -> SE ACTUALIZA FECHA ACTUAL
        $Solicitud  = $respB[0]['fecha_sol'];     
        $HIngreso   = $respB[0]['hora_inicio'];
        $HSalida    = $respB[0]['hora_final'];
        $Estado     = 0;
        $controlCk  = $respB[0]['checklist'];
 
        $query2 = "INSERT INTO tareas (`idempresa`, `idcliente`, `idreail`, `tarea`, `sucursal`, `ubicacion`, `lat`, `lon`, `nota`, `fecha_alta`, `fecha_sol`, `hora_inicio`, `hora_final`, `estado`, `checklist`) 
                          VALUES ('$empresaID','$Cliente','$Sucursal','$Nombre','$codigo','$Direccion','0','0','$Nota', '$fecha', '$Solicitud', '$HIngreso', '$HSalida', '$Estado','$controlCk')"; 
        $resp2  = metodoPOST($query2);   

        #|-> PASO LA TAREA A ESTADO 5 HISTORIAL DE FALLAS
        $query  = "UPDATE tareas SET estado='5' WHERE id=$id"; 
        $resp   = metodoPUT($query);
        #|-> ENVIAR CORREO DE FALLA E INFORMAR QUE SE ENVIARA UN NUEVO AGENTE

    } 
    header('Content-Type: application/json');
    echo json_encode($resp2);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['tareaID'])){
        $resp=$_respuestas->error_400();
    }else{
        # FECHA FORMATO 
        date_default_timezone_set('America/Santiago');
        $fecha = date("Y-m-d H:i:s");
        $tareaID = htmlspecialchars($datos['tareaID']);
        $cerrada = htmlspecialchars($datos['cerrada']);
        
        $query = "UPDATE tareas SET cerradaAdmin='$cerrada' WHERE id=$tareaID"; 
        $resp  = metodoPUT($query);
        if($cerrada==1){
            #|-> ENVIAR CORREO DE FINALIZADA               
            $queryC = "SELECT host, usuario, clave, puerto FROM correo WHERE id=1";
            $respC  = metodoGET($queryC);        
            $smtpHost    = $respC[0]['host'];
            $smtpUsuario = $respC[0]['usuario'];
            $smtpClave   = $respC[0]['clave'];
            $smtpPuerto  = $respC[0]['puerto'];
            //NOMBRE CLIENTE Y CORREO. nombre agente
            $queryT = "SELECT a.id, a.tarea, b.nombre as Cliente, b.email AS correoC, c.nombre as Agente
                    FROM tareas a, clientes b, agentes c  
                    WHERE a.idcliente=b.id
                    AND a.idagente=c.id
                    AND a.id=$tareaID";
            $respT  = metodoGET($queryT);        
            $tareaNom = $respT[0]['tarea'];
            $nombreC  = $respT[0]['Cliente'];
            $correoC  = $respT[0]['correoC'];
            $nobmreA  = $respT[0]['Agente'];
    
            require_once 'correos/class.correo_proyecto_entregado.php';
        }
    } 
    header('Content-Type: application/json');
    echo json_encode($resp);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
   /* */
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>