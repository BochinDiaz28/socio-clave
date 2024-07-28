<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/bd.php';
$_respuestas = new respuestas;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if($_SERVER['REQUEST_METHOD'] == "GET"){   
    
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    $postBody = file_get_contents("php://input");
    $datos    = json_decode($postBody,true);
    if(!isset($datos['clienteID']) || !isset($datos['Archivo']) ) {
        $resp []= array("error" => "Datos enviados de forma incompleta!");
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }else{
        $usuarioID = $datos['usuarioID'];
        $empresaID = $datos['empresaID'];
        $archivo   = $datos['Archivo']; //DEBE ENVIAR EL PATH COMPLETO  
        $clienteID = $datos['clienteID'];
        #|-> FORMATEAMOS FECHA
        date_default_timezone_set('America/Santiago');
        $fecha = date("Y-m-d H:i:s");
        $bandera   = 0;
        if (file_exists ($archivo)){ 
            /** Llamamos las clases necesarias PHPExcel **/
            require_once('clases/importar/Classes/PHPExcel.php');
            require_once('clases/importar/Classes/PHPExcel/Reader/Excel2007.php');					
            #|-> Cargando la hoja de excel
            $objReader   = new PHPExcel_Reader_Excel2007();
            $objPHPExcel = $objReader->load($archivo);
            $objFecha    = new PHPExcel_Shared_Date();       
            #|-> Asignas la hoja de excel activa
            $objPHPExcel->setActiveSheetIndex(0);
            $columnas   = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
            $filas      = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
           
            #|-> INICIALIZO ACUMULADORES PARA RESPUESTAS
            $Ingresados = 0;
            $Existentes = 0;
            for ($i=2;$i<=$filas;$i++){
                $codigo   = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
                $nombre   = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
                $cantidad = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue();
                $nombre   = str_replace("'", " ", $nombre);

                $query   = "SELECT COUNT(*)AS Total FROM panol WHERE idcliente='$clienteID' AND codigo LIKE'$codigo'";
                $resp00  = metodoGET($query);
                $valores = json_encode($resp00);
                $valores = json_decode($valores, true);
                $total   = $valores[0]['Total']; 
                if($total==0){
                    #|-> CREAMOS EL INVENTARIO
                    if($cantidad==''){
                        $cantidad=0;
                    }
                    $queryU = "INSERT INTO panol (`idcliente`, `codigo`, `producto`, `tipo_producto`, `cantidad`, `combo`) 
                                        VALUES ('$clienteID','$codigo','$nombre','Manual','$cantidad','0')"; 
                    $respU  = metodoPOST($queryU);        
                    $userID = $respU[0]['retornoID'];
            
                    $Ingresados = $Ingresados+1;
                    
                }else{
                    $Existentes=$Existentes+1;
                }
            }
          
            #|-> PREPARAMOS LA RESPUESTA       
            $resp []=array("Ingresados"=>$Ingresados,
                           "Existentes"=>$Existentes);
          
            #|-> ELIMINAMOS EL ARCHIVO SUBIDO
            unlink($archivo);
       
            #|-> ENVIAMOS LA RESPUESTA    
            header("Content-Type: application/json");
            echo json_encode($resp);
            http_response_code(200);                   
        }else{
            $resp []= array("error" => "Primero debes cargar el archivo con extencion .xlsx");
            header("Content-Type: application/json");
            echo json_encode($resp);
            http_response_code(200);
        }  
    }        
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    //ESTE ABM NO SE ESTA TRABAJANDO
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    //ESTE ABM NO SE ESTA TRABAJANDO
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}




?>