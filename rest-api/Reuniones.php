<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';
$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['consultaGET'])){
        $consulta = $_GET['consultaGET'];
        if($consulta==0){  #|-> SOLICITUD DE TODAS LAS REUNIONES
            // `id`, `idhipodromo`, `nombre`, `nombre_reunion`, `numero_reunion`, `idcarreras`, `estado`, `fecha_incio`, `fecha_cierre` FROM `reunion`
            $query = "SELECT *
                        FROM reunion";
            $resp = metodoGET($query);
        }else if($consulta>0){ #|-> SOLICITUD DE UNA REUNION
            //SOLICITUD DE UNA BODEGA
            $query = "SELECT *
                        FROM reunion
                        WHERE id=$consulta";
            $resp = metodoGET($query);      
        }
    //RESPUESTA TIPO JSON
    header("Content-Type: application/json");
    echo json_encode($resp);
    http_response_code(200);
    }else if(isset($_GET['lstCarrerasGET'])){ #|->SOLICITA LISTA DE CARRERAS MAXIMAS DE SISTEMA
        $query = "SELECT *
                  FROM carreras";
        $resp = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }else if(isset($_GET['datatableGET'])){
        require_once 'clases/dt/dt.Reuniones.php';
    }else{
        //responder consulta erronea
    }
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    $postBody = file_get_contents("php://input");
    $datos = json_decode($postBody,true);
    if(!isset($datos['nombre'])) {
        $resp [] = array('error' => 'Datos incompletos');
    }else{
        $nombre    = htmlspecialchars($datos['nombre']);
        $numero    = htmlspecialchars($datos['numero']);
        $cantidad  = htmlspecialchars($datos['cantidad']);
        $hipodromo = htmlspecialchars($datos['hipodromo']);
        $fecha     = htmlspecialchars($datos['fecha']);
        $hora      = htmlspecialchars($datos['hora']);
        $fechaIni  = $fecha.' '.$hora;
        #|->RECUPERAR NOMBRE DE HIPODROMO
        $queryH = "SELECT *
                   FROM hipodromos
                   WHERE id=$hipodromo";
        $respH  = metodoGET($queryH);
        $nomHip = $respH[0]['nombre'];
        #|-> CREO UNA NUEVA REUNION
        $query = "INSERT INTO reunion (idhipodromo, nombre, nombre_reunion, numero_reunion, idcarreras, estado, fecha_incio) 
                         VALUES ('$hipodromo','$nomHip','$nombre','$numero','$cantidad','Pendiente','$fechaIni')"; 
        $resp1 = metodoPOST($query);
        $valores = json_encode($resp1);
        $valores = json_decode($valores, true);
        $retornoID = $valores[0]['retornoID'];
        #|->BUCLE PARA CREAR CARRERAS    
        for ($i = 1; $i <= $cantidad; $i++) {            
            $queryC = "INSERT INTO reunion_carreras (idreunion,carrera_n,nombre_carrera) 
                       VALUES ('$retornoID', '$i', 'Carrera $i')"; 
            $respC  = metodoPOST($queryC);
        }

        $resp []= array("retornoID" => $retornoID);
    } 
    header("Content-Type: application/json");
    echo json_encode($resp);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    $postBody = file_get_contents("php://input");
    $datos = json_decode($postBody,true);
    if(!isset($datos['nombre']) || !isset($datos['reunionID'])){
        $resp [] = array('error' => 'Datos incompletos');
    }else{
        $nombre    = htmlspecialchars($datos['nombre']);
        $numero    = htmlspecialchars($datos['numero']);
        $cantidad  = htmlspecialchars($datos['cantidad']);
        $hipodromo = htmlspecialchars($datos['hipodromo']);
        $fecha     = htmlspecialchars($datos['fecha']);
        $hora      = htmlspecialchars($datos['hora']);
        $reunionID = htmlspecialchars($datos['reunionID']);
        $fechaIni  = $fecha.' '.$hora;
        #|->RECUPERAR NOMBRE DE HIPODROMO
        $queryH = "SELECT * FROM hipodromos WHERE id=$hipodromo";
        $respH  = metodoGET($queryH);
        $nomHip = $respH[0]['nombre'];
        #|-> ACTUALIZO REUNION
        $queryU = "UPDATE reunion SET idhipodromo='$hipodromo', nombre='$nomHip', nombre_reunion='$nombre', numero_reunion='$numero', idcarreras='$cantidad', fecha_incio='$fechaIni' WHERE id=$reunionID"; 
        $respU = metodoPUT($queryU);
        $resp []= array("retornoID" => $reunionID);
    } 
    header("Content-Type: application/json");
    echo json_encode($resp);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    //RECIBIMOS Y TRABAJAMOS EL HEADER
    $headers = getallheaders();
    if(isset($headers["reunionID"])){
        //RECIBIMOS LOS DATO ENVIADOS POR EL HEADER
        $send = [ 
                    "reunionID" =>$headers["reunionID"],
                    "usuarioID" =>$headers["usuarioID"]
                ];
        $postBody = json_encode($send);
    }else{
        //RECIBIMOS LOS DATOS ENVIADOS
        $postBody = file_get_contents("php://input");
    }
    //DECODIFO EL JSON CON EL ID
    $datos = json_decode($postBody,true);
    if(!isset($datos['reunionID'])){
        $resp [] = array('error' => 'Datos incompletos');
    }else{
        $reunionID = $datos['reunionID'];
        $usuarioID = $datos['usuarioID'];
        //ANTES DE ELIMINAR CONSULTAR SI ESTA RELACIONADO
        $query = "DELETE FROM reunion WHERE id=$reunionID";
        $resp = metodoDELETE($query);
    }
    //RESPUESTA TIPO JSON
    header("Content-Type: application/json");
    echo json_encode($resp);
    http_response_code(200);
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>