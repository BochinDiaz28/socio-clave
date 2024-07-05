<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';
$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){

}else if($_SERVER['REQUEST_METHOD'] === "POST"){
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos["usuario"]) || !isset($datos["password"])){
        $datosArray = $_respuestas->error_400();
        header("Content-Type: application/json");
        echo json_encode($datosArray);
        http_response_code(200);
    }else{
        $usuario  = $datos['usuario'];
        $password = $datos['password'];
        $query    = "SELECT id,username,password,rol,activo FROM usuarios WHERE username LIKE '$usuario'";
        $resp     = metodoGET($query);
        if($resp){
            if($resp[0]['activo']==1){
                if(password_verify($password,$resp[0]['password'])){ 
                    #|->crear el token       
                    $verificar = insertarToken($resp[0]['id']);
                    if($verificar){
                        #|->si se guardo
                        $result["result"] = array(
                            "token"       => $verificar,
                            "status"      => 'ok',
                            "rol"         => $resp[0]['rol'],
                            "usuario"     => $usuario,
                            "id"          => $resp[0]['id'],
                            "empresaID"   => 1
                        );
                        echo json_encode($result);
                    }else{
                        #|->ERROR AL GUARDAR EL TOKEN
                        $datosArray = $_respuestas->error_500("Error interno, No hemos podido guardar");
                        echo json_encode($datosArray);
                    }

                }else{
                    #|->CONTRASEÑA INCORRECTA
                    $datosArray = $_respuestas->error_200("El password es inválido");
                    echo json_encode($datosArray);
                } 
            }else{
                #|->EL USUARIO SE ENCUENTRA INACTIVO
                header('Content-Type: application/json');
                $result["result"] = array( "status" => 'Usuario inactivo!' );
                echo json_encode($result);
                http_response_code(200);
            }
        }else{
            #|->no existe el usuario
            $resp="El usuario $usuario no existe";
            echo json_encode($resp);
        }
    }

}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
   //
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
   //  
}else{
    $datosArray = $_respuestas->error_405();
    header("Content-Type: application/json");
    echo json_encode($datosArray);
    http_response_code(200);
}

?>