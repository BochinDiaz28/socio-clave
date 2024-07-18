<?php require RUTA_APP . '/vistas/inc/header.php'; ?>
<?php require RUTA_APP . '/vistas/inc/menuLateral.php'; ?>
<?php
    $empresaID = $datos['empresaID']; #|->EMPRESA LOGEADA
    $userID    = $datos['userID'];    #|->USUARIOS LOGEADO
?>
<?php 
    date_default_timezone_set('America/Santiago');
    $fecha  = date("Y-m-d");
    $inicio = $fecha; //.' '.'00:00:00';
    $final  = $fecha; //.' '.'23:59:99';
    // $inicio = $fecha; //date("Y-m-d",strtotime($fecha."- 1 days"));
    // $final  = $fecha; //date("Y-m-d",strtotime($fecha."+ 1 days"));  
?>
<div class="content">
    <?php require RUTA_APP . '/vistas/inc/menuSuperior.php'; ?>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row justify-content-between">
                <div class="col-md-auto">
                    <a class="btn btn-outline-primary btn-sm me-1 mb-1"
                       href="#"
                       onclick="FiltroRango(1)">
                        <span class="far fa-calendar-alt mr-1" data-fa-transform="shrink-3"></span>
                        <span class="text">Todas</span>
                    </a>
                </div>
                <div class="col-md-auto">                   
                    <input class="form-control-sm datetimepicker" id="timepicker2" type="text" placeholder="d/m/y to d/m/y" data-options='{"mode":"range","dateFormat":"Y-m-d","disableMobile":true}' />
                    <a class="btn btn-outline-primary btn-sm me-1 mb-1"
                       href="#"
                       onclick="FiltroRango(2)">
                        <span class="far fa-calendar-check mr-1" data-fa-transform="shrink-3"></span>
                        <span class="text">Filtrar</span>
                    </a>
                </div>
            </div>    
        </div>
       
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <h5>Tareas Finalizadas</h5>
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
            <p class="fs--1">Tareas Finalizadas: Lista de tareas finalizadas por agentes.</p>
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
<!--ESTOS SON PARA LOS BOTONES DEL DATATABLE-->
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/Buttons-1.6.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/Buttons-1.6.2/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/Buttons-1.6.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/Buttons-1.6.2/js/buttons.print.min.js"></script>

<script src="<?php echo constant('RUTA_URL');?>/public/assets/js/flatpickr.js"></script>
<script>
    $(document).ready(function ()
    {
        FiltroRango(1);
    });
    
    function FiltroRango(filtro) {
        if(filtro==1){
            var LinkFiltro = "<?php echo constant('RUTA_REST');?>/rest-api/Tareas?dttareasfinalizadasGET="+<?php echo $empresaID; ?>;
        }else{
            var filtro = $('#timepicker2').val();
            var arr = filtro.split('to');
            var inicio = arr[0].trim();
            var final  = arr[1].trim();
            var LinkFiltro = "<?php echo constant('RUTA_URL');?>/rest-api/Tareas?listaRangoGET="+<?php echo $empresaID ?>+"&inicio="+inicio +"&final="+final;
        }
        $('#Lista thead th').each(function () {
            var title = $(this).text();
            $(this).html(title);
        });
       
        var table = $('#Lista').DataTable({
                "destroy"   : true, 
                "scrollX"   : true,
                "pagingType": "numbers",
                "processing": true,
                "serverSide": true,
                "order"     : [[5, 'desc']],
                "ajax"      : LinkFiltro,
            columns: [
                { "title": "ID" },
                { "title": "Cliente" },  
                { "title": "Tarea" },                
                { "title": "Sucursal" },
                { "title": "Agente" },
                { "title": "Fecha" },
                { "title": "Check-in" },
                { "title": "Check-out" },
                { "title": "C. Agente" },
                { "title": "C. Admin" },
                { "title": "Acciones" },
            ],
            columnDefs: [
                {
                    "targets"   : [ 0 ],
                    "visible"   : false,
                    "searchable": false
                },
                {
                    targets: [ 8 ] ,
                    searchable: true,
                    orderable: false,
                    render: function(data, type, full, meta){
                        if(type === 'display'){
                            if(data==1){
                                data = 'C. con Exito';
                            }else{
                                data = 'Fallo';
                            }
                            
                        }
                        return data;
                    }
                    
                }, 
                {
                    targets: [ 9 ] ,
                    searchable: true,
                    orderable: false,
                    render: function(data, type, full, meta){
                        if(type === 'display'){
                            if(data===null || data === ''){
                                data = '<button class="btn btn-outline-primary btn-sm me-1 mb-1" title="Confirmar Cierre" type="button" onClick="confirmarCierre(' + full[10] + ')"><span class="sr-only">Confirmar Cierre</span><i class="fa fa-check"></i></button>';
                            }else{
                                data = 'C. con Exito';
                                
                            } 
                        }
                        return data;
                    }  
                }, 
                {
                    targets: [10 ] ,
                    searchable: true,
                    orderable: false,
                    render: function(data, type, full, meta){
                        if(type === 'display'){
                            data = '<button class="btn btn-outline-primary btn-sm me-1 mb-1" title="Ver Informe" type="button" onClick="FormFinalX(' + data + ')"><span class="sr-only">Ver Informe</span><i class="fa fa-eye"></i></button>';
                        }
                        return data;
                    }
                    //<button class="btn btn-outline-primary btn-sm me-1 mb-1" title="Ver Resultados" type="button" onClick="FormFinal(' + data + ')"><span class="sr-only">Ver Resultados</span><i class="fa fa-eye"></i></button>
                } 
            ],

            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Viendo _START_ a _END_ de _TOTAL_ T. Finalizadas",
                "infoEmpty": "Viendo 0 to 0 of 0 T. Finalizadas",
                "infoFiltered": "(Filtrado de _MAX_ total T. Finalizadas)",
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
            ordering  : "false",
            responsive: "true",
            dom       :"Bfrtilp",
            buttons:[
                {
                    extend   : 'excelHtml5',
                    text     : '<i class="far fa-file-excel"></i>',
                    titleAttr: 'Exportar a Excel',
                    className: 'btn btn-primary btn-sm me-1 mb-1',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend   : 'pdfHtml5',
                    text     : '<i class="far fa-file-pdf"></i>',
                    titleAttr: 'Exportar a PDF',
                    className: 'btn btn-primary btn-sm me-1 mb-1',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i>',
                    titleAttr: 'Imprimir',
                    className: 'btn btn-primary btn-sm me-1 mb-1',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5]
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
    }
    
    function recarga(){
        window.location = "<?php echo constant('RUTA_URL');?>/lsttareas/";
    }
    
    function FormFinalX(tareaID){
        window.open("<?php echo constant('RUTA_URL');?>/finalcliente?token=" + tareaID, '_blank');
    }

    /* no borrar aun.
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
    */
    function confirmarCierre(tareaID) {
        alert(tareaID)
    }

</script>