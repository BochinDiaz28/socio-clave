<?php require RUTA_APP . '/vistas/inc/header.php'; ?>
<?php require RUTA_APP . '/vistas/inc/menuLateral.php'; ?>
<?php 
    $empresaID = $datos['empresaID']; #|->EMPRESA LOGEADA
    $userID    = $datos['userID'];    #|->USUARIOS LOGEADO
    $tareaID   = $datos['tareaID'];   #|->TAREA QUE ESTOY CREANDO O EDITANDO
    #|->ESTABLECER FECHA
    $fecha1 = date('Y-m-d');
    $fecha2 = date('Y-m-d', strtotime('+1 day'));
?>
<div class="content">
    <?php require RUTA_APP . '/vistas/inc/menuSuperior.php'; ?>
    <div class="card mb-3">
        <div class="card-body">
            <a class="btn btn-outline-primary btn-sm mr-1 mb-1" type="button" 
               href="<?php echo constant('RUTA_URL'); ?>/lsttareas">
                <span class="fas fa-arrow-alt-circle-left me-1" data-fa-transform="shrink-3"></span>
                Regresar a Lista
            </a>
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
                    <small>Detalle corto EJ: Marca</small>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="clientes">Cliente</label>
                <div class="col-sm-9">
                    <select class="form-select form-select-sm clienteSelect" 
                            id="clientes"
                            onchange="ListaSucursales(0)">
                        <!--DINAMICO POR JS-->                       
                    </select>
                    <small>Cliente que solicita tarea</small>
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
                    <small>Lugar donde debe realizarse la tarea</small>
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
                    <label for="fechaCheckin" class="form-label">Fecha Inicio</label>
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
            <div class="form-group row">
                <div class="col-md-6">                    
                    <label for="foto_1" class="form-label">Foto de Inicio</label>
                    <select class="form-select form-select-sm" 
                            id="foto_1">
                        <!--DINAMICO POR JS-->                       
                    </select>
                    <small>Indique si se debe tomar foto al iniciar</small>
                </div>
                <div class="col-md-6">                    
                    <label for="foto_2" class="form-label">Foto al Finalizar</label>
                    <select class="form-select form-select-sm" 
                            id="foto_2">
                        <!--DINAMICO POR JS-->                       
                    </select>
                    <small>Indique si se debe tomar foto al finalizar</small>
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
    <input type="hidden" id="checkList" value="0">
</div>
<?php require RUTA_APP . '/vistas/inc/footer.php'; ?>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables-bs4/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables.net-responsive/dataTables.responsive.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>
<script>
    $(document).ready(function ()
    {
        $('.clienteSelect').select2();
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
                        
                        $('#fechaCheckin').val(item.fecha_sol);
                        $('#horaIngreso').val(item.hora_inicio);
                        $('#horaSalida').val(item.hora_final);
                        var contenidoCodificado = item.nota;
                        // Decodificar las entidades HTML
                        var parser = new DOMParser();
                        var contenidoDecodificado = parser.parseFromString(contenidoCodificado, 'text/html').body.textContent;

                        var miEditor = tinymce.get('descripcion');
                        //console.log(item.nota);
                        // Verifica si el editor existe
                        if (miEditor) {
                            // Establece el contenido recuperado en el editor
                            miEditor.setContent(contenidoDecodificado);
                        } else {
                            console.error('El editor no se encuentra inicializado.');
                        }
                        
                        $('#checkList').val(item.checklist);
                        //seleccion de tomar fotos
                        $('#foto_1').html("");
                        var $selectIni = $('#foto_1');                          
                        if(item.foto_inicio==0){
                            $selectIni.append("<option selected value='0'>No</option>");
                            $selectIni.append("<option value='1'>Si</option>");
                        }else{
                            $selectIni.append("<option value='0'>No</option>");
                            $selectIni.append("<option selected value='1'>Si</option>");
                        }
                        $('#foto_2').html("");
                        var $selectFin = $('#foto_2');
                        if(item.foto_final==0){
                            $selectFin.append("<option selected value='0'>No</option>");
                            $selectFin.append("<option value='1'>Si</option>");
                        }else{
                            $selectFin.append("<option value='0'>No</option>");
                            $selectFin.append("<option selected value='1'>Si</option>");
                        }
                    } 
                });  
                
                ListaClientes(clienteID);
                
            });
           
        }else{
            ListaClientes(clienteID);
            $('#foto_1').html("");
            var $selectIni = $('#foto_1');
                $selectIni.append("<option value='0'>No</option>");
                $selectIni.append("<option value='1'>Si</option>");

            $('#foto_2').html("");
            var $selectFin = $('#foto_2');
                $selectFin.append("<option value='0'>No</option>");
                $selectFin.append("<option value='1'>Si</option>");
        }    
        
    });
    
    function Controlar_Requeridos() 
    {
        var nombre       = document.querySelector('#nombre').value;
        var direccion    = document.querySelector('#direccion').value;
        var clientes     = document.querySelector('#clientes').value;
        var sucursal     = document.querySelector('#sucursal').value;
        var fechaCheckin = document.querySelector('#fechaCheckin').value;
        var horaIngreso  = '';//document.querySelector('#horaIngreso').value;
        var horaSalida   = '';//document.querySelector('#horaSalida').value;
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
        var tareaID = <?php echo $tareaID; ?>;
        var empresaID = <?php echo $empresaID; ?>;
        var formulario =0;
        var dataExtra = []; // Array para almacenar los datos extras
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
        var clientes     = document.querySelector('#clientes').value;
        var sucursal     = document.querySelector('#sucursal').value;
        var fechaCheckin = document.querySelector('#fechaCheckin').value;
        var horaIngreso  = document.querySelector('#horaIngreso').value;
        var horaSalida   = document.querySelector('#horaSalida').value;
        var descripcion  = tinymce.activeEditor.getContent();
        var controlCk    = document.querySelector('#controlCk').value;
        var foto1        = document.querySelector('#foto_1').value;
        var foto2        = document.querySelector('#foto_2').value;
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
                var apiUrl='<?php echo constant('RUTA_URL'); ?>/rest-api/Tareas.php'; 
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
                    controlCk : controlCk,
                    foto1     : foto1,
                    foto2     : foto2,
                    formulario: formulario,
                    dataExtra : dataExtra
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

    function redireccion(){
        window.location = "<?php echo constant('RUTA_URL');?>/lsttareas";
    }

    function ListaClientes(clienteID)
    {  
        console.log("Cliente: "+clienteID);
        var empresaID = <?php echo $empresaID; ?>;
        var url       = '<?php echo constant('RUTA_URL');?>/rest-api/Clientes?clientesTodosGET='+empresaID;
        fetch(url)
        .then(response => response.json())
        .then(data => {  //por aca leo los resultados de la consulta
            $('#clientes').html("");
            var $select = $('#clientes');
                $select.append('<option value="0">Seleccionar Cliente</option>');
            $.each(data, function(i, item) {
                if(clienteID==item.id){
                    $select.append('<option selected value=' + item.id + '>' + item.nombre + '</option>');
                    ListaSucursales();
                }else{
                    $select.append('<option value=' + item.id + '>' + item.nombre + '</option>');
                }
            });    
        });  
    }
    function ListaSucursales()
    {  
        var empresaID  = <?php echo $empresaID; ?>;
        var clienteID  = $('#clientes').val();
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


    //ESTABLECER FECHAS MINIMAS PARA LOS INPUT
    // Obtén el elemento input de fecha de check-in
    var fechaCheckinInput  = document.getElementById('fechaCheckin');
    //var fechaCheckoutInput = document.getElementById('fechaCheckout');
    // Obtén la fecha actual
    var fechaHoy = new Date();
    var yyyy     = fechaHoy.getFullYear();
    var mm       = (fechaHoy.getMonth() + 1).toString().padStart(2, '0');
    var dd       = fechaHoy.getDate().toString().padStart(2, '0');
    var fechaHoyStr = yyyy + '-' + mm + '-' + dd;

    // Establece la fecha mínima para el campo de fecha de check-in
    fechaCheckinInput.min  = fechaHoyStr;
    //fechaCheckoutInput.min = fechaHoyStr;
    //FIN ESTABLECER FECHAS MINIMAS PARA LOS INPUT
</script>