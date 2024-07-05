<?php 

class aFireBase{
    private $data;
    private $url;
    function __construct($data,$url){
        $this->data=$data;
        $this->url=$url;
    }
    #|->RECUPERO LOS TOKENS EXISTENTES
    public function obtenerTokens(){
        $url = 'https://sistemaonline-79c63-default-rtdb.firebaseio.com/SocioClave.json';
        $curl_session = curl_init();
        curl_setopt($curl_session, CURLOPT_URL, $url);
        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl_session);
        curl_close($curl_session);
        $data = json_decode($response, true);
        if (is_array($data)) {
            return $data;
        } else {
            return [];
        } 
    }  
    //esta funcion enviaria el registro de usuario por primera vez, es decir crea el usuario
    public function enviarDataFireBase(){
        $curl_session = curl_init();
        curl_setopt($curl_session, CURLOPT_URL, $this->url);
        curl_setopt($curl_session, CURLOPT_POST, 1);
        curl_setopt($curl_session, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($curl_session, CURLOPT_POSTFIELDS, $this->data);
        $result = curl_exec($curl_session);
        // var_dump($result);
        if(curl_errno($curl_session)){
            $resultado= 'Error'.curl_errno($curl_session);
        }else{
            $resultado="Insercion correcta!";
        }
        return $resultado;
    }
   
}
/*
//token depuracion 0AD51C2D-7CD3-4187-9455-2F42CC6E30F6
#|->JSON ESTANDAR PARA IDENTIFICAR USUARIOS
$json    = '{"userID":"1","rol":"100","token":""}';
#|-> url de la base de datos firebase
$url     = 'https://sistemaonline-79c63-default-rtdb.firebaseio.com/SocioClave.json';
$envio   = new aFireBase($json,$url);
//$dispositivos=$envio->obtenerTokens();
//echo $dispositivos;
$resultado=$envio->enviarDataFireBase();
echo $resultado;
*/













?>