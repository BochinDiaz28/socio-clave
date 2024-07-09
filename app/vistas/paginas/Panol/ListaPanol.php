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
                       href="<?php echo constant('RUTA_URL');?>/panol/0">
                        <span class="fas fa-plus mr-1" data-fa-transform="shrink-3"></span>
                        <span class="text">Nuevo</span>
                    </a>
                </div>
            </div>
        </div>        
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="clientes">Seleccionar Cliente</label>
                <div class="col-sm-9">
                    <select class="form-select form-select-sm clienteSelect" 
                            id="clientes" onchange="LstPanol()">
                        <!--DINAMICO POR JS-->                       
                    </select>
                    <small>Seleccione el cliente para ver el inventario</small>
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
            <p class="fs--1">Productos de Pañol</p>
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
        $('.clienteSelect').select2();
        ListaClientes();
    }); 
    function ListaClientes()
    {  
        var empresaID = <?php echo $empresaID; ?>;
        var url       = '<?php echo constant('RUTA_URL');?>/rest-api/Clientes?clientesTodosGET='+empresaID;
        fetch(url)
        .then(response => response.json())
        .then(data => {
            $('#clientes').html("");
            var $select = $('#clientes');
                $select.append('<option value="0">Seleccionar Cliente</option>');
            $.each(data, function(i, item) {
                if(item.panol==1){
                    $select.append('<option value=' + item.id + '>' + item.nombre + '</option>');
                }
            });    
        });  
    }
    function LstPanol() {
        var clienteID = $('#clientes').val();
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
                "ajax": "<?php echo constant('RUTA_REST');?>/rest-api/Panol?dtPanolGET="+clienteID,
            columns: [
                { "title": "ID" },             
                { "title": "Codigo" },
                { "title": "Producto" },
                { "title": "T. Producto" },
                { "title": "Cantidad" },
                { "title": "Kit" },
                { "title": "Acciones" },
            ],
            columnDefs: [
                {
                    "targets"   : [ 0, 5 ],
                    "visible"   : false,
                    "searchable": false
                },
                {
                    targets: [ 5 ] ,
                    searchable: true,
                    orderable: false,
                    render: function(data, type, full, meta){
                        if(type === 'display'){
                            if(data==1){
                                data = '<button class="btn btn-outline-success btn-sm me-1 mb-1" title="Editar Kits" type="button" onClick="EditarKits(' + full[6] + ')"><span class="sr-only">Editar Kits</span><i class="fas fa-toolbox"></i></button>';
                            }else{
                                data='';
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
                            data = '<button class="btn btn-outline-primary btn-sm me-1 mb-1" title="Editar" type="button" onClick="EditarForm(' + data + ')"><span class="sr-only">Editar</span><i class="fa fa-edit"></i></button><button class="btn btn-outline-warning btn-sm me-1 mb-1" title="Eliminar" type="button" onclick="EliminarUsuario(' + data + ')"><span class="sr-only">Eliminar</span><i class="fa fa-trash"></i></button>';      
                        }
                        return data;
                    }
                    
                } 
            ],

            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Viendo _START_ a _END_ de _TOTAL_ Pañol",
                "infoEmpty": "Viendo 0 to 0 of 0 Pañol",
                "infoFiltered": "(Filtrado de _MAX_ total Pañol)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Ver _MENU_ Pañol",
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
    function EliminarUsuario(id) 
    {
        var usuarioID = <?php echo $userID ?>;
        Swal.fire({
            title                 : '<strong>Eliminar Producto?</strong>',
            icon                  : 'info',
            html                  : 'Se eliminara y no se le podran asignar a mas tareas!',
            showCancelButton      : true,
            focusConfirm          : false,
            confirmButtonText     : '<i class="fa fa-thumbs-up"></i> Eliminar!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
            if (result.value) {
                var apiUrl='<?php echo constant('RUTA_REST'); ?>/rest-api/Panol'; 
                var data = { 
                    panolID   : id, 
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
                            title: 'Producto eliminado!',
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
        window.location = "<?php echo constant('RUTA_URL');?>/lstpanol/";
    }

    function EditarForm(id){
        window.location = "<?php echo constant('RUTA_URL');?>/panol/"+id;
    }
    
    function EditarKits(id) {
        window.location = "<?php echo constant('RUTA_URL');?>/panolkits/"+id;
    }
</script>