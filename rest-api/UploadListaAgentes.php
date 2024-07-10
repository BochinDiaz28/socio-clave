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
                    $rut        = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
                    $nombre     = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
                    $correo     = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue();
                    $nombre     = str_replace("'", " ", $nombre);
                    $direccion  = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue();
                    $celular    = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getValue();
                    $sucursales = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getValue();
                    #|-> PASAMOS CORREO A MINUSCULAS
                    $correo  = strtolower($correo);
                    $query   = "SELECT COUNT(*)AS Total FROM clientes WHERE idempresa='$empresaID' AND cuit LIKE'$rut'";
                    $resp00  = metodoGET($query);
                    $valores = json_encode($resp00);
                    $valores = json_decode($valores, true);
                    $total   = $valores[0]['Total']; 
                    if($total==0){
                        #|-> CREAMOS EL USUARIO
                        $queryU      = "INSERT INTO usuarios (username,idempresa,password,nombre,email,rol,activo) 
                                              VALUES ('$correo','$empresaID','$rut','$nombre','$correo','200','1')"; 
                        $respU       = metodoPOST($queryU);        
                        $userID     = $respU[0]['retornoID'];
                        #|-> CREAR PERFIL DEL AGENTE     
                        $query2     = "INSERT INTO agentes (`idempresa`, `idusuario`, `nombre`, `direccion`, `celular`, `email`, `cuit`,  `activo`, `fecha_alta`, `fecha_mod`) 
                                              VALUES ('$empresaID','$userID','$nombre','$direccion','$celular','$correo','$rut','1','$fecha','$fecha')"; 
                        $resp2      = metodoPOST($query2);
                        $agenteID   = $resp2[0]['retornoID'];
                        $Ingresados = $Ingresados+1;
                        #|->COMPRUEBO SUCURSALES Y LAS INGRESO.                      
                        $sucursalArray = explode(',', $sucursales);
                        foreach ($sucursalArray as $sucursal) {
                            $queryS = "SELECT * FROM retail 
                                       WHERE cod_local LIKE '$sucursal'";
                            $respS  = metodoGET($queryS);                            
                            $cantRes= COUNT($respS);
                            if($cantRes>0){
                                $sucursalID = $respS[0]['id'];
                                #|-> ASOCIO LA SUCURSAL AL AGENTE
                                $queryA     = "INSERT INTO agentes_retails (`idempresa`, `idagente`, `idretail`) 
                                                      VALUES ('$empresaID','$agenteID','$sucursalID')"; 
                                $respA      = metodoPOST($queryA);
                            }
                        }
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