<?php 

class aFireBase{
    private $data;
    private $url;

    function __construct($data,$url){
        $this->data=$data;
        $this->url=$url;
    }

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
}

$json    = '{"userID":"1","rol":"100","token":""}';
//url de la base de datos
$url     = 'https://sistemaonline-79c63-default-rtdb.firebaseio.com/SocioClave.json';
$envio   = new aFireBase($json,$url);
$dispositivos=$envio->obtenerTokens();
var_dump( $dispositivos );














?>