<?php $token =  $_GET['token']; ?>
<!DOCTYPE html>
<html class="no-js" lang="es">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Maximiliano Diaz" content="Sistema Online">
    <!-- Site Title -->
    <title>Final Agente</title>
    <link rel="apple-touch-icon"      sizes="180x180" href="<?php echo constant('RUTA_URL'); ?>/public/assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"   href="<?php echo constant('RUTA_URL'); ?>/public/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"   href="<?php echo constant('RUTA_URL'); ?>/public/assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon"     href="<?php echo constant('RUTA_URL'); ?>/public/assets/img/favicons/favicon.ico">

    <link rel="stylesheet" href="<?php echo constant('RUTA_URL'); ?>/public/assetPresupuesto/css/style.css">
    <script type="text/javascript" src="<?php echo constant('RUTA_URL'); ?>/public/js/main.js"></script>
    <style>
        .myDiv {
            border: 1px outset black;
            background-color: #eaeaea;   
            padding:0.3em; 
        }
    </style>
</head>

<body>
   
    <div class="cs-container">
        <div class="cs-invoice cs-style1">
            <div class="cs-invoice_in" id="download_section">
                <!--CABECERA-->
                <div class="cs-invoice_head cs-type1 cs-mb25">
                    <div class="cs-invoice_left">
                        <div class="cs-logo cs-mb5" id="_Logo"></div>
                    </div>
                    <div>
                        <p> INFORME DE CIRUGIAS</p>
                    </div>
                    <div class="cs-invoice_right">
                        <p class="cs-invoice_number cs-primary_color cs-mb5 cs-f16">
                            <p class="cs-primary_color">Codigo: CH-CX-F-007 </p>
                            <p class="cs-primary_color">REV: 3</p>
                            <b class="cs-primary_color">Aprobado por:  </p>
                        </p>
                    </div>
                </div>

                <div class="cs-invoice_head cs-mb10">
                    <div class="cs-invoice_left">
                        <p class="cs-primary_color">N° de Folio: <span class="cs-light" id="_Folio"></span></p>
                        <p class="cs-primary_color">N° de OV: <span class="cs-light" id="_Ov"></span></p>                
                    </div>

                    <div class="cs-invoice_right">
                        <p class="cs-primary_color">Nombre Asistente Quirúrgico: <span class="cs-light" id="_Agente"></span></p>
                        <p class="cs-primary_color">Firma de Asistente Quirúrgico:........................</p> 
                    </div>
                </div>
                <div >
                    <p class="myDiv">Sección 1: Información de la cirugía</p>
                </div>
                <div class="cs-invoice_head cs-mb10">
                    <div class="cs-invoice_left">
                        <p class="cs-primary_color">Hospital/Clínica:<span class="cs-light" id="_Hospital"></span></p>
                        <p>Nombre del Médico: <span class="cs-light" id="_Medico"></span></p>
                        <p>Nombre y Apellido del Paciente: <span class="cs-light" id="_Paciente"></span></p>
                        <p>N°Documento Interno del Cliente: <span class="cs-light" id="_DocCliente"></span></p> 
                    </div>
                    <div class="cs-invoice_right">
                        <p class="cs-primary_color">Fecha Cirugía: <span class="cs-light" id="_fechaCirugia"></span></p>
                        <p class="cs-primary_color">Hora de Cirugía: <span class="cs-light"  id="_horaInicio"></span></p> 
                        <p class="cs-primary_color">Tipo de Cirugía: <span class="cs-light" id="_TipoCirugia"></span></p> 
                        <p class="cs-primary_color">Rut del Paciente:<span class="cs-light"  id="_RutP"></span></p> 
                    </div>
                </div>

                <div >
                    <p class="myDiv">Sección 2: Resultados de la cirugía</p>
                </div>
                <div class="cs-invoice_head cs-mb10">
                    <div class="cs-invoice_left">
                        <p class="cs-light">Consignacion <span id="_consignaSi"></span></p>
                    </div>
                    <div>
                        <p class="cs-light">transito <span id="_transitoSi"></span></p>
                    </div>
                    <div class="cs-invoice_right">
                        <p class="cs-light">mixta <span id="_mixtaSi"></span></p>
                    </div>                   
                </div>
                <div class="cs-invoice_head cs-mb10">
                    <div class="cs-invoice_left">
                        <p class="cs-light">Realizada <span id="_exitoSi"></span></p>
                    </div>
                    <div>
                        <p class="cs-light">Sin Consumo <span id="_consumoSi"></span></p>
                    </div>
                    <div class="cs-invoice_right">
                        <p class="cs-light">Suspendida <span id="_exitoNo"></span></p>
                    </div>                   
                </div>
                <div class="cs-invoice_head cs-mb10">
                    <div class="invoice_full">
                        <p class="cs-light">Observacion: </p>
                    </div>
                </div>

                <div >
                    <p class="myDiv">Sección 3: Registro de Implantes/Insumos utilizados</p>
                </div>
                <div class="cs-table cs-style1">
                    <div class="cs-round_border">
                        <div class="cs-table_responsive">
                            <!--CHECK LIST DE PRIDUCTOS SI EXISTE-->                        
                            <table id="_verCheck">
                                <thead>
                                    <tr>                                
                                        <th class="cs-width_2 cs-semi_bold cs-primary_color cs-focus_bg">Cantidad</th>    
                                        <th class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Codigo</th>
                                        <th class="cs-width_4 cs-semi_bold cs-primary_color cs-focus_bg">Producto</th>
                                        <th class="cs-width_2 cs-semi_bold cs-primary_color cs-focus_bg">Lote</th>                                        
                                    </tr>
                                </thead>
                                <tbody id="_lstItems2">
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                
                <div class="cs-invoice_head myDiv">
                    <div class="cs-invoice_left">
                        <p class="cs-primary_color">Sección 4: Reporte de:</p>
                    </div>
                    <div class="cs-invoice_left">
                        <p class="cs-light">Reclamo de producto: <span id="_reclamoSi"></span></p>
                    </div>
                    <div class="cs-invoice_right cs-text_right">
                        <p class="cs-light">Implante/Insumo abierto: <span id="_abiertoSi"></span></p>
                    </div>
                </div>
          
                <!--NOTA FINAL PRE ARMADA-->
                <div class="cs-invoice_head cs-mb10">
                    <div class="invoice_full">
                        <p class="cs-light">Nota: Todos los productos deberán retornar a Stryker identificados con el adhesivo correspondiente dentro de un contenedor, a menos que el protocolo del cliente indique lo contrario</p>                        
                    </div>
                </div>

                <div class="cs-invoice_btns cs-hide_print">
                    <a href="javascript:window.print()" class="cs-invoice_btn cs-color1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><circle cx="392" cy="184" r="24"/></svg>
                        <span>Imprimir</span>
                    </a>
                </div>       
            </div>
        </div>
    </div>
    <script src="<?php echo constant('RUTA_URL'); ?>/public/assetPresupuesto/js/jquery.min.js"></script>
    <script src="<?php echo constant('RUTA_URL'); ?>/public/assetPresupuesto/js/jspdf.min.js"></script>
    <script src="<?php echo constant('RUTA_URL'); ?>/public/assetPresupuesto/js/html2canvas.min.js"></script>
    <script src="<?php echo constant('RUTA_URL'); ?>/public/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/he/1.2.0/he.min.js"></script>

</body>
</html>

<script>
    $(document).ready(function ()
    {
        LlamadoPublico();
        
    });
    function LlamadoPublico() {   
        var html  = ''; //ESTE ES PARA PRODUCTOS
        var token = <?=$token; ?>;
        var id = 0;
        var clienteID = 0;
        var foto = '<img src="<?=constant('RUTA_URL'); ?>/public/img/logosEmpresas/logo.png" alt="Logo">';
        var url = '<?php echo constant('RUTA_URL');?>/rest-api/InformesPesonalizados?consultaGET=' + token;
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                $.each(data, function(i, item) {
                    $("#_Hospital").html(item.ubicacion);
                    $("#_Agente").html(item.Agente);
                    foto = '<img src="<?=constant('RUTA_URL'); ?>/public/img/perfil/'+item.foto_pefil+'" alt="Logo" width="200px">';
                    $('#_Logo').html(foto);
                    // UTILIZAMOS EL ÉXITO SI NO DEL AGENTE PARA SABER SI SE REALIZÓ O NO LA CIRUGÍA
                    if (item.cerradaAgente == 1) {
                        $("#_exitoSi").html('[X]'); 
                        $("#_exitoNo").html('[  ]');
                    } else {
                        $("#_exitoSi").html('[  ]'); 
                        $("#_exitoNo").html('[X]');
                    }

                    // DATOS DE ALTA DE TAREA
                    $("#_fechaCirugia").html(item.fecha_sol);
                    $("#_horaInicio").html(item.hora_inicio);  
                    clienteID = item.idcliente;

                });

                // LLama a ListaExtras solo después de haber obtenido el clienteID
                ListaExtras(token, clienteID);
            });  

        // Llamada a ListaTemporal
        ListaTemporal(token);
    }

    function ListaTemporal(tareaID) {
        var url = '<?php echo constant('RUTA_URL');?>/rest-api/PanolControl.php?panolControlGET='+ tareaID;
        var html = '';
        fetch(url)
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                $.each(data, function(i, item) {                        
                    html+='<tr>'+
                                '<td class="cs-width_2">'+item.cantidad+'</td>'+             
                                '<td class="cs-width_3">'+item.codigo+'</td>'+
                                '<td class="cs-width_4">'+item.producto+'<br><smll>'+item.dato1+'</small></td>'+
                                '<td class="cs-width_2">'+item.dato2+'</td>'+                   
                          '</tr>';
                }); 
                $('#_lstItems2').html(html);
                $('#_consumoSi').html('[  ]');
            } else {
                //REPORTA SI HUBO CONSUMO O NO
                $('#_consumoSi').html('[X]');
            }
        });
    }


    function ListaExtras(tareaID,clienteID) {
       
        var url = '<?php echo constant('RUTA_URL');?>/rest-api/InformesPesonalizados.php?extrasGET='+ clienteID +'&tareaGET='+tareaID;
        var html = '';
        fetch(url)
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                $.each(data, function(i, item) {                        
                  //console.log(data)
                  if(item.id==13){
                    $('#_Folio').html(item.dato_valor);
                  }
                  if(item.id==14){
                    $('#_Ov').html(item.dato_valor);
                  }
                  if(item.id==15){
                    $('#_Medico').html(item.dato_valor);
                  }
                  if(item.id==16){
                    $('#_Paciente').html(item.dato_valor);
                  }
                  if(item.id==19){
                    $('#_TipoCirugia').html(item.dato_valor);
                  }
                  if(item.id==20){
                    $('#_DocCliente').html(item.dato_valor);
                  }
                  if(item.id==21){
                    $('#_RutP').html(item.dato_valor);
                  }
                  if(item.id==22){
                    if(item.dato_valor==1){
                        $("#_consignaSi").html('[X]'); 
                        //$("#_consignaSi").html('[  ]');
                    }else{
                        $("#_consignaSi").html('[  ]'); 
                        //$("#_consignaSi").html('[X]');
                    }                   
                  }
                  if(item.id==23){
                    if(item.dato_valor==1){
                        $("#_transitoSi").html('[X]'); 
                        //$("#_transitoSi").html('[  ]');
                    }else{
                        $("#_transitoSi").html('[  ]'); 
                        //$("#_transitoSi").html('[X]');
                    }                       
                  }
                  if(item.id==24){                   
                    if(item.dato_valor==1){
                        $("#_mixtaSi").html('[X]'); 
                        //$("#_mixtaSi").html('[  ]');
                    }else{
                        $("#_mixtaSi").html('[  ]'); 
                        //$("#_mixtaSi").html('[X]');
                    }      
                  }
                  if(item.id==25){                   
                    if(item.dato_valor==1){
                        $("#_reclamoSi").html('[X]'); 
                        //$("#_reclamoSi").html('[  ]');
                    }else{
                        $("#_reclamoSi").html('[  ]'); 
                        //$("#_reclamoSi").html('[X]');
                    }      
                  }
                  if(item.id==26){                   
                    if(item.dato_valor==1){
                        $("#_abiertoSi").html('[X]'); 
                        //$("#_abiertoSi").html('[  ]');
                    }else{
                        $("#_abiertoSi").html('[  ]'); 
                        //$("#_abiertoSi").html('[X]');
                    }      
                  }
                  
                

                }); 
           
              


                //$('#_consumoSi').html('[  ]');
            } else {
                console.log("error de busqueda...");
                //REPORTA SI HUBO CONSUMO O NO
                //$('#_consumoSi').html('[X]');
            }
        });
    }

</script>