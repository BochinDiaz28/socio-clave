<?php 

class aFireBase{
    private $data;
    private $url;

    function __construct($data,$url){
        $this->data=$data;
        $this->url=$url;
    }
    /*
    public function obtenerTokens(){
        $url = 'https://prueba2-32b38-default-rtdb.firebaseio.com/SocioClave.json';
        $curl_session = curl_init();
        curl_setopt($curl_session, CURLOPT_URL, $url);
        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl_session);
        curl_close($curl_session);
        $data = json_decode($response, true);
        if (is_array($data)) {
            $arrayToken = [];
            foreach ($data as $key => $value) {
                if (isset($value["token"])) {
                    $arrayToken[] = $value["token"];
                }
            }
            return $arrayToken;
        } else {
            
            return [];
        }
    }
  
    public function obtenerTokens(){
        $url='https://prueba2-32b38-default-rtdb.firebaseio.com/SocioClave.json';
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
    */
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
        var_dump($result);
        if(curl_errno($curl_session)){
            $resultado= 'Error'.curl_errno($curl_session);
        }else{
            $resultado="Insercion correcta!";
        }
        return $resultado;
    }
    /*
    public function enviarDataPush($message,$title){
        $path_to_fcm = 'https://fcm.googleapis.com/fcm/send';
        $server_key  = "AAAALsBxZMw:APA91bERfshUgSHt4dUoEYFnEr4Ueq83ozBrYk4W3h1YikUOJzjACJHkEKjN2zEptlb63DL9VV4pEkc5-dyQYUC1omqeVlJl_pql2jdlcB0wcQYVeDP603O0yLJHkAEHiWInD_zlTanm";
        #|->ESTE TOKEN DEBE CAMBIAR POR USUARIO AL QUE LE ENVIARMOS LA NOTIFICACION
        $deviceToken = "fqKTRIqrReypcd_8vehhpF:APA91bHvDCXwn-0818NRU62VmZuvzpTLhKnnvnCxi4VNfxOWaY-5t40fK4HclyZ1Mm6nSZgEM-0WOzqGlhZ_WD4gtuYUF7Fz0NMRDi46wvWSrOdOV9SG5BNdVnBaTfGtiDPVd5_2zlud";
        $headers = array(
            'Authorization:key=' .$server_key,
            'Content-Type:application/json'
        );
        $fields = array('to'=>$deviceToken,
                        'notification'=>array('title'=>$title,
                                              'body'=>$message));

        $payload = json_encode($fields);

       // echo $payload;

        $curl_session = curl_init();
        curl_setopt($curl_session, CURLOPT_URL, $path_to_fcm);
        curl_setopt($curl_session, CURLOPT_POST, true);
        curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);
        $result = curl_exec($curl_session);
        return $result;
    }
    */
}
//token depuracion 0AD51C2D-7CD3-4187-9455-2F42CC6E30F6
$message = "Es un admin";
$title   = "Nuevo Registro";
//este es el registro que te explico en word
$json    = '{"userID":"1","rol":"100","token":""}';
//url de la base de datos
$url='https://sistemaonline-79c63-default-rtdb.firebaseio.com/SocioClave.json';
$envio = new aFireBase($json,$url);
//$dispositivos=$envio->obtenerTokens();
//echo $dispositivos;
$resultado=$envio->enviarDataFireBase();
echo $resultado;
/*
$resultadoPush=$envio->enviarDataPush($message,$title);
echo $resultadoPush;
*/












?>