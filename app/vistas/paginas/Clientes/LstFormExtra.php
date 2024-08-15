<?php require RUTA_APP . '/vistas/inc/header.php'; ?>
<?php require RUTA_APP . '/vistas/inc/menuLateral.php'; ?>
<?php
    $empresaID   = $datos['empresaID']; #|->EMPRESA LOGEADA
    $userID      = $datos['userID'];    #|->USUARIOS LOGEADO
    $propiedadID = $datos['clienteID']; #|->ID DE LA PROPIEDAD
?>

<div class="content">
    <?php require RUTA_APP . '/vistas/inc/menuSuperior.php'; ?>    
    <!--MENU BINEVENIDA-->
    <div class="row g-3 mb-3">
        <div class="col-xxl-6 col-xl-12">
            <div class="row g-3">
                <div class="col-12">
                    <div class="card bg-transparent-50 overflow-hidden">
                        <div class="card-header position-relative">                            
                            <div class="position-relative z-index-2">
                                <div>                             
                                    <a class="btn btn-primary btn me-1 mb-1" type="button" href="<?php echo constant('RUTA_URL'); ?>/lstclientes">
                                        <span class="fas fa-arrow-alt-circle-left" data-fa-transform="shrink-3"></span> Regresar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Nombre los Campos</h5>
            <h6 class="fs--1">Estos datos se mostraran en el orden nombrados.</h6>
        </div>
        <div class="card-body">
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
        //LISTO IMAGENS DE LA PROPIEDAD
        function documentacionAdjunta() {
            $('#Lista thead th').each(function () {
                var title = $(this).text();
                $(this).html(title);
            });
            
            var table = $('#Lista').DataTable({
                    "scrollX"   : true,
                    "destroy"   : true, 
                    "pagingType": "numbers",
                    "processing": true,
                    "serverSide": true,
                    "ajax"      : "<?php echo constant('RUTA_URL');?>/rest-api/ClientesExtra.php?dtdatosGET="+<?=$propiedadID?>,
                columns: [
                    { "title": "ID"},
                    { "title": "Cliente"},
                    { "title": "Etiqueta"},
                    { "title": "Requerido"},                    
                    { "title": "Acciones"},
                ],
                columnDefs: [
                    {
                        "targets"   : [ 0, 1 ],
                        "visible"   : false,
                        "searchable": false
                    },
                    {
                        targets   : [ 2 ],
                        searchable: true,
                        orderable : false,
                        render: function(data, type, full, meta){
                            if(type === 'display'){
                                data = '<input class="form-control form-control-sm" type="text" id="nombre_'+full[4]+'" value="'+data+'"/>'; 
                            }
                            return data;
                        }
                    }, 
                    {
                        targets   : [ 3 ],
                        searchable: true,
                        orderable : false,
                        render: function(data, type, full, meta){
                            if(type === 'display'){
                                if(data==0){
                                    var options = '<option value="0" selected>No</option><option value="1">Si</option>'
                                }else{
                                    var options = '<option value="0">No</option><option value="1" selected>Si</option>'
                                }
                                data = '<select class="form-select form-select-sm" id="requer_'+full[4]+'">'+options+'</select>'; 
                            }
                            return data;
                            
                        }
                    }, 
                    {
                        targets   : [ 4 ],
                        searchable: true,
                        orderable : false,
                        render: function(data, type, full, meta){
                            if(type === 'display'){
                                data = '<button class="btn btn-outline-success btn-sm me-1 mb-1" title="Actualizar" type="button" onclick="ActualizarDato(' + data + ')"><span class="sr-only">Actualizar</span><i class="fa fa-check"></i></button><button class="btn btn-outline-warning btn-sm me-1 mb-1" title="Eliminar" type="button" onclick="EliminarDato(' + data + ')"><span class="sr-only">Eliminar</span><i class="fa fa-trash"></i></button>'; 
                            }
                            return data;
                        }
                    } 
                ],

                language: {
                    "decimal"   : "",
                    "emptyTable": "No hay información",
                    "info"      : "Viendo _START_ a _END_ de _TOTAL_ datos",
                    "infoEmpty" : "Viendo 0 to 0 of 0 datos",
                    "infoFiltered": "(Filtrado de _MAX_ total datos)",
                    "infoPostFix" : "",
                    "thousands"   : ",",
                    "lengthMenu"  : "Ver _MENU_ datos",
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
         
            table.columns().every(function () {
                var table = this;
                $('input', this.header()).on('keyup change', function () {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
            }); 

        }
        documentacionAdjunta();
        
    </script>

    <script>
        function EliminarDato(id) {
            var usuarioID = <?php echo $userID ?>;
            Swal.fire({
                title                 : '<strong>Eliminar datos Extra?</strong>',
                icon                  : 'info',
                html                  : 'Se eliminara y no podra ser recuperado!',
                showCancelButton      : true,
                focusConfirm          : false,
                confirmButtonText     : '<i class="fa fa-thumbs-up"></i> Eliminar!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
                cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
                cancelButtonAriaLabel : 'Thumbs down'
            }).then((result) => {
                if (result.value) {
                    var apiUrl='<?php echo constant('RUTA_URL'); ?>/rest-api/ClientesExtra.php'; 
                    var data = { 
                        datoID    : id, 
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
                                title: 'Dato eliminado!',
                                showConfirmButton: false,
                                timer: 2000
                            })
                            documentacionAdjunta(); 
                        }
                    }) 
                }
            })
        }

        function ActualizarDato(id) {
            var nombre = $("#nombre_"+id).val();
            var requer = $("#requer_"+id).val();
            var Accion    = 'Actualizar';  
            var rtaAccion = 'Actualizada!'; 
            var metodo    = 'PUT'; 
            var apiUrl='<?php echo constant('RUTA_URL'); ?>/rest-api/ClientesExtra.php'; 
            var data = { 
                formID    : id,
                etiqueta  : nombre,
                requerido : requer      
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
                        title: 'Dato '+ rtaAccion +'',
                        showConfirmButton: false,
                        timer: 2000
                    })                 
                }
            })
        }
    </script>