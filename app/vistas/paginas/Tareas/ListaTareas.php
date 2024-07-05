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
                       href="<?php echo constant('RUTA_URL');?>/tareas/0">
                        <span class="fas fa-plus mr-1" data-fa-transform="shrink-3"></span>
                        <span class="text">Nueva</span>
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
            <p class="fs--1">Tareas: Acciones a realizarse por los agentes, estas en caso de no ser cargadas por un administrador deben ser aprobadas antes de que los agentes puedan tomarlas.</p>
        </div> 
    </div>
</div>

<div class="modal fade" id="modalAsoc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Asignar Agente</h5>
                <button type="button" class="btn-close" onclick="CloseModalHab()"></button>
            </div>
            <div class="modal-body">
                <!--<div id="detalleHab"></div>-->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="sucursal">Agente</label>
                    <div class="col-sm-8">
                        <select class="form-select form-select-sm sucursalSelect" 
                                id="sucursal"
                                onchange="ActivarBtn()">
                            <!--DINAMICO POR JS-->                       
                        </select>
                       
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <small>Los Agentes asociados a sucursales podran realizar tareas</small>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="tareaID">
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
                "scrollX"   : true,
                "pagingType": "numbers",
                "processing": true,
                "serverSide": true,
                "ajax"      : "<?php echo constant('RUTA_REST');?>/rest-api/Tareas?dttareasGET="+<?php echo $empresaID; ?>,
            columns: [
                { "title": "ID"},
                { "title": "Cliente"}, 
                { "title": "Tarea"},                
                { "title": "Sucursal"},
                { "title": "Direccion"},
                { "title": "Fecha" },
                { "title": "Estado" },
                { "title": "Acciones"},
            ],
            columnDefs: [
                {
                    "targets"   : [ 0 ],
                    "visible"   : false,
                    "searchable": false
                },
                {
                    targets: [ 6 ] ,
                    searchable: true,
                    orderable: true,
                    render: function(data, type, full, meta){
                        if(type === 'display'){
                            if(data==0){
                                data ='<span class="badge badge-soft-danger">Pendiente</span>';
                            }else{
                                data ='<span class="badge badge-soft-success">Aprobada</span>';
                            }
                            
                        }
                        return data;
                    }
                    
                }, 
                {
                    targets   : [ 7 ] ,
                    searchable: true,
                    orderable : false,
                    render: function(data, type, full, meta){
                        if(type === 'display'){
                            if(full[6] ==0){
                                data = '<button class="btn btn-outline-primary btn-sm me-1 mb-1" title="Editar" type="button" onClick="EditarForm(' + data + ')"><span class="sr-only">Editar</span><i class="fa fa-edit"></i></button><button class="btn btn-outline-warning btn-sm me-1 mb-1" title="Eliminar" type="button" onclick="EliminarUsuario(' + data + ')"><span class="sr-only">Eliminar</span><i class="fa fa-trash"></i></button>';      
                            }else{
                                data = '<button class="btn btn-outline-success btn-sm me-1 mb-1" title="Asignar Agente" type="button" onClick="AsignarForm(' + data + ')"><span class="sr-only">Asignar Agente</span><i class="fas fa-user-secret"></i></button><button class="btn btn-outline-primary btn-sm me-1 mb-1" title="Editar" type="button" onClick="EditarForm(' + data + ')"><span class="sr-only">Editar</span><i class="fa fa-edit"></i></button><button class="btn btn-outline-warning btn-sm me-1 mb-1" title="Eliminar" type="button" onclick="EliminarUsuario(' + data + ')"><span class="sr-only">Eliminar</span><i class="fa fa-trash"></i></button>';      
                            }
                            
                        }
                        return data;
                    }
                    
                } 
            ],

            language: {
                "decimal"   : "",
                "emptyTable": "No hay información",
                "info"      : "Viendo _START_ a _END_ de _TOTAL_ tareas",
                "infoEmpty" : "Viendo 0 to 0 of 0 tareas",
                "infoFiltered": "(Filtrado de _MAX_ total tareas)",
                "infoPostFix" : "",
                "thousands"   : ",",
                "lengthMenu"  : "Ver _MENU_ tareas",
                "loadingRecords": "Cargando...",
                "processing"    : "Procesando...",
                "search"        : "",
                "searchPlaceholder": "Buscar",
                "zeroRecords"      : "Sin resultados encontrados",
                "paginate" : {
                    "first": "Primero",
                    "last" : "Ultimo",
                    "next" : ">",
                    "previous": "<"
                }
                
            },
            "lengthMenu": [ 100, 250, 500, 750, 1000 ],
            ordering  : "false",
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
            title                 : '<strong>Eliminar la Tarea?</strong>',
            icon                  : 'info',
            html                  : 'Se eliminara la tarea!',
            showCancelButton      : true,
            focusConfirm          : false,
            confirmButtonText     : '<i class="fa fa-thumbs-up"></i> Eliminar!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
            if (result.value) {
                var apiUrl='<?php echo constant('RUTA_REST'); ?>/rest-api/Tareas'; 
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
                            title: 'Tarea eliminada!',
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
        window.location = "<?php echo constant('RUTA_URL');?>/lsttareas/";
    }

    function EditarForm(id){
        window.location = "<?php echo constant('RUTA_URL');?>/tareas/"+id;
    }
    
    function AsignarForm(id) {  
        $('#tareaID').val(id);
        var url = '<?php echo constant('RUTA_URL');?>/rest-api/AgentesTareas?tareasRetailGET='+id;
        fetch(url)
        .then(response => response.json())
        .then(data => {
            $('#sucursal').html("");
            var $select = $('#sucursal');
            $select.append('<option value="0">Seleccionar Agente</option>');
            $.each(data, function(i, item) {
                $select.append('<option value=' + item.Id + '>' + item.Nombre + '</option>');
            });      
            $('#modalAsoc').modal('show');
        }); 
       
    }

    function CloseModalHab() {
        $('#modalAsoc').modal('hide');
    }

    function ActivarBtn() 
    {
        var userID    = <?php echo $userID; ?>;
        var empresaID = <?php echo $empresaID; ?>;
        var tareaID   = $('#tareaID').val();
        var agenteID  = $('#sucursal').val(); 
        var Accion    = 'Asignar';  
        var rtaAccion = 'Asignada!'; 
        var metodo    = 'PUT';
     
        Swal.fire({
            title: '<strong>Confirma '+Accion+'?</strong>',
            icon : 'info',
            html : 'Si nadie tomo esta tarea se le asignara!',
            showCancelButton      : true,
            focusConfirm          : false,
            confirmButtonText     : '<i class="fa fa-thumbs-up"></i> '+ Accion +'!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
            if (result.value) {
                var apiUrl='<?php echo constant('RUTA_URL'); ?>/rest-api/AgentesTareas'; 
                var data = { 
                    usuarioID : userID,
                    tareaID   : tareaID,              
                    empresaID : empresaID,
                    agenteID  : agenteID,
                    estado    : 2
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
                        setInterval(recarga, 2000); 
                    }
                }) 

            }   
        })
    }
</script>