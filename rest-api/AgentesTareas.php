<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';
$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['tareasRetailGET'])){ #|-> por id tarea recuperar sucursal y enviar agentes asociados
        $tareaID = $_GET['tareasRetailGET'];
        #|->RECUPERAR EL IDRETAIL
        $queryT   = "SELECT * FROM tareas WHERE id=$tareaID";
        $respT    = metodoGET($queryT);
        $retailID = $respT[0]['idreail'];
        #|->RECUPERAR LOS ID DE LOS AGENTES ASOCIADOS
        $queryR = "SELECT idagente FROM agentes_retails WHERE idretail=$retailID";
        $respR  = metodoGET($queryR);
        $total  = COUNT($respR);
        for ($i=0; $i <=($total-1) ; $i++) { 
            $agenteID = $respR[$i]['idagente'];
            $queryA = "SELECT * FROM agentes WHERE id=$agenteID";
            $respA  = metodoGET($queryA);
            $respX [] = array("Id" => $respA[0]['id'],
                              "Nombre" => $respA[0]['nombre']);
        }
        
        //$resp [] = array("retornoID" => $respX );

        header("Content-Type: application/json");
        echo json_encode($respX);
        http_response_code(200);
       
    }else if(isset($_GET['dtagentesRetailGET'])){ //LISTA DE RETAILS
        /*
        $empresaID = $_GET['dtagentesRetailGET'];
        $agenteID  = $_GET['agenteID'];
        require_once 'clases/dt/dt.AgentesRetails.php'; 
        */
    }else{
        /*
        $query = "SELECT id,username,nombre,email,rol FROM usuarios";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
        */
    }
}else if($_SERVER['REQUEST_METHOD'] == "POST"){ #|->DESDE ADMIN PARA DESASIGNARTAREAS
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['usuarioID']) || !isset($datos['tareaID'])){
        $resp=$_respuestas->error_400();
    }else{
        # FECHA FORMATO 
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha      = date("Y-m-d H:i:s");
        $usuarioID  = htmlspecialchars($datos['usuarioID']);
        $tareaID    = htmlspecialchars($datos['tareaID']);
        $empresaID  = htmlspecialchars($datos['empresaID']);
        $query2     = "UPDATE tareas SET estado='1', idagente='0' WHERE id=$tareaID"; 
        $resp2      = metodoPUT($query2);  
    }
    header('Content-Type: application/json');
    echo json_encode($resp2);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['usuarioID']) || !isset($datos['agenteID']) || !isset($datos['tareaID'])){
        $resp=$_respuestas->error_400();
    }else{
        #|-> FECHA FORMATO 
        date_default_timezone_set('America/Santiago');
        $fecha          = date("Y-m-d H:i:s");
        $usuarioID      = htmlspecialchars($datos['usuarioID']);
        $agenteID       = htmlspecialchars($datos['agenteID']);
        $tareaID        = htmlspecialchars($datos['tareaID']);
        $empresaID      = htmlspecialchars($datos['empresaID']);
        $estadoT        = htmlspecialchars($datos['estado']);
        $base64Image    = htmlspecialchars($datos['Archivo']);
        $nombreOriginal = $datos['original'];
        $comentario     = $datos['comentario'];
        #|-> RECUPERAR NOMBRE DE TAREA! 
        $queryT = "SELECT * FROM tareas WHERE id=$tareaID";
        $respT  = metodoGET($queryT);
        $Nombre = $respT[0]['tarea'];
        //control de estados
        if($estadoT==2){
            $query    = "SELECT * FROM tareas 
                         WHERE idempresa='$empresaID' AND id='$tareaID'";
            $resp00   = metodoGET($query);
            $valores  = json_encode($resp00);
            $valores  = json_decode($valores, true);
            $Estado   = $valores[0]['estado'];
            $idreail  = $valores[0]['idreail']; 
            if($Estado==1){
                $query2 = "UPDATE tareas SET estado='2', idagente='$agenteID' WHERE id=$tareaID"; 
                $resp2  = metodoPUT($query2);  
             
                #|-> ENVIAR PUSH DE TAREA INICIADA A ADMINSTRACIÓN
                require_once 'Notif/SendNotificacion.php';
                #|->DATOS A ENVIAR JSON (SON PARA EL ALTA NO AFECTARIAN EN EL ENVIO DE PUSH)
                $json    = '{"userID":"","rol":"","token":""}';
                #|-> url de la base de datos firebase
                $url     = 'https://sistemaonline-79c63-default-rtdb.firebaseio.com/SocioClave.json';
                $envio   = new aFireBase($json,$url);
                #|-> ESTO ES PARA OBTENER LOS TOKENS DE LOS USUARIOS(ADMIN PARA INFORMARLES DE LA SOLICITUD)
                $datos   = $envio->obtenerTokens();
                if (empty($datos)) {
                    #|-> Si $datos está vacío, cosa q no deberia no enviamos notificaciones
                } else {
                    #|-> Si $datos no está vacío, realizar la búsqueda en el arreglo
                    foreach ($datos as $clave => $valor) {
                        if ($valor["rol"] == 200) { #|->ALERTA DE DISPONIBLE PARA AGENTES
                            $agenteFireID = $valor["userID"];
                            #|-> RECUEPERO EL USUARIOID DEL AGENTE
                            $queryA    = "SELECT * FROM agentes WHERE id=$agenteID";
                            $respA     = metodoGET($queryA);
                            $userAgID  = $respA[0]['idusuario'];
                            #|-> ENVIO PUSH AL AL AGENTE
                            if($agenteFireID==$userAgID){
                                $message       = "Tarea adjudicada!";
                                $token         = $valor["token"];
                                $resultadoPush = $envio->enviarDataPush($message,$Nombre,$token);
                            }
                        }
                    }
                   
                }
            }else{            
                $resp2 []= array("error" => "La tarea ya no esta disponible!");
            }
        }elseif($estadoT==3){
            
            $query2 = "UPDATE tareas SET estado='$estadoT', idagente='$agenteID' WHERE id=$tareaID"; 
            $resp2  = metodoPUT($query2);

            #|-> MARCO CHECKIN
            $queryCI = "UPDATE tareas SET checkin='$fecha' WHERE id=$tareaID"; 
            $respCI  = metodoPUT($queryCI);
            #|-> Proceso imagen
            if (isBase64Image($base64Image)) {
                $slug = str_replace(
                    array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª','É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê','Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î','Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô','Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û','Ñ', 'ñ', 'Ç', 'ç'),
                    array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a','E', 'E', 'E', 'E', 'e', 'e', 'e', 'e','I', 'I', 'I', 'I', 'i', 'i', 'i', 'i','O', 'O', 'O', 'O', 'o', 'o', 'o', 'o','U', 'U', 'U', 'U', 'u', 'u', 'u', 'u','N', 'n', 'C', 'c'),
                    $Nombre);    
                $slug = strtolower($slug);
                $slug = str_replace(" ", "-", $slug);
                $slug = str_replace(",", "", $slug);
                $slug = str_replace(".", "", $slug);
                // La variable contiene una imagen en base64 válida
                $extension         = pathinfo($nombreOriginal, PATHINFO_EXTENSION);    
                $nombreArchivo     =  $slug.'-'.rand(100, 999).'.'.$extension;
                $directorioDestino = '../public/img/tarea/'.$nombreArchivo;
                $data              = str_replace(['data:image/png;base64,', 'data:image/jpeg;base64,', 'data:image/jpg;base64,'], '', $base64Image);
                $decodedData       = base64_decode($data, true);
                if(file_put_contents($directorioDestino, $decodedData)){
                    $query = "INSERT INTO tareas_fotos (idtarea, agenteID, comentario, foto, fecha) 
                                     VALUES ('$tareaID','$agenteID','$comentario','$nombreArchivo','$fecha')"; 
                    $resp1 = metodoPOST($query);
                }
            }
            
            #|-> ENVIAR PUSH DE TAREA INICIADA A ADMINSTRACIÓN
            require_once 'Notif/SendNotificacion.php';
            $message = "Tarea iniciada por agente!";
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
        }elseif($estadoT==4){
            $exito  = htmlspecialchars($datos['exito']);
            $query2 = "UPDATE tareas SET estado='$estadoT', idagente='$agenteID', cerradaAgente='$exito' WHERE id=$tareaID"; 
            $resp2  = metodoPUT($query2);       
            #|-> MARCO CHECKOUT
            $queryCO = "UPDATE tareas SET checkout='$fecha' WHERE id=$tareaID"; 
            $respCO  = metodoPUT($queryCO);
            #|-> Proceso imagen
            if (isBase64Image($base64Image)) {
                $slug = str_replace(
                    array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª','É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê','Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î','Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô','Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û','Ñ', 'ñ', 'Ç', 'ç'),
                    array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a','E', 'E', 'E', 'E', 'e', 'e', 'e', 'e','I', 'I', 'I', 'I', 'i', 'i', 'i', 'i','O', 'O', 'O', 'O', 'o', 'o', 'o', 'o','U', 'U', 'U', 'U', 'u', 'u', 'u', 'u','N', 'n', 'C', 'c'),
                    $Nombre);    
                $slug = strtolower($slug);
                $slug = str_replace(" ", "-", $slug);
                $slug = str_replace(",", "", $slug);
                $slug = str_replace(".", "", $slug);
                // La variable contiene una imagen en base64 válida
                $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);    
                $nombreArchivo     =  $slug.'-'.rand(100, 999).'.'.$extension;
                $directorioDestino = '../public/img/tarea/'.$nombreArchivo;
                $data              = str_replace(['data:image/png;base64,', 'data:image/jpeg;base64,', 'data:image/jpg;base64,'], '', $base64Image);
                $decodedData       = base64_decode($data, true);
                if(file_put_contents($directorioDestino, $decodedData)){
                    $query      = "INSERT INTO tareas_fotos (idtarea, agenteID, comentario, foto, fecha) 
                                          VALUES ('$tareaID','$agenteID','$comentario','$nombreArchivo','$fecha')"; 
                    $resp1      = metodoPOST($query);
                }
            }

            #|-> ENVIAR PUSH DE TAREA INICIADA A ADMINSTRACIÓN
            require_once 'Notif/SendNotificacion.php';
            $message = "Tarea finalizada por agente!";
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
                        $token         = $valor["token"];
                        $resultadoPush = $envio->enviarDataPush($message,$Nombre,$token);
                    }
                }
            }
        }
    } 
    header('Content-Type: application/json');
    echo json_encode($resp2);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}
function isBase64Image($data)
{
    // Verificar si la variable es una cadena
    if (!is_string($data)) {
        return false;
    }
    // Eliminar posibles caracteres no válidos en base64
    $data = str_replace(['data:image/png;base64,', 'data:image/jpeg;base64,', 'data:image/jpg;base64,'], '', $data);
    // Decodificar la cadena base64
    $decodedData = base64_decode($data, true);
    // Verificar si la decodificación fue exitosa
    if (!$decodedData) {
        return false;
    }
    // Verificar la firma de la imagen
    $imageInfo = getimagesizefromstring($decodedData);
    $mime = $imageInfo['mime'];
    // Verificar el tipo de imagen
    if (!in_array($mime, ['image/jpeg', 'image/png', 'image/gif'])) {
        return false;
    }
    // Todo parece estar correcto, es una imagen en base64 válida
    return true;
}
?>