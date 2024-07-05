<?php require RUTA_APP . '/vistas/inc/header.php'; ?>
<?php require RUTA_APP . '/vistas/inc/menuLateral.php'; ?>
<?php 
    $empresaID = $datos['empresaID']; #|->EMPRESA LOGEADA
    $userID    = $datos['userID'];    #|->USUARIOS LOGEADO
    $sucursalID = $datos['sucursalID'];   #|->AGENTE QUE ESTOY CREANDO O EDITANDO
?>
<div class="content">
    <?php require RUTA_APP . '/vistas/inc/menuSuperior.php'; ?>
    <div class="card mb-3">
        <div class="card-body">
            <a class="btn btn-outline-primary btn-sm mr-1 mb-1" type="button" 
            href="<?php echo constant('RUTA_URL'); ?>/lstretails">
                <span class="fas fa-arrow-alt-circle-left me-1" data-fa-transform="shrink-3"></span>
                Regresar a Lista
            </a>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Sucursal</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="nombre">Canal *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="canal" placeholder="Grandes superficies" aria-label="" value="" />
                    
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="codigo">Codigo *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="codigo" placeholder="Ej: E503" aria-label="" value="" />
                    <small>Este codigo debe ser unico</small>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="cadena">Cadena *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="cadena" placeholder="" aria-label="" value="" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="local">Local *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="local" placeholder="" aria-label="" value="" />
                    <small>EJ: E503-ESSY-MAIPU</small>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="direccion">Dirección *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="direccion" placeholder="" aria-label="" value="" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="formato">Fromato *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="formato" placeholder="" aria-label="" value="" />
                </div>
            </div>
            <hr>
            <div class="form-group text-center">
                <?php  if ($sucursalID > 0){?> 
                    <button class="btn btn-outline-primary btn-sm me-1 mb-1" type="button" onclick="Controlar_Requeridos();">
                        <span class="fas fa-sd-card" data-fa-transform="shrink-3"></span> Actualizar
                    </button>
                <?php  }else{ $sucursalID=0; ?>
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
        var sucursalID  = <?php echo $sucursalID; ?>;
        var empresaID   = <?php echo $empresaID; ?>;
        if(sucursalID>0){
            var url ='<?php echo constant('RUTA_URL'); ?>/rest-api/Retail?sucursalID='+sucursalID+'&consultaGET='+empresaID;
            fetch(url)
            .then(response => response.json())
            .then(data => {
                $.each(data, function(i, item) {
                    if(sucursalID==item.id){
                        //`canal`, `cod_local`, `cadena`, `local`, `direccion`, `lat`, `lon`, `formato_local`
                        $('#canal').val(item.canal); 
                        $('#codigo').val(item.cod_local);
                        $('#cadena').val(item.cadena);
                        $('#local').val(item.local);
                        $('#direccion').val(item.direccion);
                        $('#formato').val(item.formato_local);
                    } 
                });   
            });
           
        }else{

        }    
        
    });
    function Controlar_Requeridos() 
    {
        var canal     = document.querySelector('#canal').value;
        var codigo    = document.querySelector('#codigo').value;
        var cadena    = document.querySelector('#cadena').value;
        var local     = document.querySelector('#local').value;
        var direccion = document.querySelector('#direccion').value;
        var formato   = document.querySelector('#formato').value;
        if(canal === '' || codigo==='' || cadena==='' || local==='' || direccion === '' || direccion === '' || formato===''){  //SI NO VALIDA CORRECTAMENTE TIRA CARTEL
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
        var userID     = <?php echo $userID ?>;
        var sucursalID = <?php echo $sucursalID; ?>;
        var empresaID  = <?php echo $empresaID; ?>;
        if(sucursalID==0)
        { 
            var Accion    = 'Crear';
            var rtaAccion = 'Creada!'; 
            var metodo    = 'POST'; 
        }else{
            var Accion    = 'Actualizar';  
            var rtaAccion = 'Actualizada!'; 
            var metodo    = 'PUT'; 
        }
       
        var canal     = document.querySelector('#canal').value;
        var codigo    = document.querySelector('#codigo').value;
        var cadena    = document.querySelector('#cadena').value;
        var local     = document.querySelector('#local').value;
        var direccion = document.querySelector('#direccion').value;
        var formato   = document.querySelector('#formato').value; 
        Swal.fire({
            title: '<strong>Confirma '+Accion+'?</strong>',
            icon : 'info',
            html : 'Sucursal <b>'+codigo +'</b> <br/> ',
            showCancelButton : true,
            focusConfirm     : false,
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> '+ Accion +'!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
            if (result.value) {
                var apiUrl='<?php echo constant('RUTA_URL'); ?>/rest-api/Retail'; 
                var data = { 
                    sucursalID : sucursalID,
                    usuarioID  : userID,
                    canal      : canal,
                    codigo     : codigo,
                    cadena     : cadena,
                    local      : local,
                    direccion  : direccion,
                    formato    : formato,
                    empresaID  : empresaID
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
                            title: 'Sucursal '+ rtaAccion +'',
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
        window.location = "<?php echo constant('RUTA_URL');?>/lstretails";
    }
</script>