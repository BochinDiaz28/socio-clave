<?php 

class aFireBase{
    private $data;
    private $url;

    function __construct($data,$url){
        $this->data=$data;
        $this->url =$url;
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
    public function enviarDataPush($message,$title,$deviceToken){
        $path_to_fcm = 'https://fcm.googleapis.com/fcm/send';
        $server_key  = "AAAA5EVszNI:APA91bHlVTas0jh4aB0iBiszwLuWgFwxiJZzAHhU6e-kLlD_JwLlWMdf8dzEb1mji1kWYGUCh9g2E1vvqGydsDf5ySxNeHb2esoA_cd_KXPtsSXyTcgtaupkyEXfLd3ivizwETmzITDZ";
        #|->ESTE TOKEN DEBE CAMBIAR POR USUARIO AL QUE LE ENVIARMOS LA NOTIFICACION       
        //$deviceToken = "cqAGKJYlfG9IsVlIFlwnAg:APA91bH9TNktbf47busf-mqKadNmqdXZwpiwV0LIAtpacfhOu-UGYeWdlnByERQPiHMHGTk53vxgYr7Fp-lIejwDHonn-K94wopp8XJ8gMjyHYiOey2kzALLiykVEr4-GOByXNXdn-JA";        
        $headers = array(
            'Authorization:key=' .$server_key,
            'Content-Type:application/json'
        );
        $fields = array('to'=>$deviceToken,
                        'notification'=>array('title'=>$title,
                                              'body'=>$message));

        $payload = json_encode($fields);

        //echo $payload;

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
}









?>