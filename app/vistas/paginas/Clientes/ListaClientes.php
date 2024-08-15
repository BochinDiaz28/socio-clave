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
                       href="<?php echo constant('RUTA_URL');?>/clientes/0">
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
        <p class="fs--1">Clientes: Son todas las personas en sistema con permisos para solicitar  tareas, estas deben ser aprobadas por administración</p>
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
                "ajax": "<?php echo constant('RUTA_REST');?>/rest-api/Clientes?dtclientesGET="+<?php echo $empresaID; ?>,
            columns: [
                { "title": "ID" },
                { "title": "Nombre" },                
                { "title": "Dirección" },
                { "title": "Celular" },
                { "title": "RUT" },
                { "title": "Inv." },
                { "title": "Informe" },
                { "title": "F.Tarea" },
                { "title": "Acciones" },
            ],
            columnDefs: [
                {
                    "targets"   : [ 0 ],
                    "visible"   : false,
                    "searchable": false
                },
                {
                    targets: [ 5 ] ,
                    searchable: true,
                    orderable: false,
                    render: function(data, type, full, meta){
                        if(type === 'display'){
                            if( data==1){
                                data = 'Si';
                            }else{
                                data = '';
                            }
                            
                        }
                        return data;
                    }
                    
                }, 
                {
                    targets: [ 6 ] ,
                    searchable: true,
                    orderable: false,
                    render: function(data, type, full, meta){
                        if(type === 'display'){
                            if( data==1){
                                data = 'Si';
                            }else{
                                data = '';
                            }
                            
                        }
                        return data;
                    }
                    
                }, 
                {
                    targets: [ 7 ] ,
                    searchable: true,
                    orderable: false,
                    render: function(data, type, full, meta){
                        if(type === 'display'){
                            if( data==1){
                                data = '<button class="btn btn-outline-info btn-sm me-1 mb-1" title="Formulario Tareas" type="button" onclick="FormTareas(' + full[8] + ')"><span class="sr-only">Formulario Tareas</span><i class="fas fa-clipboard-list"></i></button>';
                            }else{
                                data = '';
                            }
                            
                        }
                        return data;
                    }
                    
                }, 
                {
                    targets: [ 8 ] ,
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
                "info": "Viendo _START_ a _END_ de _TOTAL_ clientes",
                "infoEmpty": "Viendo 0 to 0 of 0 clientes",
                "infoFiltered": "(Filtrado de _MAX_ total clientes)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Ver _MENU_ clientes",
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
            title                 : '<strong>Eliminar el Cliente?</strong>',
            icon                  : 'info',
            html                  : 'Se eliminara el Cliente y todos sus datos!',
            showCancelButton      : true,
            focusConfirm          : false,
            confirmButtonText     : '<i class="fa fa-thumbs-up"></i> Eliminar!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
            if (result.value) {
                var apiUrl='<?php echo constant('RUTA_REST'); ?>/rest-api/Clientes'; 
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
                            title: 'Cliente eliminado!',
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
        window.location = "<?php echo constant('RUTA_URL');?>/lstclientes/";
    }

    function EditarForm(id){
        window.location = "<?php echo constant('RUTA_URL');?>/clientes/"+id;
    }

    function FormTareas(id) {
        window.location = "<?php echo constant('RUTA_URL');?>/extratareas/"+id;
    }
    
</script>