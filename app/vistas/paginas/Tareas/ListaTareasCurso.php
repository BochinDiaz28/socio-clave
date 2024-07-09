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
            <h5>Tareas en Curso</h5>
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
<div class="modal fade" id="modalHab" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles de Tarea</h5>
                <button type="button" class="btn-close" onclick="CloseModalHab()"></button>
            </div>
            <div class="modal-body">
                <h5><span id="_tareaTitulo"></span></h5>
                <h6><span id="_tareaSuc"></span></h6>
                <h6><span id="_tareaUb"></span></h6>
                <hr>
                <div id="detalleHab"></div>
            </div>
            <div class="modal-footer">
                
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
                "scrollX"   : true,
                "pagingType": "numbers",
                "processing": true,
                "serverSide": true,
                "ajax"      : "<?php echo constant('RUTA_REST');?>/rest-api/Tareas?dttareascursoGET="+<?php echo $empresaID; ?>,
            columns: [
                { "title": "ID" },
                { "title": "Cliente" }, 
                { "title": "Tarea" },                
                { "title": "Sucursal" },
                { "title": "Agente" },
                { "title": "Fecha" },
                { "title": "Check-in" },
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
                            data = '<button class="btn btn-outline-primary btn-sm me-1 mb-1" title="Ver Inicio" type="button" onClick="FormFinal(' + data + ')"><span class="sr-only">Ver Inicio</span><i class="fa fa-eye"></i></button>';      
                        }
                        return data;
                    }
                    
                } 
            ],

            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Viendo _START_ a _END_ de _TOTAL_ T. en Curso",
                "infoEmpty": "Viendo 0 to 0 of 0 T. en Curso",
                "infoFiltered": "(Filtrado de _MAX_ total T. en Curso)",
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
        window.location = "<?php echo constant('RUTA_URL');?>/lsttareas/";
    }

    function FormFinal(tareaID) {
        var  resultadosHtml = '';
        var url = '<?php echo constant('RUTA_URL');?>/rest-api/Tareas?tareaFotoGET='+tareaID;
        fetch(url)
        .then(response => response.json())
        .then(data => {
            $.each(data, function(i, item) {
                $('#_tareaTitulo').html(item.tarea);
                $('#_tareaSuc').html(item.sucursal);
                $('#_tareaUb').html(item.ubicacion);
                
                resultadosHtml += '<div class="card">';
                resultadosHtml += '<img src="<?php echo constant('RUTA_URL');?>/public/img/tarea/' + data[i].foto + '">';                        
                resultadosHtml += '<p class="card-text mb-0 mt-0">Comentario: ' + data[i].comentario + '</p>';
                resultadosHtml += '<p class="card-text mb-0 mt-0">Fecha: ' + data[i].fecha + '</p>';                        
                resultadosHtml += '</div>';
            }); 
            $('#detalleHab').html(resultadosHtml);   
            $('#modalHab').modal('show');
        }); 
    }

    function html_entity_decode(encodedString) {
        var domElement = document.createElement("textarea");
            domElement.innerHTML = encodedString;
        return domElement.value;
    }

    function CloseModalHab() {
        $('#modalHab').modal('hide');
    }
</script>