<?php require RUTA_APP . '/vistas/inc/header.php'; ?>
<?php require RUTA_APP . '/vistas/inc/menuLateral.php'; ?>
<div class="content">
    <?php require RUTA_APP . '/vistas/inc/menuSuperior.php'; ?>

    <?php 
        $usuarioID  = $datos['userID']; 
        $empresaID  = $datos['empresaID']; 
    ?>

<div class="card mb-3">
    <div class="card-body">
        <a class="btn btn-outline-primary btn-sm me-1 mb-1"
                href="<?php echo constant('RUTA_URL');?>/lstagentes/">
            <span class="far fa-arrow-alt-circle-left mr-1" data-fa-transform="shrink-3"></span>
            <span class="text">Volver</span>
        </a>
    </div>
</div>

<div class="card mb-3">
    <div class="row">
        <div id="content" class="col col-md-12">
            <form method="post" action="#" enctype="multipart/form-data">
                
                <div class="card text-center">
                    <div class="col-auto">
                        <div class="d-flex justify-content-center align-items-center mb-2" style="height: 5rem;">
                            <img class="img-responsive" src="<?php echo constant('RUTA_URL');?>/public/img/upload/cloud-upload.svg" width="50px">
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title titulo">Subir Archivo EXCEL.</h5>
                        <div id="resp"> </div>
                        <div class="mb-3">
                            <label class="form-label" for="customFileSm">Archivo extención :<b> .XLXS </b></label>
                            <input class="form-control form-control-sm" name="image" id="image" type="file" />
                        </div>                      
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-outline-primary btn-sm me-1 mb-1 upload2" 
                                type="button">                            
                            <span class="fas fa-cloud-upload-alt mr-1" data-fa-transform="shrink-3"></span>
                            <span class="text">Procesar Archivo</span>
                        </button>
                        <a class="btn btn-outline-secondary btn-sm me-1 mb-1" 
                           type="button"
                           download
                           href="<?php echo constant('RUTA_URL');?>/rest-api/tmpExcel/Ejemplo-Lista-Agentes.xlsx">                            
                            <span class="fas fa-cloud-download-alt mr-1" data-fa-transform="shrink-3"></span>
                            <span class="text">Descargar Ejemplo</span>
                        </a>
                        <p class="fs--1">Para un correcto envío de la información, descargue la planilla de ejemplo, no envie más de 100 lineas por carga.</p>
                       
                    </div>
                </div>
            </form>
        </div>
    </div>   
</div>

</div>
<?php require RUTA_APP . '/vistas/inc/footer.php'; ?>

<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables-bs4/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables.net-responsive/dataTables.responsive.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>
<!--ESTOS SON PARA LOS BOTONES DEL DATATABLE-->
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/Buttons-1.6.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/Buttons-1.6.2/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/Buttons-1.6.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/Buttons-1.6.2/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function()
    {
        $(".upload2").on('click', function() {
            $('.upload2').prop('disabled', true);
            var UserId    = <?php echo $usuarioID; ?>; //id login       
            var formData  = new FormData();
            var files = $('#image')[0].files[0];
            formData.append('file',files);
            $.ajax({
                url: "<?php echo constant('RUTA_URL');?>/rest-api/tmpExcel/UploadListaAgentes.php",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function(objeto){ $(".img-responsive").attr("src", "<?php echo constant('RUTA_URL');?>/public/img/upload/ajax-loader.gif"); },
                success: function(response) {
                    if (response ) {
                        console.log(response);
                        ActualizarLista(response,UserId);
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Formato de Archivo Incorrecto!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
            });
            return false;
            
        });
    }); 

    function  ActualizarLista(Archivo,UserId)
    {
        var empresaID  = <?php echo $empresaID; ?>;
        var data = { 
                usuarioID  : UserId,
                Archivo    : Archivo,
                empresaID  : empresaID
            } 
        var ruta="<?php echo constant('RUTA_URL');?>/rest-api/UploadListaAgentes.php";
        fetch(ruta,{ 
            method : 'POST',  
            headers: {'Content-type' : 'application/json'},
            body   : JSON.stringify(data) 
            })
        .then(response => response.json() )
        .then(data => {
            console.log(data);
            if(data[0]["error"]){
                Swal.fire({
                    type             : 'error',
                    icon             : 'error',
                    title            : ''+data[0]["error"]+'',
                    showConfirmButton: false,
                    timer            : 2000
                })
            }else{
                var Ingresados = data[0]['Ingresados']; 
                var Existentes = data[0]['Existentes']; 
                Swal.fire({
                    type             : 'success',
                    icon             : 'success',
                    title            : 'Agentes Nuevos: '+ Ingresados +'<br> Existentes: ' +Existentes,
                    showConfirmButton: false,
                    timer            : 2000
                })
                $(".img-responsive").attr("src", "<?php echo constant('RUTA_URL');?>/public/img/upload/cloud-upload.svg");
            }
            
            setTimeout(function(){                        
                window.location = "<?php echo constant('RUTA_URL');?>/lstagentes";
            },2000); 
        }); 
    }

</script>