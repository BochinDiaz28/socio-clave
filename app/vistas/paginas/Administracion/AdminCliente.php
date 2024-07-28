<?php require RUTA_APP . '/vistas/inc/header.php'; ?>
<?php require RUTA_APP . '/vistas/inc/menuLateral.php'; ?>
<?php
    $empresaID = $datos['empresaID']; #|->EMPRESA LOGEADA
    $userID    = $datos['userID'];    #|->USUARIOS LOGEADO
    $tareaID   = 0;
?>
<div class="content">
    <?php require RUTA_APP . '/vistas/inc/menuSuperior.php'; ?>
    <!--MENU BINEVENIDA-->
    <div class="row g-3 mb-3">
        <div class="col-xxl-6 col-xl-12">
            <div class="row g-3">
                <div class="col-12">
                    <div class="card bg-transparent-50 overflow-hidden">
                    <div class="card-header position-relative">
                        <div class="bg-holder d-none d-md-block bg-card z-index-1" style="background-image:url(<?php if($LogoE<>''){?><?php echo constant('RUTA_URL'); ?>/public/img/logosEmpresas/<?php echo $_SESSION['empresaID']; ?>/<?php echo $LogoE; ?><?php }else{ ?> <?php echo constant('RUTA_URL'); ?>/public/assets/img/favicons/sistema-online_128.png' <?php } ?>);background-size:230px;background-position:right bottom;z-index:-1;"></div>
                        <div class="position-relative z-index-2">
                            <div>
                                <h3 class="text-primary mb-1">Hola, <span id="_Nombre"></span> !</h3>
                                <p>Gestor de tareas </p>
                            </div>
                        </div>
                    </div>
                    <!--SECCION LISTA VER ORDENES WEB CUANDO ESTEN ACTIVAS-->
                    <div class="card-body p-0">
                        <ul class="mb-0 list-unstyled">
                    
                            <li class="alert mb-0 rounded-0 py-3 px-card greetings-item border-top  border-0">
                                <div class="row flex-between-center py-2">
                                    <div class="col-md-2">
                                        <div class="d-flex">
                                            <div class="fas fa-list mt-1 fs--2 text-info"></div>
                                            <p class="fs--1 ps-2 mb-0">
                                                <a class="alert-link fs--1 fw-medium" href="<?php echo constant('RUTA_URL'); ?>/lstsolicitadas">
                                                    <strong> <span id="_WebOrdenes"></span> Tareas </strong> Solicitadas
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex">
                                            <div class="fas fa-user-check mt-1 fs--2 text-primary"></div>
                                            <p class="fs--1 ps-2 mb-0">
                                                <a class="alert-link fs--1 fw-medium" href="<?php echo constant('RUTA_URL'); ?>/lstaprobadas">
                                                    <strong> <span id="_WebOrdenesImp"></span> Tareas</strong> Aprobadas
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex">
                                            <div class="fas fa-check mt-1 fs--2 text-success"></div>
                                            <p class="fs--1 ps-2 mb-0">
                                                <a class="alert-link fs--1 fw-medium" href="<?php echo constant('RUTA_URL'); ?>/lstaceptadas">
                                                    <strong> <span id="_WebOrdenesPagas"></span> Tareas </strong> Aceptadas
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex">
                                            <div class="fas fa-clock mt-1 fs--2 text-danger"></div>
                                            <p class="fs--1 ps-2 mb-0">
                                                <a class="alert-link fs--1 fw-medium" href="<?php echo constant('RUTA_URL'); ?>/lstencurso">
                                                    <strong> <span id="_WebOrdenesProce"></span> Tareas </strong> en Curso
                                                </a>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="d-flex">
                                            <div class="fas fa-check-double mt-1 fs--2 text-secondary"></div>
                                            <p class="fs--1 ps-2 mb-0">
                                                <a class="alert-link fs--1 fw-medium" href="<?php echo constant('RUTA_URL'); ?>/lstfinalizadas">
                                                    <strong> <span id="_WebOrdenesProce"></span> Tareas </strong> Finalizadas
                                                    <!--<i class="fas fa-chevron-right ms-1 fs--2"></i>-->
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </li>
                        </ul>
                    </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Tarea</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="nombre">Nombre *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="nombre" placeholder="Nombre o Detalle corto" aria-label="" value="" />
                    <small>Detalle corto de la tarea</small>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="sucursal">Sucursal/Retail</label>
                <div class="col-sm-9">
                    <select class="form-select form-select-sm sucursalSelect" 
                            id="sucursal"
                            onchange="DireccionSucursal()">
                        <!--DINAMICO POR JS-->                       
                    </select>
                    <small>Si sus sucursales no aparecen aquí contacte al administrador</small>
                </div>
            </div>


            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="direccion">Dirección *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="direccion" placeholder="calle #123" aria-label="" value="" />
                </div>
            </div>

         
           
            <div class="form-group row">
                <div class="col-md-4">                    
                    <label for="fechaCheckin" class="form-label">Fecha</label>
                    <input type="date" class="form-control form-control-sm" id="fechaCheckin" 
                        value="<?php echo $fecha1;?>">
                </div>
                
                <div class="col-md-4">                    
                    <label for="horaIngreso" class="form-label">Hora Inicio</label>
                    <input type="time" class="form-control form-control-sm" id="horaIngreso" 
                        value="">
                </div>
                <div class="col-md-4">                    
                    <label for="horaSalida" class="form-label">Hora Fin</label>
                    <input type="time" class="form-control form-control-sm" id="horaSalida" 
                        value="">
                </div>
              
            </div>
        
            <br>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="descripcion">Descripción</label>
                <div class="col-sm-8">                    
                    <textarea class="tinymce d-none" id="descripcion" data-id="descripcion"></textarea>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="controlCk">Controlar Checklist</label>
                <div class="col-sm-8">                    
                    <select class="form-select form-select-sm" 
                            id="controlCk">
                        <!--DINAMICO POR JS-->                       
                    </select>
                    <small>Indique si se debe informar lista de trabajo</small>
                </div>
            </div>
            <hr>
            <div class="form-group text-center">
                <?php  if ($tareaID > 0){?> 
                    <button class="btn btn-outline-primary btn-sm me-1 mb-1" type="button" onclick="Controlar_Requeridos();">
                        <span class="fas fa-sd-card" data-fa-transform="shrink-3"></span> Actualizar
                    </button>
                <?php  }else{ $tareaID=0; ?>
                    <button class="btn btn-outline-primary btn-sm me-1 mb-1" type="button" onclick="Controlar_Requeridos();">
                        <span class="fas fa-sd-card" data-fa-transform="shrink-3"></span> Guardar
                    </button>
                <?php  }?> 
            </div>
        </div>
    </div>
    <input type="hidden" id="sucID" value="0">
    <input type="hidden" id="clienteID" value="0">
</div>

<?php require RUTA_APP . '/vistas/inc/footer.php'; ?>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables-bs4/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables.net-responsive/dataTables.responsive.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>

<script>
  $(document).ready(function ()
    {
        $('.sucursalSelect').select2();
        /*=================================*/ 
        var tareaID    = <?php echo $tareaID; ?>;
        var empresaID  = <?php echo $empresaID; ?>;
        var clienteID  = 0;
        var sucursalID = 0;
        if(tareaID>0){
            var url ='<?php echo constant('RUTA_URL'); ?>/rest-api/Tareas?tareaID='+tareaID;
            fetch(url)
            .then(response => response.json())
            .then(data => {
                $.each(data, function(i, item) {
                    if(tareaID==item.id){
                        clienteID  = item.idcliente;
                        $('#sucID').val(item.idreail);
                        $('#nombre').val(item.tarea); 
                        $('#direccion').val(item.ubicacion);
                        //item.lat
                        //item.lon
                        //item.nota
                        $('#fechaCheckin').val(item.fecha_sol);
                        $('#horaIngreso').val(item.hora_inicio);
                        $('#horaSalida').val(item.hora_final);
                    } 
                });  
                
                //ListaClientes(clienteID);
                
            });
           
        }else{
            //ListaClientes(clienteID);
        }    
        
    });

    function ListaClientes()
    {  
        var userID = <?php echo $userID; ?>;
        var url       = '<?php echo constant('RUTA_URL');?>/rest-api/Clientes?clientesUserGET='+userID;
        fetch(url)
        .then(response => response.json())
        .then(data => {  //por aca leo los resultados de la consulta
            $.each(data, function(i, item) {
                $('#clienteID').val(item.id);
                $('#_Nombre').html(item.nombre);
                
            }); 
            ListaSucursales();   
        });  
    }

    ListaClientes();
    function ListaSucursales()
    {  
        var empresaID  = <?php echo $empresaID; ?>;
        var clienteID  = $('#clienteID').val();
        var sucursalID = $('#sucID').val();
        if(clienteID>0){
            var url = '<?php echo constant('RUTA_URL');?>/rest-api/Retail?sucursalesClientesGET='+clienteID+'&empresaID='+empresaID;
            fetch(url)
            .then(response => response.json())
            .then(data => {  //por aca leo los resultados de la consulta
                $('#sucursal').html("");
                var $select = $('#sucursal');
                $select.append('<option value="0">Seleccionar Sucursal</option>');
                $.each(data, function(i, item) {
                    if(sucursalID==item.idretail){
                        $select.append('<option selected selected value=' + item.idretail + '>' + item.local + '</option>');
                    }else{
                        $select.append('<option value=' + item.idretail + '>' + item.local + '</option>');
                    }
                });    
            });  
            solicitarCheckList(clienteID)
        }
    }

    function DireccionSucursal()
    {  
        var empresaID = <?php echo $empresaID; ?>;
        var sucursalID = $('#sucursal').val();
        console.log(sucursalID);
        if(sucursalID>0){
            var url = '<?php echo constant('RUTA_URL');?>/rest-api/Retail?sucursalID='+sucursalID;
            fetch(url)
            .then(response => response.json())
            .then(data => {  //por aca leo los resultados de la consulta
                $.each(data, function(i, item) {                   
                    $("#direccion").val(item.direccion);
                });    
            }); 
        }
    }
    function Controlar_Requeridos() 
    {
        var nombre       = document.querySelector('#nombre').value;
        var direccion    = document.querySelector('#direccion').value;
        var clientes     = document.querySelector('#clienteID').value;
        var sucursal     = document.querySelector('#sucursal').value;
        var fechaCheckin = document.querySelector('#fechaCheckin').value;
        var horaIngreso  = document.querySelector('#horaIngreso').value;
        var horaSalida   = document.querySelector('#horaSalida').value;
        if(nombre === '' || direccion===''){  //SI NO VALIDA CORRECTAMENTE TIRA CARTEL
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
        var tareaID   = <?php echo $tareaID; ?>;
        var empresaID = <?php echo $empresaID; ?>;
        if(tareaID==0)
        { 
            var Accion    = 'Crear';
            var rtaAccion = 'Creada!'; 
            var metodo    = 'POST'; 
        }else{
            var Accion    = 'Actualizar';  
            var rtaAccion = 'Actualizada!'; 
            var metodo    = 'PUT'; 
        }
       
        var nombre       = document.querySelector('#nombre').value;
        var direccion    = document.querySelector('#direccion').value;
        var clientes     = document.querySelector('#clienteID').value;
        var sucursal     = document.querySelector('#sucursal').value;
        var fechaCheckin = document.querySelector('#fechaCheckin').value;
        var horaIngreso  = document.querySelector('#horaIngreso').value;
        var horaSalida   = document.querySelector('#horaSalida').value;
        var descripcion  = tinymce.activeEditor.getContent();
            // descripcion  = descripcion.replace(/['"]+/g, '');
        var controlCk    = document.querySelector('#controlCk').value;
        Swal.fire({
            title: '<strong>Confirma '+Accion+'?</strong>',
            icon : 'info',
            html : 'Tarea <b>'+nombre +'</b> <br/> ',
            showCancelButton : true,
            focusConfirm     : false,
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> '+ Accion +'!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
            if (result.value) {
                var apiUrl='<?php echo constant('RUTA_URL'); ?>/rest-api/Tareas'; 
                var data = { 
                    usuarioID : userID,
                    tareaID   : tareaID,
                    Nombre    : nombre,
                    Direccion : direccion,
                    Cliente   : clientes,
                    Sucursal  : sucursal,
                    Fecha     : fechaCheckin,
                    HIngreso  : horaIngreso,
                    HSalida   : horaSalida,
                    empresaID : empresaID,
                    Estado    : 1,
                    Nota      : descripcion,
                    controlCk : controlCk
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
                            title: 'Tarea '+ rtaAccion +'',
                            showConfirmButton: false,
                            timer: 2000
                        })
                        setInterval(redireccion, 2000); 
                    }
                }) 

            }   
        })
    }

    function solicitarCheckList(clienteID)
    {  
        if(clienteID>0){
            var panol = 0;
            var checkX =  $('#checkList').val();
            var url = '<?php echo constant('RUTA_URL');?>/rest-api/Clientes?clienteID='+clienteID;
            fetch(url)
            .then(response => response.json())
            .then(data => {                
                $('#controlCk').html("");
                var $select = $('#controlCk');               
                $.each(data, function(i, item) {                   
                    panol = item.panol;
                    if(panol==1){
                        //muestro opcion de checklist
                        if(checkX==1){
                            $select.append('<option value=0>No</option>');
                            $select.append('<option selected selected value=1>Si</option>');
                        }else{
                            $select.append('<option selected selected value=0>No</option>');
                            $select.append('<option value=1>Si</option>');
                         }
                    }else{
                        //desactivo opcion de checklist
                        $select.append('<option selected selected value=0>No</option>');
                    }
                });    
            }); 
        }
    }

    function redireccion(){
        window.location = "<?php echo constant('RUTA_URL');?>/inicio";
    }
    //ESTABLECER FECHAS MINIMAS PARA LOS INPUT
    // Obtén el elemento input de fecha de check-in
    var fechaCheckinInput  = document.getElementById('fechaCheckin');
    //var fechaCheckoutInput = document.getElementById('fechaCheckout');
    // Obtén la fecha actual
    var fechaHoy    = new Date();
    var yyyy        = fechaHoy.getFullYear();
    var mm          = (fechaHoy.getMonth() + 1).toString().padStart(2, '0');
    var dd          = fechaHoy.getDate().toString().padStart(2, '0');
    var fechaHoyStr = yyyy + '-' + mm + '-' + dd;

    // Establece la fecha mínima para el campo de fecha de check-in
    fechaCheckinInput.min  = fechaHoyStr;
    //fechaCheckoutInput.min = fechaHoyStr;
    //FIN ESTABLECER FECHAS MINIMAS PARA LOS INPUT
</script>