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
                       href="<?php echo constant('RUTA_URL');?>/sucursales/0">
                        <span class="fas fa-plus mr-1" data-fa-transform="shrink-3"></span>
                        <span class="text">Nuevo</span>
                    </a>
                </div>
                <div class="col-md-auto">
                    <a class="btn btn-sm btn btn-outline-success btn-sm me-1 mb-1"
                    href="<?php echo constant('RUTA_URL');?>/uploadretails" >
                        <span class="far fa-file-excel mr-1" data-fa-transform="shrink-2"></span>
                        <span class="text">Subir</span>
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
            <p class="fs--1">Retails: Esta opcion esta diponible para cargar todas las sucursales o puntos a los que se da soporte, debe asociarlas a los clientes o empresas que correspondan.</p>
        </div> 
    </div>
</div>
<?php require RUTA_APP . '/vistas/inc/footer.php'; ?>


<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables-bs4/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables.net-responsive/dataTables.responsive.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>
<!--ESTOS SON PARA LOS BOTONES DEL DATATABLE-->
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/Buttons-1.6.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/Buttons-1.6.2/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/Buttons-1.6.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/Buttons-1.6.2/js/buttons.print.min.js"></script>

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
                "ajax": "<?php echo constant('RUTA_REST');?>/rest-api/Retail?dtretailGET="+<?php echo $empresaID; ?>,
            columns: [
                { "title": "ID" },
                { "title": "Canal" },                
                { "title": "Codigo" },
                { "title": "Cadena" },
                { "title": "Local" },
                { "title": "Dirección" },
                { "title": "Formato" },
                { "title": "Acciones" },
            ],
            columnDefs: [
                {
                    "targets"   : [ 0 ],
                    "visible"   : false,
                    "searchable": false
                },
                {
                    targets: [ 7 ] ,
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
            dom:"Bfrtilp",
            buttons:[
                {
                    extend: 'excelHtml5',
                    text: '<i class="far fa-file-excel"></i>',
                    titleAttr: 'Exportar a Excel',
                    className: 'btn btn-primary btn-sm me-1 mb-1',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="far fa-file-pdf"></i>',
                    titleAttr: 'Exportar a PDF',
                    className: 'btn btn-primary btn-sm me-1 mb-1',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i>',
                    titleAttr: 'Imprimir',
                    className: 'btn btn-primary btn-sm me-1 mb-1',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6]
                    }
                },
            ],

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


    function EliminarUsuario(id) 
    {
        var usuarioID = <?php echo $userID ?>;
        Swal.fire({
            title                 : '<strong>Eliminar Sucursal?</strong>',
            icon                  : 'info',
            html                  : 'Se eliminara y no se le podran asignar mas tareas!',
            showCancelButton      : true,
            focusConfirm          : false,
            confirmButtonText     : '<i class="fa fa-thumbs-up"></i> Eliminar!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
            if (result.value) {
                var apiUrl='<?php echo constant('RUTA_REST'); ?>/rest-api/Retail'; 
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
                            title: 'Sucursal eliminada!',
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
        window.location = "<?php echo constant('RUTA_URL');?>/lstretails/";
    }

    function EditarForm(id){
        window.location = "<?php echo constant('RUTA_URL');?>/sucursales/"+id;
    }
    
</script>