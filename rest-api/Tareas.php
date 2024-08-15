<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';

$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['tareaID'])){ //SOLICITA UN DATO ESPECIFICO POR ID
        $id    = $_GET['tareaID'];
        $query = "SELECT * FROM tareas WHERE id=$id";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);   
    }else if(isset($_GET['sucursalesGET'])){
        $id    = $_GET['sucursalesGET'];
        $query = "SELECT * FROM tareas WHERE idempresa=$id";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);  
    }else if(isset($_GET['tareaFotoGET'])){ 
        $id    = $_GET['tareaFotoGET'];
        $query = "SELECT a.id, a.tarea, a.sucursal, a.ubicacion, b.foto, b.comentario, b.fecha, b.estado  
                  FROM tareas a, tareas_fotos b 
                  WHERE a.id=b.idtarea 
                  AND a.id=$id";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);  
    }else if(isset($_GET['tareInformeFinalGET'])){ #|->LLAMA DESDE INFORMES
        $id    = $_GET['tareInformeFinalGET'];
        $query = "SELECT a.id, a.tarea, a.ubicacion, a.nota, a.fecha_sol, a.checkin, a.checkout, (b.nombre) AS Agente, (c.nombre) AS Cliente, c.cuit, a.checklist, a.cerradaCliente, a.notaCliente
                  FROM tareas a, agentes b, clientes c 
                  WHERE a.idagente=b.id AND a.idcliente=c.id AND a.id=$id";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);  
    }else if(isset($_GET['dttareasGET'])){              #|-> TAREAS PENDIENTES O APROBADAS ESTADOS 0 Y 1 (VISTA ADMIN)
        $empresaID = $_GET['dttareasGET'];
        require_once 'clases/dt/dt.Tareas.php'; 
    }else if(isset($_GET['dttareasaceptadasGET'])){     #|->TAREAS ACEPTADAS POR UN AGENTE (VISTA ADMIN)
        $empresaID = $_GET['dttareasaceptadasGET'];
        require_once 'clases/dt/dt.TareasAceptadas.php'; 
    }else if(isset($_GET['dttareascursoGET'])){         #|-> TAREAS ESTADO 3 (VISTA ADMIN)
        $empresaID = $_GET['dttareascursoGET'];
        require_once 'clases/dt/dt.TareasCurso.php'; 
    }else if(isset($_GET['dttareasfinalizadasGET'])){   #|-> TAREAS FINALZIADAS ESTADO 4 (VISTA ADMIN)
        $empresaID = $_GET['dttareasfinalizadasGET'];
        require_once 'clases/dt/dt.TareasFinalizada.php';
    }else if(isset($_GET['dttareasfalladasGET'])){      #|->TAREAS ESTADO 5 FALLO ALGUNA DE LAS PARTES (VISTA ADMIN)
        $empresaID = $_GET['dttareasfalladasGET'];
        require_once 'clases/dt/dt.TareasFalladas.php';
    }else if(isset($_GET['listaRangoGET'])){            #|-> TAREAS FINALIZADAS POR RANGO DE FECHAS (VISTA ADMIN)
        $empresaID = $_GET['listaRangoGET'];
        $inicio    = $_GET['inicio'];
        $final     = $_GET['final'];
        require_once 'clases/dt/dt.TareasListaRangoFinalizada.php';
    }else if(isset($_GET['dttrsclisolicitadasGET'])){ //TAREAS SOLICITADAS POR UN CLIENTE
        $empresaID = $_GET['dttrsclisolicitadasGET'];
        $clienteID = $_GET['solicitaGET'];
        require_once 'clases/dt/dt.TareasClientesSolicitadas.php'; 
    }else if(isset($_GET['dttrscliaprobadasGET'])){ //TAREAS SOLICITADAS POR UN CLIENTE APROBADAS
        $empresaID = $_GET['dttrscliaprobadasGET'];
        $clienteID = $_GET['solicita1GET'];
        require_once 'clases/dt/dt.TareasClientesAprobadas.php'; 
    }else if(isset($_GET['dttrscliaceptadasGET'])){ //TAREAS SOLICITADAS POR UN CLIENTE ACEPTADAS / DESIGNADAS
        $empresaID = $_GET['dttrscliaceptadasGET'];
        $clienteID = $_GET['solicita2GET'];
        require_once 'clases/dt/dt.TareasClientesAceptadas.php'; 
    }else if(isset($_GET['dttrscliencursoGET'])){ //TAREAS SOLICITADAS POR UN CLIENTE EN CURSO
        $empresaID = $_GET['dttrscliencursoGET'];
        $clienteID = $_GET['solicita3GET'];
        require_once 'clases/dt/dt.TareasClientesEnCurso.php'; 
    }else if(isset($_GET['dttrsclifinalizadasGET'])){ //TAREAS SOLICITADAS POR UN CLIENTE EN CURSO
        $empresaID = $_GET['dttrsclifinalizadasGET'];
        $clienteID = $_GET['solicita4GET'];
        require_once 'clases/dt/dt.TareasClientesFinalizadas.php'; 
    }else{
        /*
        NO SE UTILIZA ESTE CAMINO
        */
    }
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['usuarioID']) || !isset($datos['Nombre']) || !isset($datos['Direccion'])){
        $resp=$_respuestas->error_400();
    }else{
        # FECHA FORMATO 
        date_default_timezone_set('America/Santiago');
        $fecha = date("Y-m-d H:i:s");
        $Nombre     = htmlspecialchars($datos['Nombre']);
        $Direccion  = htmlspecialchars($datos['Direccion']);
        $Cliente    = htmlspecialchars($datos['Cliente']);
        $Sucursal   = htmlspecialchars($datos['Sucursal']);
        $Solicitud  = htmlspecialchars($datos['Fecha']);        
        $HIngreso   = htmlspecialchars($datos['HIngreso']);
        $HSalida    = htmlspecialchars($datos['HSalida']);
        $Estado     = htmlspecialchars($datos['Estado']);
        $empresaID  = htmlspecialchars($datos['empresaID']);
        $Nota       = htmlspecialchars($datos['Nota']);
        $controlCk  = htmlspecialchars($datos['controlCk']);
        $foto1      = htmlspecialchars($datos['foto1']);
        $foto2      = htmlspecialchars($datos['foto2']);
        $formulario = htmlspecialchars($datos['formulario']); #|->ACTUALIZACION 15/08/24 CARGA DATOS EXTRAS EN VISTA CLIETNE
        $query  = "SELECT * FROM retail WHERE id=$Sucursal";
        $resp   = metodoGET($query);
        $codigo = $resp[0]['cod_local'];
       
        $query2  = "INSERT INTO tareas (`idempresa`, `idcliente`, `idreail`, `tarea`, `sucursal`, `ubicacion`, `lat`, `lon`, `nota`, `fecha_alta`, `fecha_sol`, `hora_inicio`, `hora_final`, `estado`, `checklist`,`foto_inicio`,`foto_final`) 
                           VALUES ('$empresaID','$Cliente','$Sucursal','$Nombre','$codigo','$Direccion','0','0','$Nota', '$fecha', '$Solicitud', '$HIngreso', '$HSalida', '$Estado','$controlCk','$foto1','$foto2')"; 
        $resp2   = metodoPOST($query2);
        $tareaID = $resp2[0]['retornoID'];

        #|->SI EXISTE EL FORMULARIO REGISTRO LOS DATOS EXTRAS
        if($formulario==1){
            #|->ARRAY DE DATOS QUE DEBERIA VENIR
            $dataExtra = $datos['dataExtra'];
            #|->RECUPERAR EL FORM COMPLETO PARA REPLICAR Y SOLICITAR O PRESENTAR LOS DATOS LUEGO
            $queryB = "SELECT * FROM clientes_formulario_tarea WHERE idcliente=$Cliente";
            $respB  = metodoGET($queryB);
            $cantidadB = COUNT($respB); 
            #|->GENERAR EL ALTA DE DATOS PARA TAREA
            for ($i=0; $i <=($cantidadB-1) ; $i++) { 
                $formID = $respB[$i]['id'];
                $queryE = "INSERT INTO tareas_clientes_especiales (`idcliente`, `idtarea`, `idform`) 
                            VALUES ('$Cliente','$tareaID','$formID')"; 
                $respE  = metodoPOST($queryE);
            }
            if (is_array($dataExtra)) {
                foreach ($dataExtra as $entry) {
                    $campoID = $entry['campoID'];   // ID del campo                  
                    $valor   = $entry['valor'];     // Valor ingresado
                    $queryU  = "UPDATE tareas_clientes_especiales SET dato_valor='$valor'
                                WHERE idcliente=$Cliente AND idtarea=$tareaID AND idform=$campoID"; 
                    $respU   = metodoPUT($queryU);
                }
            }
          
        }

        #|->ENVIO NOTIFICACION SI EL ESTADO ES 0 PARA EL ADMIN
        /*
        if($Estado==0){
            require_once 'Notif/SendNotificacion.php';
            $message = "Tarea solicitada por cliente!";
            #|->DATOS A ENVIAR JSON (SON PARA EL ALTA NO AFECTARIAN EN EL ENVIO DE PUSH)
            $json    = '{"userID":"","rol":"","token":""}';
            #|-> url de la base de datos firebase
            $url     = 'https://sistemaonline-79c63-default-rtdb.firebaseio.com/SocioClave.json';
            $envio   = new aFireBase($json,$url);
            #|->ESTO ES PARA OBTENER LOS TOKENS DE LOS USUARIOS(ADMIN PARA INFORMARLES DE LA SOLICITUD)
            $datos   = $envio->obtenerTokens();
            if (empty($datos)) {
                #|-> Si $datos está vacío, cosa q no deberia no enviamos notificaciones
            } else {
                #|-> Si $datos no está vacío, realizar la búsqueda en el arreglo
                foreach ($datos as $clave => $valor) {
                    #|-> enviar aviso de adjudicada a todos los usuarios rol 100
                    if ($valor["rol"] == 100) {                  
                        #|->ESTO ES PARA ENVIAR LAS PUSH
                        $token         = $valor["token"];
                        $resultadoPush = $envio->enviarDataPush($message,$Nombre,$token);
                    }
                }
                
            }
        
        }
        */
        #|->ENVIO NOTIFICACION SI EL ESTADO ES 1 PARA EL CLIENTE
        /*
        if($Estado==1){
            require_once 'Notif/SendNotificacion.php';
            #|->DATOS A ENVIAR JSON (SON PARA EL ALTA NO AFECTARIAN EN EL ENVIO DE PUSH)
            $json    = '{"userID":"","rol":"","token":""}';
            #|-> url de la base de datos firebase
            $url     = 'https://sistemaonline-79c63-default-rtdb.firebaseio.com/SocioClave.json';
            $envio   = new aFireBase($json,$url);
            #|->ESTO ES PARA OBTENER LOS TOKENS DE LOS USUARIOS(ADMIN PARA INFORMARLES DE LA SOLICITUD)
            $datos   = $envio->obtenerTokens();
            if (empty($datos)) {
                #|-> Si $datos está vacío, cosa q no deberia no enviamos notificaciones
            } else {
                foreach ($datos as $clave => $valor) {
                    if ($valor["rol"] == 200) { #|->ALERTA DE DISPONIBLE PARA AGENTES
                        $agenteFireID = $valor["userID"];
                        #|-> RECUPERO TODOS LOS ANGENTES ASOCIADOS AL RETAIL
                        $queryR  = "SELECT * FROM agentes_retails WHERE idretail=$Sucursal";
                        $respR   = metodoGET($queryR);
                        $cantR   = COUNT($respR);
                        #|-> RECORRO TODOS LOS AGENTES RETAILS Y ENVIO PUSH A LOS QUE CORRESPONDAN
                        for ($i=0; $i <= ($cantR-1); $i++) { 
                            $codAgente = $respR[$i]['idagente'];
                            #|->RECUEPERO EL USUARIOID DEL AGENTE
                            $queryA    = "SELECT * FROM agentes WHERE id=$codAgente";
                            $respA     = metodoGET($queryA);
                            $userAgID  = $respA[0]['idusuario'];
                            #|->ENVIO PUSH AL AL AGENTE
                            if($agenteFireID==$userAgID){
                                $message       = "Tarea Dispinible!";
                                $token         = $valor["token"];
                                $resultadoPush = $envio->enviarDataPush($message,$Nombre,$token);
                            }
                        }
                    }
                }
                
            }
        }
        */
                   
    } 
    header('Content-Type: application/json');
    echo json_encode($resp2);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['tareaID']) || !isset($datos['Nombre']) || !isset($datos['Direccion'])){
        $resp=$_respuestas->error_400();
    }else{
        # FECHA FORMATO 
        date_default_timezone_set('America/Santiago');
        $fecha = date("Y-m-d H:i:s");
        $tareaID    = htmlspecialchars($datos['tareaID']);
        $Nombre     = htmlspecialchars($datos['Nombre']);
        $Direccion  = htmlspecialchars($datos['Direccion']);
        $Cliente    = htmlspecialchars($datos['Cliente']);
        $Sucursal   = htmlspecialchars($datos['Sucursal']);
        $Solicitud  = htmlspecialchars($datos['Fecha']);        
        $HIngreso   = htmlspecialchars($datos['HIngreso']);
        $HSalida    = htmlspecialchars($datos['HSalida']);
        $Estado     = htmlspecialchars($datos['Estado']);
        $empresaID  = htmlspecialchars($datos['empresaID']);
        $Nota       = htmlspecialchars($datos['Nota']);
        $controlCk  = htmlspecialchars($datos['controlCk']);
        $foto1      = htmlspecialchars($datos['foto1']);
        $foto2      = htmlspecialchars($datos['foto2']);
        $query  = "SELECT * FROM retail WHERE id=$Sucursal";
        $resp   = metodoGET($query);
        $codigo = $resp[0]['cod_local'];
        $query  = "UPDATE tareas SET idreail='$Sucursal', tarea='$Nombre', sucursal='$codigo', ubicacion='$Direccion', lat='0', lon='0', nota='$Nota', fecha_sol='$Solicitud', hora_inicio='$HIngreso', hora_final='$HSalida', estado='$Estado', checklist='$controlCk',foto_inicio='$foto1',foto_final='$foto2' WHERE id=$tareaID"; 
        $resp   = metodoPUT($query);

        #|->ENVIO NOTIFICACION SI EL ESTADO ES 1 PARA EL CLIENTE
        /*
        if($Estado==1){
            require_once 'Notif/SendNotificacion.php';           
            #|->DATOS A ENVIAR JSON (SON PARA EL ALTA NO AFECTARIAN EN EL ENVIO DE PUSH)
            $json    = '{"userID":"","rol":"","token":""}';
            #|-> url de la base de datos firebase
            $url     = 'https://sistemaonline-79c63-default-rtdb.firebaseio.com/SocioClave.json';
            $envio   = new aFireBase($json,$url);
            #|->ESTO ES PARA OBTENER LOS TOKENS DE LOS USUARIOS(ADMIN PARA INFORMARLES DE LA SOLICITUD)
            $datos   = $envio->obtenerTokens();
            if (empty($datos)) {
                #|-> Si $datos está vacío, cosa q no deberia no enviamos notificaciones
            } else {
                #|-> Si $datos no está vacío, realizar la búsqueda en el arreglo
                foreach ($datos as $clave => $valor) {
                    #|->ALERTA DE DISPONIBLE PARA AGENTES
                    if ($valor["rol"] == 200) { 
                        $agenteFireID = $valor["userID"];
                        #|-> RECUPERO TODOS LOS ANGENTES ASOCIADOS AL RETAIL
                        $queryR  = "SELECT * FROM agentes_retails WHERE idretail=$Sucursal";
                        $respR   = metodoGET($queryR);
                        $cantR   = COUNT($respR);
                        #|-> RECORRO TODOS LOS AGENTES RETAILS Y ENVIO PUSH A LOS QUE CORRESPONDAN
                        for ($i=0; $i <= ($cantR-1); $i++) { 
                            $codAgente = $respR[$i]['idagente'];
                            #|->RECUEPERO EL USUARIOID DEL AGENTE
                            $queryA    = "SELECT * FROM agentes WHERE id=$codAgente";
                            $respA     = metodoGET($queryA);
                            $userAgID  = $respA[0]['idusuario'];
                            #|->ENVIO PUSH AL AL AGENTE
                            if($agenteFireID==$userAgID){
                                $message       = "Tarea Dispinible!";
                                $token         = $valor["token"];
                                $resultadoPush = $envio->enviarDataPush($message,$Nombre,$token);
                            }
                        }
                    }
                    #|->ALERTA DE TAREAS APROBADAS PARA CLIENTES
                    if ($valor["rol"] == 150) { 
                        $clienteFireID = $valor["userID"];
                        #|-> RECUPERO TODOS LOS ANGENTES ASOCIADOS AL RETAIL
                        $queryR  = "SELECT * FROM clientes_retails WHERE idretail=$Sucursal";
                        $respR   = metodoGET($queryR);
                        $cantR   = COUNT($respR);
                        #|-> RECORRO TODOS LOS AGENTES RETAILS Y ENVIO PUSH A LOS QUE CORRESPONDAN
                        for ($i=0; $i <= ($cantR-1); $i++) { 
                            $codCliente = $respR[$i]['idcliente'];
                            #|->RECUEPERO EL USUARIOID DEL AGENTE
                            $queryA    = "SELECT * FROM clientes WHERE id=$codCliente";
                            $respA     = metodoGET($queryA);
                            $userClID  = $respA[0]['idusuario'];
                            #|->ENVIO PUSH AL AL AGENTE
                            if($clienteFireID==$userClID){
                                $message       = "Tarea Aprobada!";
                                $token         = $valor["token"];
                                $resultadoPush = $envio->enviarDataPush($message,$Nombre,$token);
                            }
                        }
                    }
                }
                
            }
        }
            */
    } 
    header('Content-Type: application/json');
    echo json_encode($resp);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    $headers = getallheaders();
    if(isset($headers["userID"])){
        $send = [ "userID" =>$headers["userID"] ];
        $postBody = json_encode($send);
    }else{
        $postBody = file_get_contents("php://input");
    }
    $datos = json_decode($postBody,true);
    if(!isset($datos['userID'])){
        $resp=$_respuestas->error_400(); //si no envio id usuario devuelve error
    }else{
        $userID = $datos['userID'];
        #|->ELIMINO LA TAREA RAIZ
        $query  = "DELETE FROM tareas WHERE id=$userID";
        $resp   = metodoDELETE($query);
        #|-> DATOS EXTRAS DE FORMULARIOS
        $query  = "DELETE FROM tareas_clientes_especiales WHERE idtarea=$userID";
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