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
    if(!isset($datos['usuarioID']) || !isset($datos['Archivo']) ) {
        $resp []= array("error" => "Datos enviados de forma incompleta!");
        header("Content-Type: application/json");
        echo json_encode($resp);
        http_response_code(200);
    }else{
        $usuarioID = $datos['usuarioID'];
        $empresaID = $datos['empresaID'];
        $archivo   = $datos['Archivo']; //DEBE ENVIAR EL PATH COMPLETO    
        
        $bandera   = 0;
        if (file_exists ($archivo)){ 
            /** Llamamos las clases necesarias PHPExcel **/
            require_once('clases/importar/Classes/PHPExcel.php');
            require_once('clases/importar/Classes/PHPExcel/Reader/Excel2007.php');					
            // Cargando la hoja de excel
            $objReader   = new PHPExcel_Reader_Excel2007();
            $objPHPExcel = $objReader->load($archivo);
            $objFecha    = new PHPExcel_Shared_Date();       
            // Asignamon la hoja de excel activa
            $objPHPExcel->setActiveSheetIndex(0);
            $columnas   = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
            $filas      = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
           
            date_default_timezone_set('America/Santiago');
            $fecha = date("Y-m-d H:i:s");
            //INICIALIZO ACUMULADORES PARA RESPUESTAS
            $Ingresados = 0;
            $Existentes =0;
            for ($i=2;$i<=$filas;$i++){
                    $canal     = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
                    $canal     = str_replace("'", " ", $canal);
                    $codigo    = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
                    $cadena    = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue();
                    $cadena    = str_replace("'", " ", $cadena);
                    $local     = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue();
                    $local     = str_replace("'", " ", $local);
                    $direccion = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getValue();
                    $direccion = str_replace("'", " ", $direccion);
                    $formato   = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getValue();
                    $formato   = str_replace("'", " ", $formato);
                    $query   = "SELECT COUNT(*)AS Total FROM retail WHERE cod_local LIKE'$codigo'";
                    $resp00  = metodoGET($query);
                    $valores = json_encode($resp00);
                    $valores = json_decode($valores, true);
                    $total   = $valores[0]['Total']; 
                    if($total==0){
                        //INSERTO REGISTRO 
                        $query1  = "INSERT INTO retail (`idempresa`,`canal`, `cod_local`, `cadena`, `local`, `direccion`, `formato_local`) 
                                        VALUES ('$empresaID', '$canal','$codigo','$cadena','$local','$direccion','$formato')"; 
                        $resp1   = metodoPOST($query1);

                        $Ingresados=$Ingresados+1;
                    }else{
                        $Existentes=$Existentes+1;
                    }
            }
          
            
            //PREPARAMOS LA RESPUESTA       
            $resp []=array("Ingresados"=>$Ingresados,
                           "Existentes"=>$Existentes);
          
            //ELIMINAMOS EL ARCHIVO SUBIDO
            unlink($archivo);
       
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