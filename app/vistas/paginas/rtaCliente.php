<?php require RUTA_APP . '/vistas/inc/header.php'; ?>
<?php
$cotID = $datos['cotID'];
?>
<div class="content">
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Su Respuesta</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <img img-fluid src="<?php echo constant('RUTA_URL'); ?>/public/img/logosEmpresas/logo.png" alt="Logo">
                </div> 
            </div>
            <div class="row">
                <label class="col-sm-3 col-form-label" for="rtaCliente">Esperamos su respuesta: </label>
                <div class="col-sm-3">
                    <select class="form-select form-select-sm" id="rtaCliente">
                        <option value="1">Aprobar</option>
                        <option value="2">Observar</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="nota2">Comentarios</label>
                <div class="col-sm-8">
                    <textarea class="form-control" rows="4" cols="50" id="nota2" data-id="nota2"></textarea>
                </div>
            </div>
            <hr>
            <div class="form-group text-center">
                <button class="btn btn-outline-primary btn-sm me-1 mb-1" type="button" onclick="Controlar_Requeridos();">
                    <span class="fas fa-check" data-fa-transform="shrink-3"></span> Enviar
                </button>
            </div>
        </div>
    </div>
</div>
<?php require RUTA_APP . '/vistas/inc/footer2.php'; ?>

<script>
   
    function Controlar_Requeridos() 
    {
        var rtaCliente = $('#rtaCliente').val();
        var nota2      = $('#nota2').val();
        if(rtaCliente == 4 && nota2===''){  //SI NO VALIDA CORRECTAMENTE TIRA CARTEL
            swal({
                type : 'error',
                title: 'Error!',
                text : 'Indique su obervación en comentarios!'
            })
        } else { // CUANDO LOS CAMPOS SON CORRECTOS, EJECUTO AJAX
            Actualizar_Cliente();
        }    
    }
 
    function Actualizar_Cliente()
    {
        var clienteID = <?php echo $cotID; ?>;
        var Accion    = 'Enviar';  
        var rtaAccion = 'Enviada!'; 
        var metodo    = 'PUT'; 
        var rtaCliente = $('#rtaCliente').val();
        var nota2      = $('#nota2').val();
        Swal.fire({
            title: '<strong>Confirma '+Accion+'?</strong>',
            icon : 'info',
            html : '<b>Respuesta</b> <br/> ',
            showCancelButton : true,
            focusConfirm     : false,
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> '+ Accion +'!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
            if (result.value) {
                var apiUrl='<?php echo constant('RUTA_URL'); ?>/rest-api/TareaRtaCliente.php'; 
                var data = { 
                    cotID      : clienteID,
                    rtaCliente : rtaCliente,
                    nota2      : nota2
                } 
                fetch(apiUrl,{ 
                    method : metodo,  
                    headers: {'Content-type' : 'application/json'},
                    body   : JSON.stringify(data) 
                })
                .then(response => response.json() )
                .then(data => {
                    console.log(data);
                    if(data[0]["error"]){
                        Swal.fire({
                            type : 'error',
                            icon : 'error',
                            title: ''+data[0]["error"]+'',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }else{
                        var retornoID = data[0]['retornoID']; 
                        Swal.fire({
                            type : 'success',
                            icon : 'success',
                            title: 'Respuesta '+ rtaAccion +'',
                            showConfirmButton: false,
                            timer: 2000
                        })
                        setInterval(redireccion, 2000); 
                    }
                }) 

            }   
        })
    }

    function redireccion(){
        window.location = "<?php echo constant('RUTA_URL');?>/rtafin";
    }
    
</script>