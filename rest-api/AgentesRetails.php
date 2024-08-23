<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';
$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['agenteRetailGET'])){                    #|->FILTRA TAREA Y CON SUCURSAL POR AGENTE EN ESTADO 1
        $agenteID = $_GET['agenteRetailGET'];
        $query = "SELECT b.id,b.tarea,b.sucursal,b.ubicacion,b.nota,b.lat,b.lon,b.fecha_sol,b.hora_inicio,b.hora_final, b.checklist, b.foto_inicio, b.foto_final  
                  FROM agentes_retails a, tareas b
                  WHERE a.idretail=b.idreail
                  AND a.idagente=$agenteID
                  AND b.estado=1";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }else if(isset($_GET['dtagentesRetailPendietesGET'])){  #|->FILTRA TAREA POR AGENTE EN ESTADO 2  
        $agenteID = $_GET['dtagentesRetailPendietesGET'];
        $query = "SELECT b.id, b.tarea, b.sucursal, b.ubicacion, b.nota, b.lat, b.lon, b.fecha_sol, b.hora_inicio, b.hora_final, b.checklist, b.foto_inicio, b.foto_final 
                  FROM tareas b
                  WHERE b.idagente = $agenteID
                  AND b.estado = 2";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }else if(isset($_GET['dtagentesRetailCursoGET'])){      #|->FILTRA TAREA POR AGENTE EN ESTADO 3
        $agenteID = $_GET['dtagentesRetailCursoGET'];
        $query = "SELECT b.id, b.idcliente, b.tarea, b.sucursal, b.ubicacion, b.nota, b.lat, b.lon, b.fecha_sol, b.hora_inicio, b.hora_final, b.checklist, b.foto_inicio, b.foto_final, c.formulario  
                  FROM tareas b, clientes c
                  WHERE b.idagente = $agenteID
                  AND b.idcliente=c.id
                  AND b.estado = 3";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }else if(isset($_GET['dtagentesRetailFinalizadasGET'])){      #|->FILTRA TAREA POR AGENTE EN ESTADO 3
        $agenteID = $_GET['dtagentesRetailFinalizadasGET'];
        $query = "SELECT b.id, b.idcliente, b.tarea, b.sucursal, b.ubicacion, b.nota, b.lat, b.lon, b.fecha_sol, b.hora_inicio, b.hora_final, b.checklist, b.foto_inicio, b.foto_final, b.cerradaAdmin 
                  FROM tareas b
                  WHERE b.idagente = $agenteID
                  AND b.estado = 4";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }else if(isset($_GET['dtagentesRetailGET'])){           #|->FILTRA SUCURSALES ASOCIADAS A AGENTES
        $empresaID = $_GET['dtagentesRetailGET'];
        $agenteID  = $_GET['agenteID'];
        require_once 'clases/dt/dt.AgentesRetails.php'; 
    }else{
        /*
        NO SE UTILIZA
        */
    }
}else if($_SERVER['REQUEST_METHOD'] == "POST"){             #|->ASOCIA AGENTES A SUCURSALES
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['usuarioID']) || !isset($datos['agenteID']) || !isset($datos['sucursalID'])){
        $resp=$_respuestas->error_400();
    }else{
        # FECHA FORMATO 
        date_default_timezone_set('America/Santiago');
        $fecha = date("Y-m-d H:i:s");
        $usuarioID  = htmlspecialchars($datos['usuarioID']);
        $agenteID   = htmlspecialchars($datos['agenteID']);
        $sucursalID = htmlspecialchars($datos['sucursalID']);
        $empresaID  = htmlspecialchars($datos['empresaID']);

        $query   = "SELECT COUNT(*)AS Total FROM agentes_retails 
                    WHERE idempresa='$empresaID' AND idagente='$agenteID' AND idretail='$sucursalID'";
        $resp00  = metodoGET($query);
        $valores = json_encode($resp00);
        $valores = json_decode($valores, true);
        $total   = $valores[0]['Total']; 
        if($total>0){
            $resp2 []= array("error" => "La sucursal esta asociada!");
        }else{
            $query2     = "INSERT INTO agentes_retails (`idempresa`, `idagente`, `idretail`) 
                                  VALUES ('$empresaID','$agenteID','$sucursalID')"; 
            $resp2      = metodoPOST($query2);
        }
    } 
    header('Content-Type: application/json');
    echo json_encode($resp2);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){              #|->NO SE UTILIZA
    
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){           #|->ELIMINA ASOCIACION DE AGENTES A SUCURSALES 
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
        $resp=$_respuestas->error_400();
    }else{
        $userID     = $datos['userID'];
        $query  = "DELETE FROM agentes_retails WHERE id=$userID";
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