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
            <h5>Tareas Aceptadas</h5>
        </div>
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
            <p class="fs--1">Tareas: Aceptadas o designadas a un agente.</p>
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
                "scrollX"   : true,
                "pagingType": "numbers",
                "processing": true,
                "serverSide": true,
                "ajax"      : "<?php echo constant('RUTA_REST');?>/rest-api/Tareas?dttareasaceptadasGET="+<?php echo $empresaID; ?>,
            columns: [
                { "title": "ID" },
                { "title": "Cliente" },   
                { "title": "Tarea" },                
                { "title": "Sucursal" },
                { "title": "Agente" },
                { "title": "Fecha" },
                { "title": "Acciones" },
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
                    orderable: false,
                    render: function(data, type, full, meta){
                        if(type === 'display'){
                            data = '<button class="btn btn-outline-danger btn-sm me-1 mb-1" title="Desasignar Tarea" type="button" onClick="DesasignarTarea(' + data + ')"><span class="sr-only">Desasignar Tarea</span><i class="fa fa-ban"></i></button>';      
                        }
                        return data;
                    }
                    
                } 
            ],

            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Viendo _START_ a _END_ de _TOTAL_ T. Aceptadas",
                "infoEmpty": "Viendo 0 to 0 of 0 T. Aceptadas",
                "infoFiltered": "(Filtrado de _MAX_ total T. Aceptadas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Ver _MENU_ tareas",
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


 
    function recarga(){
        window.location = "<?php echo constant('RUTA_URL');?>/lsttareasaceptadas/";
    }

    function DesasignarTarea(id) {
        var userID    = <?php echo $userID; ?>;
        var empresaID = <?php echo $empresaID; ?>;
        var tareaID   = id;
        var Accion    = 'Desasignar';  
        var rtaAccion = 'Desasignada!'; 
        var metodo    = 'POST';
     
        Swal.fire({
            title: '<strong>Confirma '+Accion+'?</strong>',
            icon : 'info',
            html : 'Se eliminara esta tarea de la lista del agente!',
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
                    estado    : 1
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