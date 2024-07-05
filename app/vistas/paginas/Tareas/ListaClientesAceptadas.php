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
                    <a class="btn btn-outline-primary btn-sm mr-1 mb-1" type="button" 
                       href="<?php echo constant('RUTA_URL'); ?>/inicio">
                            <span class="fas fa-arrow-alt-circle-left me-1" data-fa-transform="shrink-3"></span>
                            Inicio
                    </a>
                </div>
            </div>
        </div>

    </div>

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
       
        var userID = <?php echo $userID; ?>;
        var url       = '<?php echo constant('RUTA_URL');?>/rest-api/Clientes?clientesUserGET='+userID;
        fetch(url)
        .then(response => response.json())
        .then(data => {  //por aca leo los resultados de la consulta
            $.each(data, function(i, item) {
                Grilla(item.id);
            });
        });  
    }); 

    function Grilla(clienteID) {
        $('#Lista thead th').each(function () {
            var title = $(this).text();
            $(this).html(title);
        });
                            
        var table = $('#Lista').DataTable({
                "scrollX"   : true,
                "pagingType": "numbers",
                "processing": true,
                "serverSide": true,
                "ajax"      : "<?php echo constant('RUTA_REST');?>/rest-api/Tareas?dttrscliaceptadasGET="+<?php echo $empresaID; ?>+"&solicita2GET="+clienteID,
            columns: [
                { "title": "ID" },
                { "title": "Tarea" },                
                { "title": "Sucursal" },
                { "title": "Agente" },
                { "title": "Fecha" },
            ],
            columnDefs: [
                {
                    "targets"   : [ 0 ],
                    "visible"   : false,
                    "searchable": false
                }
                
            ],

            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Viendo _START_ a _END_ de _TOTAL_ t. aceptadas",
                "infoEmpty": "Viendo 0 to 0 of 0 t. aceptadas",
                "infoFiltered": "(Filtrado de _MAX_ total t. aceptadas)",
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
    }


</script>