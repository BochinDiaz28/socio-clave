<?php require RUTA_APP . '/vistas/inc/header.php'; ?>
<?php require RUTA_APP . '/vistas/inc/menuLateral.php'; ?>
<?php 
    $empresaID = $datos['empresaID']; #|->EMPRESA LOGEADA
    $userID    = $datos['userID'];    #|->USUARIOS LOGEADO
    $agenteID = $datos['agenteID'];   #|->AGENTE QUE ESTOY CREANDO O EDITANDO
?>
<div class="content">
    <?php require RUTA_APP . '/vistas/inc/menuSuperior.php'; ?>
    <div class="card mb-3">
        <div class="card-body">
            <a class="btn btn-outline-primary btn-sm mr-1 mb-1" type="button" 
            href="<?php echo constant('RUTA_URL'); ?>/lstagentes">
                <span class="fas fa-arrow-alt-circle-left me-1" data-fa-transform="shrink-3"></span>
                Regresar a Lista
            </a>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Agente</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="nombre">Apellido y Nombre *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="nombre" placeholder="Apellido y Nombre" aria-label="" value="" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="direccion">Dirección *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="direccion" placeholder="calle #123" aria-label="" value="" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="celular">Tel. Celular *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="number" id="celular" placeholder="" aria-label="" value="" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="dni">Cedula *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="dni" placeholder="" aria-label="" value="" />
                    <small>EJ: N° de RUT - NFC - DNI - Pasaporte</small>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="email">E-Mail *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="email" placeholder="Correo Electronico" aria-label="" value="" />
                </div>
            </div>
            <hr>
            <div class="form-group text-center">
                <?php  if ($agenteID > 0){?> 
                    <button class="btn btn-outline-primary btn-sm me-1 mb-1" type="button" onclick="Controlar_Requeridos();">
                        <span class="fas fa-sd-card" data-fa-transform="shrink-3"></span> Actualizar
                    </button>
                <?php  }else{ $agenteID=0; ?>
                    <button class="btn btn-outline-primary btn-sm me-1 mb-1" type="button" onclick="Controlar_Requeridos();">
                        <span class="fas fa-sd-card" data-fa-transform="shrink-3"></span> Guardar
                    </button>
                <?php  }?> 
            </div>
        </div>
    </div>
    <?php  if($agenteID > 0){?> 
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Sucursales Disponibles</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="sucursal">Suscursal</label>
                    <div class="col-sm-8">
                        <select class="form-select form-select-sm sucursalSelect" 
                                id="sucursal"
                                onchange="ActivarBtn()">
                            <!--DINAMICO POR JS-->                       
                        </select>
                        <small>Los Agentes asociados a sucursales podran realizar tareas</small>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive scrollbar">
                            <table class="table table-sm fs--1 mb-0 overflow-hidden"  
                                id="Lista"                            
                                style="width:100%">
                                <thead class="bg-200 text-900">
                                    <!-- COMPLETO LOS TITULOS DINAMICOS -->
                                </thead>                
                                    <!-- COMPLETO LOS DATOS DINAMICOS -->
                            </table>
                        </div>
                    </div>  
                </div> 
            </div>
        </div>
    <?php  }?> 
</div>
<?php require RUTA_APP . '/vistas/inc/footer.php'; ?>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables-bs4/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables.net-responsive/dataTables.responsive.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>
<script>
    $(document).ready(function ()
    {
        var agenteID  = <?php echo $agenteID; ?>;
        var empresaID = <?php echo $empresaID; ?>;
        if(agenteID>0){
            var url ='<?php echo constant('RUTA_URL'); ?>/rest-api/Agentes?agenteID='+agenteID+'&consultaGET='+empresaID;
            fetch(url)
            .then(response => response.json())
            .then(data => {
                $.each(data, function(i, item) {
                    if(agenteID==item.id){
                        //`id`, `idempresa`, `idusuario`, `nombre`, `direccion`, `lat`, `lon`, `celular`, `email`, `cuit`, 
                        $('#nombre').val(item.nombre); 
                        $('#direccion').val(item.direccion);
                        $('#celular').val(item.celular);
                        $('#dni').val(item.cuit);
                        $('#email').val(item.email);
                    } 
                });   
            });
           
        }else{
        
            $('#nombre').val(); 
            $('#direccion').val();
            $('#celular').val();
            $('#dni').val();
            $('#email').val();

        }    
        
    });
    function Controlar_Requeridos() 
    {
        var nombre    = document.querySelector('#nombre').value;
        var direccion = document.querySelector('#direccion').value;
        var celular   = document.querySelector('#celular').value;
        var dni       = document.querySelector('#dni').value;
        var email     = document.querySelector('#email').value;
        if(nombre === '' || direccion==='' || celular==='' || dni==='' || email === ''){  //SI NO VALIDA CORRECTAMENTE TIRA CARTEL
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
        var clienteID = <?php echo $agenteID; ?>;
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
       
        var Nombre    = $("#nombre").val();
        var Direccion = $('#direccion').val();
        var Celular   = $('#celular').val();
        var Dni       =  $('#dni').val();
        var Email     = $("#email").val();    
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
                var apiUrl='<?php echo constant('RUTA_URL'); ?>/rest-api/Agentes'; 
                var data = { 
                    usuarioID : userID,
                    userID    : clienteID,
                    Nombre    : Nombre,
                    Direccion : Direccion,
                    Celular   : Celular,
                    Dni       : Dni,
                    Email     : Email,
                    empresaID : empresaID
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
                            title: 'Agente '+ rtaAccion +'',
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
        window.location = "<?php echo constant('RUTA_URL');?>/lstagentes";
    }
    <?php  if($agenteID > 0){?> 
        function ListaSucursales()
        {  
            var empresaID = <?php echo $empresaID; ?>;
            var url = '<?php echo constant('RUTA_URL');?>/rest-api/Retail?sucursalesGET='+empresaID;
            fetch(url)
            .then(response => response.json())
            .then(data => {  //por aca leo los resultados de la consulta
                $('#sucursal').html("");
                var $select = $('#sucursal');
                $select.append('<option value="0">Seleccionar Sucursal</option>');
                $.each(data, function(i, item) {
                    $select.append('<option value=' + item.id + '>' + item.local + '</option>');
                });    
            });  
        }
        
        $(document).ready(function ()
        {
            $('.sucursalSelect').select2();
            ListaSucursales();
            /*=================================*/ 
        });

        $(document).ready(function ()
        {
            var empresaID = <?php echo $empresaID;?>;
            var agenteID = <?php echo $agenteID;?>;
            $('#Lista thead th').each(function () {
                var title = $(this).text();
                $(this).html(title);
            });
                                
            var table = $('#Lista').DataTable({
                    "scrollX"   : true,
                    "pagingType": "numbers",
                    "processing": true,
                    "serverSide": true,
                    "ajax"      : "<?php echo constant('RUTA_REST');?>/rest-api/AgentesRetails?dtagentesRetailGET="+empresaID+"&agenteID="+agenteID,
                columns: [
                    { "title": "ID" },
                    { "title": "Canal" },                
                    { "title": "Codigo" },
                    { "title": "Local" },
                    { "title": "acciones" },                    
                  
                ],
                columnDefs: [
                    {
                        "targets"   : [ 0 ],
                        "visible"   : false,
                        "searchable": false
                    },
                    {
                        targets: [ 4 ] ,
                        searchable: true,
                        orderable: false,
                        render: function(data, type, full, meta){
                            if(type === 'display'){
                                data = '<button class="btn btn-outline-warning btn-sm me-1 mb-1" title="Eliminar" type="button" onclick="EliminarUsuario(' + data + ')"><span class="sr-only">Eliminar</span><i class="fa fa-trash"></i></button>';      
                            }
                            return data;
                        }
                        
                    } 
                ],

                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Viendo _START_ a _END_ de _TOTAL_ sucursales",
                    "infoEmpty": "Viendo 0 to 0 of 0 sucursales",
                    "infoFiltered": "(Filtrado de _MAX_ total sucursales)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Ver _MENU_ sucursales",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "",
                    "searchPlaceholder": "Buscar",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": ">",
                        "previous": "<"
                    }
                    
                },
                "lengthMenu": [ 100, 250, 500, 750, 1000 ],
            
                ordering: "false",
                responsive: "true",


            });
            /*BUSCADOR*/
            table.columns().every(function () {
                var table = this;
                $('input', this.header()).on('keyup change', function () {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
            }); 

        }); 

        function ActivarBtn() {
            var userID    = <?php echo $userID ?>;
            var agenteID  = <?php echo $agenteID; ?>;
            var empresaID = <?php echo $empresaID; ?>;
            var sucursalID = $('#sucursal').val();
            var selectElement = document.getElementById("sucursal");
            var selectedId = selectElement.value;
            var selectedOption = selectElement.querySelector(`option[value="${selectedId}"]`);
            var selectedText = selectedOption.textContent;
 

            if(sucursalID>0){
                Swal.fire({
                title: '<strong>Confirma Asociar sucursal?</strong>',
                icon : 'info',
                html : 'Sucursal <b>'+ selectedText +'</b> <br/> ',
                showCancelButton : true,
                focusConfirm     : false,
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Asociar!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
                cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
                cancelButtonAriaLabel : 'Thumbs down'
            }).then((result) => {
                if (result.value) {
                    var apiUrl='<?php echo constant('RUTA_URL'); ?>/rest-api/AgentesRetails'; 
                    var data = { 
                        usuarioID  : userID,
                        agenteID   : agenteID,
                        sucursalID : sucursalID,
                        empresaID  : empresaID
                    } 
                    fetch(apiUrl,{ 
                        method : 'POST',  
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
                                title: 'Sucursal asociada con exito!',
                                showConfirmButton: false,
                                timer: 2000
                            })
                            setInterval(redireccionLocal, 2000); 
                        }
                    }) 

                }   
            })
            }
        }

        function redireccionLocal(){           
           location.reload();
        }

        function EliminarUsuario(id) {
            var usuarioID = <?php echo $userID ?>;
            Swal.fire({
                title                 : '<strong>Eliminar asociación?</strong>',
                icon                  : 'info',
                html                  : 'El Agente ya no podra realizar tareas a esa sucursal!',
                showCancelButton      : true,
                focusConfirm          : false,
                confirmButtonText     : '<i class="fa fa-thumbs-up"></i> Eliminar!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
                cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
                cancelButtonAriaLabel : 'Thumbs down'
            }).then((result) => {
                if (result.value) {
                    var apiUrl='<?php echo constant('RUTA_REST'); ?>/rest-api/AgentesRetails'; 
                    var data = { 
                        userID    : id, 
                        usuarioID : usuarioID 
                    } 
                    fetch(apiUrl,{ 
                        method : 'DELETE',  
                        headers: {'Content-type' : 'application/json'},
                        body   : JSON.stringify(data) 
                    })
                    .then(response => response.json() )
                    .then(data => {
                        console.log(data);
                        if(data[0]["error"]){
                            Swal.fire({
                                type: 'error',
                                icon: 'error',
                                title: ''+data[0]["error"]+'',
                                showConfirmButton: false,
                                timer: 2000
                            })                        
                        }else{
                            var idapuesta = data[0]['retornoID'];                             
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: 'Asociación eliminada!',
                                showConfirmButton: false,
                                timer: 2000
                            })
                            setInterval(redireccionLocal, 2000); 
                        }
                    }) 
                }
            })
        }
    <?php  }?> 
</script>