<?php
$pdo=null;
$time_zone="";
//ESTOS LOS UTILIZO CON GLOBALS SIN LLAMAR A UN ARCHIVO CON DATOS DE CONN


function conectar(){
    $listadatos = datosConexion();
    foreach ($listadatos as $key => $value) {
        $host = $value['server'];
        $user_db = $value['user'];
        $password_db = $value['password'];
        $bd = $value['database'];
        $port = $value['port'];
        $charset= $value['charset'];
        $GLOBALS['time_zone']= $value['time_zone'];
    }
    try {
        $GLOBALS['pdo']= new PDO("mysql:host=".$host.";dbname=".$bd.";charset=" .$charset."",$user_db,$password_db);
        $GLOBALS['pdo']->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        print "Error| no se puedo conectar a la base de datos";
        print "\n Error | ".$e."</br>";
    }
}

function deconectar(){
    $GLOBALS['pdo']=null;
}

function datosConexion(){
    $direccion = dirname(__FILE__);
    $jsondata = file_get_contents($direccion . "/" . "config");
    return json_decode($jsondata, true);
}

function metodoGET($query){
    try {
        conectar();
        $sentencia=$GLOBALS['pdo']->prepare($query);
        $sentencia->execute();
        $fila = $sentencia->fetchAll(PDO::FETCH_ASSOC); 
        deconectar();
        $resp = $fila; 
        return $resp; //RESPONDE COMO ARRAY CON LOS CAMPOS SELECCIONADOS EN QUERY
    } catch (PDOException $e) {
        die("Error ".$e);
    }
}

function metodoPOST($query){
    try {
        conectar();
        date_default_timezone_set($GLOBALS['time_zone']);
        $sentencia=$GLOBALS['pdo']->prepare($query);
        $sentencia->execute();
        $id = $GLOBALS['pdo']->lastInsertId();
        $sentencia->closeCursor();
        deconectar();
        $resp []= array("retornoID" => $id);
        return $resp; //RETORNA ARRAY
    } catch (PDOException $e) {
        die("Error ".$e);
    }
}

function metodoPUT($query){
    try {
        conectar();
        date_default_timezone_set($GLOBALS['time_zone']);
        $sentencia=$GLOBALS['pdo']->prepare($query);
        $sentencia->execute();
        //$resultado=array_merge($_GET,$_POST); //JUNTAMOS LOS DOS ARRAY EL DE CONSULTA Y EL QUE RECIBIMOS
        $sentencia->closeCursor();
        deconectar();
        $resp []= array("Actualizado" => "Si");
        return $resp; //RETORNA ARRAY
    } catch (PDOException $e) {
        die("Error ".$e);
    }
}

function metodoDELETE($query){
    try {
        conectar();
        $sentencia=$GLOBALS['pdo']->prepare($query);
        $sentencia->execute();
        $sentencia->closeCursor();
        deconectar();
        $resp []= array("Estado" => 'Registro Eliminado'); 
        return $resp; //GENERAR UNA RESPUESTA APROPIADA.
    } catch (PDOException $e) {
        die("Error ".$e);
    }
}

function insertarToken($usuarioid){
    date_default_timezone_set($GLOBALS['time_zone']);
    $val    = true;
    $token  = bin2hex(openssl_random_pseudo_bytes(16,$val));
    $date   = date("Y-m-d H:i");
    $estado = "Activo";
    //DESACTIVO TODOS LOS TOKENS DEL USUARIO
    $queryT = "UPDATE usuarios_token 
               SET Estado='Inactivo' 
               WHERE UsuarioId=$usuarioid"; 
    $respT = metodoPUT($queryT);
    //CREO LA NUEVA SESSION CON EL TOKEN ACTIVO
    $query  = "INSERT INTO usuarios_token (UsuarioId,Token,Estado,Fecha)
                      VALUES('$usuarioid','$token','$estado','$date')";
    $resp   = metodoPOST($query);
    //RETORNO EL TOKEN
    if($resp){
        return $token;
    }else{
        return 0;
    }
}

function encriptar($string){
    $opciones = array('cost' => 12);
    $hash_password = password_hash($string, PASSWORD_BCRYPT, $opciones);
    return $hash_password;
}