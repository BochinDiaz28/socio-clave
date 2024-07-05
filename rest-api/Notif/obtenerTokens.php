<?php 

class aFireBase{
    private $data;
    private $url;

    function __construct($data,$url){
        $this->data=$data;
        $this->url=$url;
    }
    public function obtenerTokens(){
        $url='https://prueba2-32b38-default-rtdb.firebaseio.com/Users.json';
        $curl_session = curl_init();
        curl_setopt($curl_session, CURLOPT_URL, $this->url);
        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
        curl_close($curl_session);
        $response = curl_exec($curl_session);
        $data=json_decode($response,true);
        //var_dump($data);
        $arrayToken=[];
        foreach($data as $key->$value){
            $arrayToken[]=$token[$key]["token"];
        }
        return $arrayToken;
    }

}


//este es el registro que te explico en word
$json='{"loginnombre":"","loginpass":"","token":"","rol":"100","Activo":"false","IdTarea":""}';
//url de la base de datos
$url='https://prueba2-32b38-default-rtdb.firebaseio.com/Users.json';
$envio = new aFireBase($json,$url);
$dispositivos=$envio->obtenerTokens();
echo $dispositivos;
//$resultado=$envio->enviarDataFireBase();
//echo $resultado;
//$resultadoPush=$envio->enviarDataPush($message,$title);
//echo $resultadoPush;










?>