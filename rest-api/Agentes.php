<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';
$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['agenteID'])){                 #|-> SOLICITA TODOS LOS DATOS DE UN AGENTE POR SU ID
        $id=$_GET['agenteID'];
        $query = "SELECT * FROM agentes WHERE id=$id";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }else if(isset($_GET['Correo'])){             #|-> SOLICITA DATOS DE USUARIO POR CORREO
        $email = $_GET['Correo'];
        $query = "SELECT id,username,nombre,email,rol FROM usuarios WHERE email LIKE '$email'";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }else if(isset($_GET['agentesUserGET'])){     #|-> AGENTE SOLICITADO POR ID DE USUARIO
        $usuarioID = $_GET['agentesUserGET'];
        $query     = "SELECT * FROM agentes WHERE idusuario=$usuarioID";
        $resp      = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }else if(isset($_GET['dtagentesGET'])){       #|-> LISTA DE AGENTES
        $empresaID = $_GET['dtagentesGET'];
        require_once 'clases/dt/dt.Agentes.php'; 
    }else{
        /*
        NO SE UTILIZADA
        */
    }
}else if($_SERVER['REQUEST_METHOD'] == "POST"){   #|-> CREA UN AGENTE CON SU RESPECTIVO USUARIO
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['usuarioID']) || !isset($datos['Nombre']) || !isset($datos['Email'])){
        $resp=$_respuestas->error_400();
    }else{
        # FECHA FORMATO 
        date_default_timezone_set('America/Santiago');
        $fecha = date("Y-m-d H:i:s");
        $Direccion  = htmlspecialchars($datos['Direccion']);
        $Celular    = htmlspecialchars($datos['Celular']);
        $Dni        = htmlspecialchars($datos['Dni']);
        #|->DATOS ESTANDAR PARA CREAR EL USUARIO
        $username   = htmlspecialchars($datos['Email']);
        $nombre     = htmlspecialchars($datos['Nombre']);
        $empresaID  = htmlspecialchars($datos['empresaID']);
        $password   = '123456';//"mrenvio".rand(1111,9999);
        $passCorreo = $password;
        $password   = encriptar($password);
        $correo     = htmlspecialchars($datos['Email']);
        $query   = "SELECT COUNT(*)AS Total FROM agentes WHERE idempresa='$empresaID' AND cuit LIKE'$Dni'";
        $resp00  = metodoGET($query);
        $valores = json_encode($resp00);
        $valores = json_decode($valores, true);
        $total   = $valores[0]['Total']; 
        if($total>0){
            $resp2 []= array("error" => "EL Agente ya existe!");
        }else{
            $query   = "SELECT COUNT(*)AS Total FROM usuarios WHERE  username LIKE'$username'";
            $resp00  = metodoGET($query);
            $valores = json_encode($resp00);
            $valores = json_decode($valores, true);
            $total2   = $valores[0]['Total']; 
            if($total2>0){
                $resp2 []= array("error" => "Ya existe un usuario con ese correo!");
            }else{
                $query      = "INSERT INTO usuarios (username,idempresa,password,nombre,email,rol) values ('$username','$empresaID','$password','$nombre','$correo','200')"; 
                $resp       = metodoPOST($query);        
                $userID     = $resp[0]['retornoID'];
                #|-CREAR PERFIL DEL AGENTE       
                $query2      = "INSERT INTO agentes (`idempresa`, `idusuario`, `nombre`, `direccion`, `celular`, `email`, `cuit`,  `activo`, `fecha_alta`, `fecha_mod`) 
                                       VALUES ('$empresaID','$userID','$nombre','$Direccion','$Celular','$username','$Dni','1','$fecha','$fecha')"; 
                $resp2       = metodoPOST($query2);
            }
        }
    } //
    header('Content-Type: application/json');
    echo json_encode($resp2);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){    #|-> ACTUALIZA DATOS DE AGENTES, NO DE USUARIO DEL AGENTE
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['userID']) || !isset($datos['Nombre']) || !isset($datos['Email'])){
        $resp=$_respuestas->error_400();
    }else{
        # FECHA FORMATO 
        date_default_timezone_set('America/Santiago');
        $fecha = date("Y-m-d H:i:s");
        $userID     = htmlspecialchars($datos['userID']);
        $nombre     = htmlspecialchars($datos['Nombre']);
        $Direccion  = htmlspecialchars($datos['Direccion']);
        $Celular    = htmlspecialchars($datos['Celular']);
        $Dni        = htmlspecialchars($datos['Dni']);
        $email      = htmlspecialchars($datos['Email']); 

        $query = "UPDATE agentes SET nombre='$nombre', direccion='$Direccion', celular='$Celular', email='$email', cuit='$Dni', fecha_mod='$fecha' WHERE id=$userID"; 
        $resp  = metodoPUT($query);
    } 
    header('Content-Type: application/json');
    echo json_encode($resp);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){ #|-> ELIMINA AGENTE Y USUARIO
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
        /*POR AHORA SOLO ELIMINO DE LA TABLA AGENTES VER LUEGO
        PARA ELIMINAR DATOS ASOCIADOS*/
        $userID     = $datos['userID'];
        $query3     = "SELECT * FROM agentes WHERE id=$userID";
        $resp3      = metodoGET($query3);
        $usuarioID  = $resp3[0]['idusuario'];

        $query2  = "DELETE FROM usuarios WHERE id=$usuarioID";
        $resp2   = metodoDELETE($query2);

        $query  = "DELETE FROM agentes WHERE id=$userID";
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