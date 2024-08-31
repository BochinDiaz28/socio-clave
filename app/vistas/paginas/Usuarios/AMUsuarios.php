<?php require RUTA_APP . '/vistas/inc/header.php'; ?>
<?php require RUTA_APP . '/vistas/inc/menuLateral.php'; ?>
<?php 
    $empresaID = $datos['empresaID']; #|->EMPRESA LOGEADA
    $userID    = $datos['userID'];    #|->USUARIOS LOGEADO
    $usuarioID = $datos['usuarioID']; #|->USUARIOS QUE ESTOY CREANDO O EDITANDO
?>
<div class="content">
    <?php require RUTA_APP . '/vistas/inc/menuSuperior.php'; ?>
    <div class="card mb-3">
        <div class="card-body">
            <a class="btn btn-outline-primary btn-sm mr-1 mb-1" type="button" 
            href="<?php echo constant('RUTA_URL'); ?>/lstusuarios">
                <span class="fas fa-arrow-alt-circle-left me-1" data-fa-transform="shrink-3"></span>
                Regresar a Lista
            </a>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Usuario</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="nombre">Nombre *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="nombre" placeholder="Nombre y Apellido " aria-label="" value="" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="email">E-Mail *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="email" placeholder="Correo Electronico" aria-label="" value="" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="rol">ROL *</label>
                <div class="col-sm-9">
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                            id="rol">
                            
                    </select>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <div class="col-sm-9">
                    <div class="form-check form-switch">
                        <input class="form-check-input" id="estado" type="checkbox" checked />
                        <label class="form-check-label" for="estado">Usuario activo?</label>
                    </div>
                </div>
            </div>            
            <hr>
            <div class="form-group text-center">
                <?php  if ($usuarioID > 0){?> 
                    <button class="btn btn-outline-primary btn-sm me-1 mb-1" type="button" onclick="Controlar_Requeridos();">
                        <span class="fas fa-sd-card" data-fa-transform="shrink-3"></span> Actualizar
                    </button>
                <?php  }else{ $usuarioID=0; ?>
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
        var usuarioID = <?php echo $usuarioID; ?>;
        var empresaID = <?php echo $empresaID; ?>;
        if(usuarioID>0){
            var url ='<?php echo constant('RUTA_URL'); ?>/rest-api/Usuarios?usuarioID='+usuarioID+'&consultaGET='+empresaID;
            fetch(url)
            .then(response => response.json())
            .then(data => {
                $('#rol').html("");
                var $select = $('#rol');
                $.each(data, function(i, item) {
                    if(usuarioID==item.id){
                        $('#nombre').val(item.username); 
                        $('#email').val(item.email);
                        if(item.rol==100){
                            $select.append("<option selected selected value='100'>Super Admin</option>");
                            $select.append("<option value='125'>Supervisor</option>");                            
                        }else if(item.rol==125){
                            $select.append("<option value='100'>Super Admin</option>");
                            $select.append("<option selected selected value='125'>Supervisor</option>");
                        }else if(item.rol==150){                           
                            $select.append("<option selected selected value='150'>Cliente</option>");
                        }else if(item.rol==200){                           
                            $select.append("<option selected selected value='200'>Agente</option>");
                        }

                        
                        var checkbox = document.getElementById("estado");
                        if(item.activo==1){
                            checkbox.checked = true; 
                        }else{
                            checkbox.checked = false; 
                        } 

                    } 
                });   
            });
           
        }else{
            //NUEVO CLIENTE LO INICIALIZO ACTIVO
            $('#nombre').val(''); 
            $('#email').val('');
            $('#rol').html("");
            var $select = $('#rol');
            $select.append("<option value='100'>Super Admin</option>");
            $select.append("<option value='125'>Supervisor</option>");
        }    
        
    });
    function Controlar_Requeridos() 
    {
        var nombre = document.querySelector('#nombre').value;
        var email  = document.querySelector('#email').value;
        if(nombre === '' || email === ''){  //SI NO VALIDA CORRECTAMENTE TIRA CARTEL
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
        var clienteID = <?php echo $usuarioID; ?>;
        var empresaID = <?php echo $empresaID; ?>;
        if(document.getElementById("estado").checked==true){ var activo=1; }else{ var activo=0;}
        if(document.getElementById("webview").checked==true){ var webview=1; }else{ var webview=0;}
        
        if(clienteID==0)
        { 
            var Accion    = 'Crear';
            var rtaAccion = 'Creada!'; 
            var metodo    = 'POST'; 
        }else{
            var Accion    = 'Actualizar';  
            var rtaAccion = 'Actualizado!'; 
            var metodo    = 'PUT'; 
        }
       
        var Nombre = $("#nombre").val();
        var Email  = $("#email").val();
        var Rol    = $("#rol").val();
        Swal.fire({
            title: '<strong>Confirma '+Accion+'?</strong>',
            icon : 'info',
            html : 'Usuario <b>'+Nombre +'</b> <br/> ',
            showCancelButton : true,
            focusConfirm     : false,
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> '+ Accion +'!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
            if (result.value) {
                var apiUrl='<?php echo constant('RUTA_URL'); ?>/rest-api/Usuarios'; 
                var data = { 
                    usuarioID : userID,
                    userID    : clienteID,
                    Nombre    : Nombre,
                    Email     : Email,
                    Rol       : Rol,
                    empresaID : empresaID,
                    activo    : activo
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
                            title: 'Usuario '+ rtaAccion +'',
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
        window.location = "<?php echo constant('RUTA_URL');?>/lstusuarios";
    }
</script>