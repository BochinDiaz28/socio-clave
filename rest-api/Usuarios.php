<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';

$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['usuarioID'])){ //SOLICITA UN DATO ESPECIFICO POR ID
        $id=$_GET['usuarioID'];
        $query = "SELECT id,username,nombre,email,rol FROM usuarios WHERE id=$id";
        $resp  = metodoGET($query);
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
    }else if(isset($_GET['userOnlineGET'])){
        $empresaID = $_GET['userOnlineGET'];
        $query = "SELECT id,nombre,rol,online FROM usuarios 
                  WHERE idempresa=$empresaID 
                  ORDER BY online DESC LIMIT 5";
        $resp  = metodoGET($query);
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }else if(isset($_GET['dtusuariosGET'])){ //LISTA DE USUARIOS
        $empresaID = $_GET['dtusuariosGET'];
        require_once 'clases/dt/dt.usuarios.php'; 
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
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['usuarioID']) || !isset($datos['Nombre']) || !isset($datos['Email'])){
        $resp=$_respuestas->error_400();
    }else{
        $username   = htmlspecialchars($datos['Email']);
        $nombre     = htmlspecialchars($datos['Nombre']);
        $rol        = htmlspecialchars($datos['Rol']);
        $empresaID  = htmlspecialchars($datos['empresaID']);
        $password   = '123456';//"mrenvio".rand(1111,9999);
        $passCorreo = $password;
        $password   = encriptar($password);
        $correo     = htmlspecialchars($datos['Email']);
       // $token      = "scl@ve".rand(1111,9999);
        #|->CONTROLAR CORREO
        $query    = "SELECT COUNT(*)AS Total FROM usuarios WHERE  username LIKE'$username'";
        $resp00   = metodoGET($query);
        $valores  = json_encode($resp00);
        $valores  = json_decode($valores, true);
        $total2   = $valores[0]['Total']; 
        if($total2>0){
            $resp []= array("error" => "Ya existe un usuario con ese correo!");
        }else{
            $query = "INSERT INTO usuarios (username,idempresa,password,nombre,email,rol) 
                             VALUES ('$username','$empresaID','$password','$nombre','$correo','$rol')"; 
            $resp  = metodoPOST($query);

            /*
            require_once 'Notif/afirebase.php';
            $message = "Es un admin";
            $title   = "Nuevo Registro";
            //este es el registro que te explico en word
            $json   = '{"loginnombre":"'.$username.'","loginpass":"'.$passCorreo.'","token":"","rol":"'.$rol.'","Activo":"false","IdTarea":""}';
            //url de la base de datos
            $url='https://prueba2-32b38-default-rtdb.firebaseio.com/SocioClave.json';
            $envio = new aFireBase($json,$url);
            //$dispositivos=$envio->obtenerTokens();
            //echo $dispositivos;
            $resultado=$envio->enviarDataFireBase();
            //echo $resultado;
            $resultadoPush=$envio->enviarDataPush($message,$title);
            //echo $resultadoPush;
            */
        }
    } 



    

    header('Content-Type: application/json');
    echo json_encode($resp);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['userID']) || !isset($datos['Nombre']) || !isset($datos['Email'])){
        $resp=$_respuestas->error_400();
    }else{
        $userID   = htmlspecialchars($datos['userID']);
        $username = htmlspecialchars($datos['Email']);
        $nombre   = htmlspecialchars($datos['Nombre']);
        $rol      = htmlspecialchars($datos['Rol']);        
        $correo   = htmlspecialchars($datos['Email']);
        $query = "UPDATE usuarios SET username='$username', nombre='$nombre', email='$correo', rol='$rol' WHERE id=$userID"; 
        $resp  = metodoPUT($query);
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
        $userID = $datos['userID'];
        $query  = "DELETE FROM usuarios WHERE id=$userID";
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