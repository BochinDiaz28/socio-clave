<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';

$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['clienteID'])){ //SOLICITA UN DATO ESPECIFICO POR ID
        $id=$_GET['clienteID'];
        $query = "SELECT * FROM clientes WHERE id=$id";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }else if(isset($_GET['clientesTodosGET'])){
        $empresaID = $_GET['clientesTodosGET'];
        $query     = "SELECT * FROM clientes WHERE idempresa=$empresaID";
        $resp      = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }else if(isset($_GET['clientesUserGET'])){
        $usuarioID = $_GET['clientesUserGET'];
        $query     = "SELECT * FROM clientes WHERE idusuario=$usuarioID";
        $resp      = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }else if(isset($_GET['Correo'])){ //SOLICITA UN DATO ESPECIFICO POR CORRREO
        $email = $_GET['Correo'];
        $query = "SELECT id,username,nombre,email,rol FROM usuarios WHERE email LIKE '$email'";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }else if(isset($_GET['dtclientesGET'])){ //LISTA DE CLIENTES
        $empresaID = $_GET['dtclientesGET'];
        require_once 'clases/dt/dt.Clientes.php'; 
    }else if(isset($_GET['dtretailGET'])){ //LISTA DE RETAILS
        $empresaID = $_GET['dtretailGET'];
        require_once 'clases/dt/dt.Retail.php'; 
    }else{
        /*
        NO SE UTILIZA ESTE CAMINO
        */
    }
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['usuarioID']) || !isset($datos['Nombre']) || !isset($datos['Email'])){
        $resp=$_respuestas->error_400();
    }else{
        # FECHA FORMATO 
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date("Y-m-d H:i:s");
        $Direccion  = htmlspecialchars($datos['Direccion']);
        $Celular    = htmlspecialchars($datos['Celular']);
        $Dni        = htmlspecialchars($datos['Dni']);
        #|->DATOS ESTANDAR PARA CREAR EL USUARIO
        $username   = htmlspecialchars($datos['Email']);
        $nombre     = htmlspecialchars($datos['Nombre']);
        $empresaID  = htmlspecialchars($datos['empresaID']);
        $password   = 'SC-123456';//"SC-".rand(1111,9999);
        $passCorreo = $password;
        $password   = encriptar($password);
        $correo     = htmlspecialchars($datos['Email']);
        $panol      = htmlspecialchars($datos['panol']);
        $informe    = htmlspecialchars($datos['informe']);
        $formulario = htmlspecialchars($datos['formular']);
        $cantidad   = htmlspecialchars($datos['cantidad']);
        
        $query   = "SELECT COUNT(*)AS Total FROM clientes WHERE idempresa='$empresaID' AND cuit LIKE'$Dni'";
        $resp00  = metodoGET($query);
        $valores = json_encode($resp00);
        $valores = json_decode($valores, true);
        $total   = $valores[0]['Total']; 
        if($total>0){
            $resp2 []= array("error" => "EL Cliente ya existe!");
        }else{
            $query   = "SELECT COUNT(*)AS Total FROM usuarios WHERE  username LIKE'$username'";
            $resp00  = metodoGET($query);
            $valores = json_encode($resp00);
            $valores = json_decode($valores, true);
            $total2   = $valores[0]['Total']; 
            if($total2>0){
                $resp2 []= array("error" => "Ya existe un usuario con ese correo!");
            }else{
                $query      = "INSERT INTO usuarios (username,idempresa,password,nombre,email,rol) 
                                    VALUES ('$username','$empresaID','$password','$nombre','$correo','150')"; 
                $resp       = metodoPOST($query);        
                $userID     = $resp[0]['retornoID'];
                #|-CREAR PERFIL DEL AGENTE       
                $query2     = "INSERT INTO clientes (`idempresa`, `idusuario`, `nombre`, `direccion`, `celular`, `email`, `cuit`,  `activo`, `fecha_alta`, `fecha_mod`,`panol`,`informe`, `formulario`) 
                                    VALUES ('$empresaID','$userID','$nombre','$Direccion','$Celular','$username','$Dni','1','$fecha','$fecha','$panol','$informe',' $formulario')"; 
                $resp2      = metodoPOST($query2);
                $clienteID = $resp2[0]['retornoID'];
                #|->ACTIVO FORMULAR EXTRA SI EXISTE
                if($formulario==1){
                    for ($i=0; $i <=($cantidad-1) ; $i++) { 
                        $query3 = "INSERT INTO clientes_formulario_tarea (`idcliente`) 
                                          VALUES ('$clienteID')"; 
                        $resp3  = metodoPOST($query3);
                    }
                    #|->REGISTRO CANTIDAD PARA FUTUROS CAMBIOS EN ADMINISTRACION
                    $queryC = "UPDATE clientes SET cantidad='$cantidad' WHERE id=$clienteID"; 
                    $respC  = metodoPUT($queryC);
                }

                #|->ENVIO DE CORREO A CLIENTE                
                $queryC = "SELECT host, usuario, clave, puerto FROM correo WHERE id=1";
                $respC  = metodoGET($queryC);
                
                $smtpHost    = $respC[0]['host'];
                $smtpUsuario = $respC[0]['usuario'];
                $smtpClave   = $respC[0]['clave'];
                $smtpPuerto  = $respC[0]['puerto'];
                require_once 'correos/class.correo_bienvenida.php';
            }
        }
    } 
    header('Content-Type: application/json');
    echo json_encode($resp2);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['userID']) || !isset($datos['Nombre']) || !isset($datos['Email'])){
        $resp=$_respuestas->error_400();
    }else{
        # FECHA FORMATO 
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha      = date("Y-m-d H:i:s");
        $userID     = htmlspecialchars($datos['userID']);
        $nombre     = htmlspecialchars($datos['Nombre']);
        $Direccion  = htmlspecialchars($datos['Direccion']);
        $Celular    = htmlspecialchars($datos['Celular']);
        $Dni        = htmlspecialchars($datos['Dni']);
        $email      = htmlspecialchars($datos['Email']); 
        $panol      = htmlspecialchars($datos['panol']);
        $informe    = htmlspecialchars($datos['informe']);
        $formulario = htmlspecialchars($datos['formular']);
        
        $query = "UPDATE clientes SET nombre='$nombre', direccion='$Direccion', celular='$Celular', email='$email', cuit='$Dni', fecha_mod='$fecha', panol='$panol', informe='$informe', formulario='$formulario' 
                  WHERE id=$userID"; 
        $resp  = metodoPUT($query);

        if($formulario==1){
            $cantidad   = htmlspecialchars($datos['cantidad']);
            $queryF = "SELECT COUNT(*) AS Total FROM clientes_formulario_tarea WHERE idcliente=$userID";
            $respF  = metodoGET($queryF);
            $Existe = $respF[0]['Total'];
            if($Existe==0){
                for ($i=0; $i <=($cantidad-1) ; $i++) {
                    $query3 = "INSERT INTO clientes_formulario_tarea (`idcliente`) 
                                      VALUES ('$userID')"; 
                    $resp3  = metodoPOST($query3);
                } 
                #|->REGISTRO CANTIDAD PARA FUTUROS CAMBIOS EN ADMINISTRACION
                $queryC = "UPDATE clientes SET cantidad='$cantidad' WHERE id=$userID"; 
                $respC  = metodoPUT($queryC);
            }else if($cantidad>$Existe){
                $direfencia = $cantidad-$Existe;
                for ($i=0; $i <=($direfencia-1) ; $i++) {
                    $query3 = "INSERT INTO clientes_formulario_tarea (`idcliente`) 
                                      VALUES ('$userID')"; 
                    $resp3  = metodoPOST($query3);
                }
                #|->REGISTRO CANTIDAD PARA FUTUROS CAMBIOS EN ADMINISTRACION
                $queryC = "UPDATE clientes SET cantidad=cantidad+$direfencia WHERE id=$userID"; 
                $respC  = metodoPUT($queryC); 
            }
        }


    } 
    header('Content-Type: application/json');
    echo json_encode($resp);
    http_response_code(200);
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
        $query3     = "SELECT * FROM clientes WHERE id=$userID";
        $resp3      = metodoGET($query3);
        $usuarioID  = $resp3[0]['idusuario'];

        #|->ELIMINO USUARIO DE ACCESO
        $query2  = "DELETE FROM usuarios WHERE id=$usuarioID";
        $resp2   = metodoDELETE($query2);
        #|->ELIMINO FORMULARIO EXTRA DE TAREAS
        $query3  = "DELETE FROM clientes_formulario_tarea WHERE idcliente=$userID";
        $resp3   = metodoDELETE($query3);
        #|->ELIMINO DATOS DEL CLIENTE
        $query  = "DELETE FROM clientes WHERE id=$userID";
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