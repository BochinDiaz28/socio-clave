<?php require RUTA_APP . '/vistas/inc/header.php'; ?>
<?php require RUTA_APP . '/vistas/inc/menuLateral.php'; ?>
<?php
    $empresaID = $datos['empresaID']; #|->EMPRESA LOGEADA
    $userID    = $datos['userID'];    #|->USUARIOS LOGEADO
?>
<div class="content">
    <?php require RUTA_APP . '/vistas/inc/menuSuperior.php'; ?>
    <div class="card mb-3">
        <div class="card-header">
            <div class="row">
                <div class="col-md-auto">
                    <a class="btn btn-outline-primary btn-sm me-1 mb-1"
                       href="<?php echo constant('RUTA_URL');?>/usuarios/0">
                        <span class="fas fa-plus mr-1" data-fa-transform="shrink-3"></span>
                        <span class="text">Nuevo</span>
                    </a>
                </div>
               
                
            </div>
        </div>

    </div>

    <div class="card mb-3">
        <div class="card-body">
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
        <div class="card-footer">
            <p class="fs--1">Usuarios: aquí puede ver los usuarios adminstradores, supervisores, agentes y clientes que tiene acceso al sistema.</p>
            <div class="row fs--1 fw-semi-bold text-500 g-0">
                <div class="col-auto d-flex align-items-center pe-3"><span class="dot bg-success"></span><span>En Linea</span><span class="d-none d-md-inline-block d-lg-none d-xxl-inline-block"></span></div>
                <div class="col-auto d-flex align-items-center pe-3"><span class="dot bg-warning"></span><span>Inactivo</span><span class="d-none d-md-inline-block d-lg-none d-xxl-inline-block"></span></div>
                <div class="col-auto d-flex align-items-center pe-3"><span class="dot bg-secondary"></span><span>Desconectado</span><span class="d-none d-md-inline-block d-lg-none d-xxl-inline-block"></span></div>                
            </div>
        </div> 
    </div>
</div>
<?php require RUTA_APP . '/vistas/inc/footer.php'; ?>


<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables-bs4/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables.net-responsive/dataTables.responsive.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>

<script>
    $(document).ready(function ()
    {
        $('#Lista thead th').each(function () {
            var title = $(this).text();
            $(this).html(title);
        });
                            
        var table = $('#Lista').DataTable({
                "scrollX": true,
                "pagingType": "numbers",
                "processing": true,
                "serverSide": true,
                "ajax": "<?php echo constant('RUTA_REST');?>/rest-api/Usuarios?dtusuariosGET="+<?php echo $empresaID; ?>,
            columns: [
                { "title": "ID" },
                { "title": "Username" },                
                { "title": "Nombre" },
                { "title": "Correo" },
                { "title": "Rol" },
                { "title": "Acticidad" },
            ],
            columnDefs: [
                {
                    "targets"   : [ 0 ],
                    "visible"   : false,
                    "searchable": false
                },
                {
                    targets: [ 2 ] ,
                    searchable: true,
                    orderable: false,
                    render: function(data, type, full, meta){
                        if(type === 'display'){
                            var estadoX = compararFecha(full[5]);
                            data ='<span class="dot '+estadoX+'"></span> '+ data;
                           
                            
                        }
                        return data;
                    }
                    
                } ,
                {
                    targets: [ 4 ] ,
                    searchable: true,
                    orderable: false,
                    render: function(data, type, full, meta){
                        if(type === 'display'){
                            if(data=='100'){
                                data = 'Super Admin';
                            }else if(data=='125'){
                                data = 'Supervisor';
                            }else if(data=='150'){
                                data = 'Cliente';
                            }else if(data=='200'){
                                data = 'Agente';
                            }
                            
                        }
                        return data;
                    }
                    
                } ,
                {
                    targets: [ 6 ] ,
                    searchable: true,
                    orderable: false,
                    render: function(data, type, full, meta){
                        if(type === 'display'){
                            data = '<button class="btn btn-outline-primary btn-sm me-1 mb-1" title="Editar" type="button" onClick="EditarForm(' + data + ')"><span class="sr-only">Editar</span><i class="fa fa-edit"></i></button><button class="btn btn-outline-warning btn-sm me-1 mb-1" title="Eliminar" type="button" onclick="EliminarUsuario(' + data + ')"><span class="sr-only">Eliminar</span><i class="fa fa-trash"></i></button>';      
                        }
                        return data;
                    }
                    
                } 
            ],

            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Viendo _START_ a _END_ de _TOTAL_ usuarios",
                "infoEmpty": "Viendo 0 to 0 of 0 usuarios",
                "infoFiltered": "(Filtrado de _MAX_ total usuarios)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Ver _MENU_ usuarios",
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


    function EliminarUsuario(id) {
        var usuarioID = <?php echo $userID ?>;
        Swal.fire({
            title                 : '<strong>Eliminar el usuario?</strong>',
            icon                  : 'info',
            html                  : 'Se eliminara el usuario',
            showCancelButton      : true,
            focusConfirm          : false,
            confirmButtonText     : '<i class="fa fa-thumbs-up"></i> Eliminar!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
            if (result.value) {
                var apiUrl='<?php echo constant('RUTA_REST'); ?>/rest-api/Usuarios'; 
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
                            title: 'Usuario eliminado!',
                            showConfirmButton: false,
                            timer: 2000
                        })
                        setInterval(recarga, 2000); 
                    }
                }) 
            }
        })
    }
    function recarga(){
        window.location = "<?php echo constant('RUTA_URL');?>/lstusuarios/";
    }

    function redireccion(id){
        window.location = "<?php echo constant('RUTA_URL');?>/usuarios/"+id;
    }

    function EditarForm(id){
        window.location = "<?php echo constant('RUTA_URL');?>/usuarios/"+id;
    }

    function compararFecha(fechaIndicada){
        // Obtener la fecha y hora actual
        const fechaActual = new Date();
        // Convertir la fecha actual a un formato similar al deseado (YYYY-MM-DD HH:MM:SS)
        const formatoDeseado   = `${fechaActual.getFullYear()}-${padZero(fechaActual.getMonth() + 1)}-${padZero(fechaActual.getDate())} ${padZero(fechaActual.getHours())}:${padZero(fechaActual.getMinutes())}:${padZero(fechaActual.getSeconds())}`;
        // Convertir las fechas a objetos Date para compararlas
        const fechaActualObj   = new Date(formatoDeseado);
        const fechaIndicadaObj = new Date(fechaIndicada);
        // Calcular la diferencia en minutos
        const diferenciaEnMinutos = (fechaIndicadaObj - fechaActualObj) / (1000 * 60);       
        // Comprobar si la diferencia es mayor a 5 minutos
        if ( -5 > diferenciaEnMinutos ) {
            //console.log("offline");
            return 'bg-secondary';
        } else if ( -9 > diferenciaEnMinutos ) {
            return 'bg-warning';
        } else {
           return 'bg-success';
        }
    }
    // Función para agregar un cero delante de números menores a 10
    function padZero(numero) {
        if (numero < 10) {
            return `0${numero}`;
        }
        return numero;
    }
    
</script>