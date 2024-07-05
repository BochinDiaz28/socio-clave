<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';
$_respuestas = new respuestas();
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['Usuario']) || !isset($datos["Password"])){
        //ERROR AL ENVIAR LOS CAMPOS
        header("Content-Type: application/json");
        $resp=$_respuestas->error_400();
        http_response_code(200);
    }else{
        date_default_timezone_set('America/Santiago');
        $fecha = date("Y-m-d H:i:s");
        //CAMPOS OK, REALIZA EL QUERY 
        $usuario  = $datos['Usuario'];
        $password = $datos['Password'];
        $query    = "SELECT id,username,password,rol,activo FROM usuarios WHERE username LIKE '$usuario'";
        $resp     = metodoGET($query);
        if($resp){
            #|->CONTROLAR USUARIO ACTIVO
            if($resp[0]['activo']==1){
                if(password_verify($password,$resp[0]['password'])){ 
                    #|->CREAR TOKEN
                    $verificar = insertarToken($resp[0]['id']);
                    if($verificar){                    
                        $usuarioID=$resp[0]['id'];                      
                        #|-> ACTUALIZAR ESTADO USUARIO
                        $queryO = "UPDATE usuarios SET online='$fecha' WHERE id=$usuarioID"; 
                        $respO  = metodoPUT($queryO);                    
                        #|-> GENERO EL TOKEN DEVUELVO EL ARRAY PARA LA SESSION
                        $result["result"] =  array(
                                "token"     => $verificar,
                                "status"    => 'ok',
                                "rol"       => $resp[0]['rol'],
                                "usuario"   => $usuario,
                                "id"        => $resp[0]['id'],
                                "empresaID" => 1
                            );   
                        header('Content-Type: application/json');
                        echo json_encode($result);
                        http_response_code(200);
                    }else{
                        #|-> ERROR AL GUARDAR EL TOKEN
                       header('Content-Type: application/json');
                        $result["result"] = array( "status" => 'Error interno, No hemos podido guardar' );
                        echo json_encode($result);
                        http_response_code(200);
                    }

                }else{
                    #|->CONTRASEÑA INCORRECTA
                   header('Content-Type: application/json');
                    $result["result"] =  array( "status" => 'El password es invalido' );
                    echo json_encode($result);
                    http_response_code(200);
                }
            }else{
                #|->EL USUARIO SE ENCUENTRA INACTIVO
                header('Content-Type: application/json');
                $result["result"] = array( "status" => 'Usuario inactivo!' );
                echo json_encode($result);
                http_response_code(200);
            }
        }else{
            #|->EL USUARIO NO EXISTE
           header('Content-Type: application/json');
            $result["result"] =  array( "status" => "El usuaro $usuario no existe" );
            echo json_encode($result);
            http_response_code(200);
        }
    }

}else{
   header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}


?>