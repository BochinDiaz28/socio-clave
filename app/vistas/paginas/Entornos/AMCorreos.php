<?php require RUTA_APP . '/vistas/inc/header.php'; ?>
<?php require RUTA_APP . '/vistas/inc/menuLateral.php'; ?>
<?php 
    $empresaID = $datos['empresaID']; #|->EMPRESA LOGEADA
    $userID    = $datos['userID'];    #|->USUARIOS LOGEADO
    $clienteID = 1                    #|->CORREO UNICO PARA ENVIO DE MENSAJES DESDE EL PANEL
?>
<div class="content">
    <?php require RUTA_APP . '/vistas/inc/menuSuperior.php'; ?>
    <div class="card mb-3">
        <div class="card-body">
            <a class="btn btn-outline-primary btn-sm mr-1 mb-1" type="button" 
            href="<?php echo constant('RUTA_URL'); ?>/administracion">
                <span class="fas fa-arrow-alt-circle-left me-1" data-fa-transform="shrink-3"></span>
                Inicio
            </a>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Configuración de Correos</h5>
            <small>Este sera el correo encargado de enviar desde el sistema los mensajes necesarios</small>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="host">smtpHost *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="host" placeholder="EJ: sub.web.pe" aria-label="" value="" />                    
                    <small>smtpHost es ortorgado por su sevidor de correos</small>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="usuario">smtpUsuario *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="email" id="usuario" placeholder="EJ: noreply@sudominio.com" aria-label="" value="" />
                    <small>su correo creado para el envio.</small>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="clave">smtpClave *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="clave" placeholder="EJ: su clave de correo" aria-label="" value="" />
                    <small>Clave ingresada y otorgada al crear el correo.</small>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="puerto">Puerto *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="number" id="puerto" placeholder="EJ: 465" aria-label="" value="" oninput="validarFormato(this.value)"/>
                    <small>El puerto estandar es 465, puede variar segun su proveedor.</small>
                </div>
            </div>
            <hr>
            <div class="form-group text-center">
                <?php  if ($clienteID > 0){?> 
                    <button class="btn btn-outline-primary btn-sm me-1 mb-1" type="button" onclick="Controlar_Requeridos();">
                        <span class="fas fa-sd-card" data-fa-transform="shrink-3"></span> Actualizar
                    </button>
                <?php  }else{ $clienteID=0; ?>
                    <button class="btn btn-outline-primary btn-sm me-1 mb-1" type="button" onclick="Controlar_Requeridos();">
                        <span class="fas fa-sd-card" data-fa-transform="shrink-3"></span> Guardar
                    </button>
                <?php  }?> 
            </div>
        </div>
    </div>

</div>
<?php require RUTA_APP . '/vistas/inc/footer.php'; ?>

<script>
    $(document).ready(function ()
    {
        var clienteID  = <?php echo $clienteID; ?>;
        var empresaID = <?php echo $empresaID; ?>;
        if(clienteID>0){
            var url ='<?php echo constant('RUTA_URL'); ?>/rest-api/Correos.php?consultaGET=1';
            fetch(url)
            .then(response => response.json())
            .then(data => {
                $.each(data, function(i, item) {
                    if(clienteID==item.id){                        
                        $('#host').val(item.host); 
                        $('#usuario').val(item.usuario);
                        $('#clave').val(item.clave);
                        $('#puerto').val(item.puerto);
                    } 
                });   
            });
           
        }else{
            $('#host').val(); 
            $('#usuario').val();
            $('#clave').val();
            $('#puerto').val();           
        }    
    });

    function Controlar_Requeridos() 
    {
        var host      = document.querySelector('#host').value;
        var clave     = document.querySelector('#clave').value;
        var puerto    = document.querySelector('#puerto').value;
        var usuario   = document.querySelector('#usuario').value;
        if(host === '' || clave==='' || puerto==='' || usuario===''){  //SI NO VALIDA CORRECTAMENTE TIRA CARTEL
            swal({
                type : 'error',
                title: 'Error!',
                text : 'Todos los datos son requeridos!'
            })
        } else { // CUANDO LOS CAMPOS SON CORRECTOS, EJECUTO AJAX
            Actualizar_Cliente();
        }    
    }
 
    function Actualizar_Cliente()
    {
        var userID    = <?php echo $userID ?>;
        var clienteID = <?php echo $clienteID; ?>;
        var empresaID = <?php echo $empresaID; ?>;
        if(clienteID==0)
        { 
            var Accion    = 'Crear';
            var rtaAccion = 'Creado!'; 
            var metodo    = 'POST'; 
        }else{
            var Accion    = 'Actualizar';  
            var rtaAccion = 'Actualizado!'; 
            var metodo    = 'PUT'; 
        }
       
        var host      = document.querySelector('#host').value;
        var clave     = document.querySelector('#clave').value;
        var puerto    = document.querySelector('#puerto').value;
        var usuario   = document.querySelector('#usuario').value;
        Swal.fire({
            title: '<strong>Confirma '+Accion+'?</strong>',
            icon : 'info',
            html : 'Actualizar información de <b> correo</b> <br/> ',
            showCancelButton : true,
            focusConfirm     : false,
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> '+ Accion +'!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
            if (result.value) {
                var apiUrl='<?php echo constant('RUTA_URL'); ?>/rest-api/Correos.php'; 
                var data = { 
                    usuarioID : userID,
                    correoID  : clienteID,
                    host      : host,
                    clave     : clave,
                    puerto    : puerto,
                    usuario   : usuario
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
                            title: 'Correo '+ rtaAccion +'',
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
        window.location = "<?php echo constant('RUTA_URL');?>/correo";
    }
    
    function validarFormato(valor) {
      // Expresión regular para validar el formato
      var formatoValido = /^\d{8}-[0-9a-zA-Z]$/;

      // Verificar si el valor cumple con el formato
      if (formatoValido.test(valor)) {
        // Si es válido, eliminar el mensaje de error
        document.getElementById('mensajeError').textContent = '';
        document.getElementById('dni').classList.remove('error');
      } else {
        // Si no es válido, mostrar el mensaje de error y aplicar estilo
        document.getElementById('mensajeError').textContent = 'Formato inválido. Debe ser 8 números, guion medio, y un número o letra.';
        document.getElementById('dni').classList.add('error');
      }
    }


</script>