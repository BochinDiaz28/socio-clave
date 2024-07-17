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
    <title>Final Cliente</title>
    <link rel="apple-touch-icon"      sizes="180x180" href="<?php echo constant('RUTA_URL'); ?>/public/assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"   href="<?php echo constant('RUTA_URL'); ?>/public/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"   href="<?php echo constant('RUTA_URL'); ?>/public/assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon"     href="<?php echo constant('RUTA_URL'); ?>/public/assets/img/favicons/favicon.ico">

    <link rel="stylesheet" href="<?php echo constant('RUTA_URL'); ?>/public/assetPresupuesto/css/style.css">
    <script type="text/javascript" src="<?php echo constant('RUTA_URL'); ?>/public/js/main.js"></script>
</head>

<body>
   
    <div class="cs-container">
        <div class="cs-invoice cs-style1">
            <div class="cs-invoice_in" id="download_section">
                <div class="cs-invoice_head cs-type1 cs-mb25">
                    <div class="cs-invoice_left">
                        <p class="cs-invoice_number cs-primary_color cs-mb5 cs-f16">
                            <b class="cs-primary_color">Tarea N°:</b> <span id="_presupuestoNumero"></span> </p>
                            <p class="cs-invoice_date cs-primary_color cs-m0">
                            <b class="cs-primary_color">Creada: </b> <span id="_presupuestoFecha"></span>
                        </p>
                    </div>
                    <div class="cs-invoice_right cs-text_right">
                        <div class="cs-logo cs-mb5"><img src="<?php echo constant('RUTA_URL'); ?>/public/img/logosEmpresas/logo.png" alt="Logo"></div>
                    </div>
                </div>
                <div class="cs-invoice_head cs-mb10">
                    <div class="cs-invoice_left">
                        <b class="cs-primary_color">Emitido Para:</b>
                        <p>
                            <span id="_Cliente"></span> <br>
                            <span id="_Rut"></span>
                        </p>
                    </div>
                    <div class="cs-invoice_right cs-text_right">
                        <b class="cs-primary_color">Emitido por:</b>
                        <p>
                            <span>TaskNow</span> <br>
                            <span>calle #123, comuna, Region</span> <br>
                            <span>contacto@socioclave.cl</span>
                        </p>
                    </div>
                </div>
                <div class="cs-invoice_head cs-mb10">
                    <div class="invoice_full">
                        <b class="cs-primary_color">Tarea:</b><br>
                        <p><span id="_MuestraNombre"></span></p>
                        <p><span id="_Ubicacion"></span></p>
                        <p id="_MuestraDetalle"></p> <br>
                    </div>
                </div>

                <div class="cs-table cs-style1">
                    <div class="cs-round_border">
                        <div class="cs-table_responsive">
                            <!--TABLA DE PERMANENCIA-->
                            <table>
                                <thead>
                                    <tr>
                                        <th class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Agente</th>
                                        <th class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Ingreso</th>
                                        <th class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Salida</th>
                                        <th class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Permanencia</th>                                        
                                    </tr>
                                </thead>
                                <tbody id="_lstItems">
                                
                                </tbody>
                            </table>
                            <!--CHECK LIST DE PRIDUCTOS SI EXISTE-->
                            <br><br>
                            <table id="_verCheck">
                                <thead>
                                    <tr>                                
                                        <th class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Codigo</th>
                                        <th class="cs-width_6 cs-semi_bold cs-primary_color cs-focus_bg">Producto</th>
                                        <th class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Cantidad</th>                                        
                                    </tr>
                                </thead>
                                <tbody id="_lstItems2">
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="cs-invoice_head cs-mb10">
                    <div class="invoice_full">
                        <b class="cs-primary_color">Informe de Ingreso:</b><span id="_ingreso"></span><br>
                        <div id="_MuestraFotos"></div>
                    </div>
                </div>

                <div class="cs-invoice_head cs-mb10">
                    <div class="invoice_full">
                        <b class="cs-primary_color">Informe de Salida:</b><span id="_salida"></span><br>
                        <div id="_MuestraFotos2"></div> <br>
                    </div>
                </div>

                <div id="_MuestraTerminos"></div>

                <div class="cs-invoice_btns cs-hide_print">
                    <a href="javascript:window.print()" class="cs-invoice_btn cs-color1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><circle cx="392" cy="184" r="24"/></svg>
                        <span>Imprimir</span>
                    </a>
                    <button id="download_btn" class="cs-invoice_btn cs-color2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><title>Download</title><path d="M336 176h40a40 40 0 0140 40v208a40 40 0 01-40 40H136a40 40 0 01-40-40V216a40 40 0 0140-40h40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M176 272l80 80 80-80M256 48v288"/></svg>
                        <span>Descargar</span>
                    </button>
                   
                    <button id="" 
                            class="cs-invoice_btn cs-color2" 
                            style="background-color: #2d3494;border-color: #2d3494;"
                            onclick="EnviarRta();">                        
                        <span>Enviar Respuesta</span>
                    </button>
               
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
    function LlamadoPublico()
    {   
        var html      = ''; //ESTE ES PARA PRODUCTOS
        var token = <?php echo  $token; ?>;
        var id=0;
        var url ='<?php echo constant('RUTA_URL');?>/rest-api/Tareas?tareInformeFinalGET='+token;
        fetch(url)
        .then(response => response.json())
        .then(data => {
            $.each(data, function(i, item) {
                $('#_presupuestoNumero').html(item.id);
                $('#_presupuestoFecha').html(InvertirFechaCorta(item.fecha_sol));
                $('#_MuestraNombre').html(item.tarea);
                $('#_Ubicacion').html(item.ubicacion);
                var textoDecodificado = he.decode(item.nota);
                document.getElementById('_MuestraDetalle').innerHTML = textoDecodificado;
                //TABLA DE PERMANENCIA
                let checkin  = item.checkin;
                let checkout = item.checkout;
                let tiempoEnElLugar = calculateTimeDifference(checkin, checkout);
                html+='<tr>'+
                            '<td class="cs-width_3">'+item.Agente+'</td>'+
                            '<td class="cs-width_3">'+InvertirFecha(item.checkin)+'</td>'+
                            '<td class="cs-width_3">'+InvertirFecha(item.checkout)+'</td>'+
                            '<td class="cs-width_3 cs-text_right">'+tiempoEnElLugar+'</td>'+                            
                        '</tr>';
                $('#_Cliente').html(item.Cliente);
                $('#_Rut').html(item.cuit);
                //CONTROLAREMOS EL CHECK LIST SI EXISTE
                var x = document.getElementById("_verCheck");
                if(item.checklist==1){
                    x.style.display = "block";
                    //llamadoPublicioItems(item.id);
                }else{
                    x.style.display = "none";
                }
                llamadoFotos(item.id);
            });    
            $('#_lstItems').html(html);
            
        });  
    }

    function EnviarRta() {
        //window.location = "<?php echo constant('RUTA_URL');?>/rtacotizacion/"+<?=$token?>;
        alert("No configurado");
    }
    function llamadoFotos() {
        var token = <?=$token?>;
        var url ='<?php echo constant('RUTA_URL');?>/rest-api/Tareas.php?tareaFotoGET='+token;
        fetch(url)
        .then(response => response.json())
        .then(data => {
            $.each(data, function(i, item) {
                if(item.estado==3){
                    $('#_ingreso').html(" "+item.comentario);
                    var foto = '<div class="cs-logo cs-mb5"><img src="<?=constant('RUTA_URL'); ?>/public/img/logosEmpresas/logo.png" alt="Logo"></div>';
                    $('#_MuestraFotos').html(foto);
                }
               
                if(item.estado==4){
                    $('#_salida').html(" "+ item.comentario);
                    var foto2 = '<div class="cs-logo cs-mb5"><img src="<?=constant('RUTA_URL'); ?>/public/img/logosEmpresas/logo.png" alt="Logo"></div>';
                    $('#_MuestraFotos2').html(foto2);
                }              
            }); 
            $('#_lstItems').html(html);   
        });  
    }
    

</script>