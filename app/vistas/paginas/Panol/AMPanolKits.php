<?php require RUTA_APP . '/vistas/inc/header.php'; ?>
<?php require RUTA_APP . '/vistas/inc/menuLateral.php'; ?>
<?php 
    $empresaID  = $datos['empresaID'];    #|->EMPRESA LOGEADA
    $userID     = $datos['userID'];       #|->USUARIOS LOGEADO
    $panolID = $datos['panolID'];  #|->AGENTE QUE ESTOY CREANDO O EDITANDO
?>
<div class="content">
    <?php require RUTA_APP . '/vistas/inc/menuSuperior.php'; ?>
    <div class="card mb-3">
        <div class="card-body">
            <a class="btn btn-outline-primary btn-sm mr-1 mb-1" type="button" 
            href="<?php echo constant('RUTA_URL'); ?>/lstpanol">
                <span class="fas fa-arrow-alt-circle-left me-1" data-fa-transform="shrink-3"></span>
                Regresar a Lista
            </a>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Producto</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-sm-9">
                    <div class="form-check form-switch">
                        <input class="form-check-input" id="estado" type="checkbox" />
                        <label class="form-check-label" for="estado">es un Kit?</label>
                    </div>
                </div>
            </div>
            <hr>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="codigo">Codigo *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="codigo" placeholder="" aria-label="" value="" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="nombre">Producto *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="nombre" placeholder="" aria-label="" value="" />
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="tipo">Tipo de Producto</label>
                <div class="col-sm-9">
                    <select class="form-select form-select-sm sucursalSelect" id="tipo">
                        <option value="Manual">Manual</option>                      
                    </select>
                </div>
            </div>

            <?php  if ($panolID > 0){ $lblCant="Cantidad"; $disabled='disabled'; }else{ $lblCant="Cantidad Inicial *"; $disabled='';}?> 
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="cantidad"><?=$lblCant;?></label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="number" id="cantidad" placeholder="" aria-label="" value="" <?=$disabled?>/>
                </div>
            </div>

            <hr>
        
            <div class="form-group text-center">
                <?php  if ($panolID > 0){?> 
                    <button class="btn btn-outline-primary btn-sm me-1 mb-1" type="button" onclick="Controlar_Requeridos();">
                        <span class="fas fa-sd-card" data-fa-transform="shrink-3"></span> Actualizar
                    </button>
                <?php  }else{ $panolID=0; ?>
                    <button class="btn btn-outline-primary btn-sm me-1 mb-1" type="button" onclick="Controlar_Requeridos();">
                        <span class="fas fa-sd-card" data-fa-transform="shrink-3"></span> Guardar
                    </button>
                <?php  }?> 
            </div>
        </div>
    </div>
    <?php  if ($panolID > 0){?> 
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Elementos del Kit</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="producto">Producto </label>
                <div class="col-sm-9">
                    <select class="form-select form-select-sm sucursalSelect" id="producto">
                                      
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="cantArqueo">Cantidad *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="number" id="cantArqueo" placeholder="" aria-label="" value=""/>
                </div>
            </div>

            <hr>
        
            <div class="form-group text-center">
         
                <button class="btn btn-outline-primary btn-sm me-1 mb-1" type="button" 
                        onclick="ControlarElementos();"
                        id="miBoton">
                    <span class="fas fa-sd-card" data-fa-transform="shrink-3"></span> Agregar Elemento
                </button>
                
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
            <p class="fs--1">Arqueo de Kits</p>
        </div> 
    </div>
    <?php } ?>
</div>
<?php require RUTA_APP . '/vistas/inc/footer.php'; ?>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables-bs4/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables.net-responsive/dataTables.responsive.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>

<script>
    //ABM
    $(document).ready(function ()
    {
        var panolID  = <?php echo $panolID; ?>;
        var empresaID   = <?php echo $empresaID; ?>;
        if(panolID>0){
            var url ='<?php echo constant('RUTA_URL'); ?>/rest-api/Panol?panolGET='+panolID;
            fetch(url)
            .then(response => response.json())
            .then(data => {
                $.each(data, function(i, item) {
                    if(panolID==item.id){
                        $('#codigo').val(item.codigo);
                        $('#nombre').val(item.producto);
                        $('#cantidad').val(item.cantidad);
                        var checkbox = document.getElementById("estado");
                        if(item.combo==1){
                            checkbox.checked = true;                            
                        }else{
                            checkbox.checked = false;                            
                        }
                    } 
                });   
            });
            cargarProductos();
        }else{
            
        }    
        
    });
    function Controlar_Requeridos() 
    {
        var codigo    = document.querySelector('#codigo').value;
        var nombre = document.querySelector('#nombre').value;
        if( codigo==='' || nombre ==='' ){  //SI NO VALIDA CORRECTAMENTE TIRA CARTEL
            swal({
                type : 'error',
                title: 'Error!',
                text : 'Todos los datos son requeridos!'
            })
        } else { // CUANDO LOS CAMPOS SON CORRECTOS, EJECUTO AJAX
            Actualizar_Cliente();
        }    
    }
 
    function Actualizar_Cliente()
    {
        var userID    = <?php echo $userID ?>;
        var panolID   = <?php echo $panolID; ?>;
        var empresaID = <?php echo $empresaID; ?>;
        if(panolID==0)
        { 
            var Accion    = 'Crear';
            var rtaAccion = 'Creado!'; 
            var metodo    = 'POST'; 
        }else{
            var Accion    = 'Actualizar';  
            var rtaAccion = 'Actualizado!'; 
            var metodo    = 'PUT'; 
        }
       
        var codigo   = document.querySelector('#codigo').value;;
        var nombre   = document.querySelector('#nombre').value;
        var tipo     = document.querySelector('#tipo').value;
        var cantidad = document.querySelector('#cantidad').value;
        if(document.getElementById("estado").checked==true){ var activo=1; }else{ var activo=0;}
        Swal.fire({
            title: '<strong>Confirma '+Accion+'?</strong>',
            icon : 'info',
            html : 'subsector <b>'+nombre +'</b> <br/> ',
            showCancelButton : true,
            focusConfirm     : false,
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> '+ Accion +'!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
            if (result.value) {
                var apiUrl='<?php echo constant('RUTA_URL'); ?>/rest-api/Panol'; 
                var data = { 
                    empresaID : empresaID,
                    panolID   : panolID,
                    usuarioID : userID,
                    codigo    : codigo,
                    nombre    : nombre,
                    tipo      : tipo,
                    cantidad  : cantidad,
                    combo     : activo
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
                            title: 'Producto '+ rtaAccion +'',
                            showConfirmButton: false,
                            timer: 2000
                        })
                        setInterval(redireccion, 2000); 
                    }
                }) 

            }   
        })
    }

    function redireccion(){
        window.location = "<?php echo constant('RUTA_URL');?>/lstpanol";
    }
    //FIN ABM
    
</script>
<?php  if ($panolID > 0){?> 
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
                "ajax": "<?php echo constant('RUTA_REST');?>/rest-api/PanolKits?dtPanolKitsGET="+<?php echo $panolID; ?>,
            columns: [
                { "title": "ID" },                             
                { "title": "Codigo" },
                { "title": "Producto" },                
                { "title": "Cantidad" },
                { "title": "" },
            ],
            columnDefs: [
                {
                    "targets"   : [ 0 ],
                    "visible"   : false,
                    "searchable": false
                },
               
                
                {
                    targets: [ 4 ] ,
                    searchable: true,
                    orderable: false,
                    render: function(data, type, full, meta){
                        if(type === 'display'){
                            data = '<button class="btn btn-outline-warning btn-sm me-1 mb-1" title="Eliminar" type="button" onclick="EliminarUsuario(' + data + ')"><span class="sr-only">Eliminar</span><i class="fa fa-trash"></i></button>';
                        }
                        return data;
                    }
                }  
                
            ],

            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Viendo _START_ a _END_ de _TOTAL_ Elementos",
                "infoEmpty": "Viendo 0 to 0 of 0 Elementos",
                "infoFiltered": "(Filtrado de _MAX_ total Elementos)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Ver _MENU_ Elementos",
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

    function ControlarElementos() {
        var userID    = <?php echo $userID ?>;
        var panolID   = <?php echo $panolID; ?>;
        var empresaID = <?php echo $empresaID; ?>;
        var nombre = document.querySelector('#nombre').value;

        var Accion    = 'Agregar';
        var rtaAccion = 'Agregado!'; 
        var metodo    = 'POST'; 
       
        var producto   = document.querySelector('#producto').value;;
        var cantArqueo = document.querySelector('#cantArqueo').value;
      
        Swal.fire({
            title: '<strong>Confirma '+Accion+'?</strong>',
            icon : 'info',
            html : 'Elemento a <b>'+nombre +'</b> <br/> ',
            showCancelButton : true,
            focusConfirm     : false,
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> '+ Accion +'!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
            if (result.value) {
                var apiUrl='<?php echo constant('RUTA_URL'); ?>/rest-api/PanolKits'; 
                var data = { 
                    empresaID : empresaID,
                    panolID   : panolID,
                    usuarioID : userID,
                    producto  : producto,
                    cantArqueo: cantArqueo
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
                            title: 'Elemento '+ rtaAccion +'',
                            showConfirmButton: false,
                            timer: 2000
                        })
                        setInterval(redireccionAqui, 2000); 
                    }
                }) 

            }   
        })
    }

    function cargarProductos()
    {  
        var empresaID = <?php echo $empresaID; ?>;
        var subSucID  = 0;
        var url = '<?php echo constant('RUTA_URL');?>/rest-api/Panol?panolTodosGET='+empresaID;
        fetch(url)
        .then(response => response.json())
        .then(data => {
            $('#producto').html("");
            var $select = $('#producto');
            $select.append('<option value="0">Seleccionar Producto</option>');
            $.each(data, function(i, item) {
                if(item.combo==0){
                    if(subSucID==item.id){
                        $select.append('<option selected selected value=' + item.id + '>' + item.producto + '</option>');
                    }else{
                        $select.append('<option value=' + item.id + '>' + item.producto + '</option>');
                    }
                }
            });    
        }); 
        
    }

    function redireccionAqui(){
        var panolID   = <?php echo $panolID; ?>;
        window.location = "<?php echo constant('RUTA_URL');?>/panolkits/"+panolID;
    }

    function EliminarUsuario(id) 
    {
        var usuarioID = <?php echo $userID ?>;
        Swal.fire({
            title                 : '<strong>Eliminar Elemento?</strong>',
            icon                  : 'info',
            html                  : 'Se eliminara elemento del Kit!',
            showCancelButton      : true,
            focusConfirm          : false,
            confirmButtonText     : '<i class="fa fa-thumbs-up"></i> Eliminar!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
            if (result.value) {
                var apiUrl='<?php echo constant('RUTA_REST'); ?>/rest-api/PanolKits'; 
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
                            title: 'Elemento eliminado!',
                            showConfirmButton: false,
                            timer: 2000
                        })
                        setInterval(redireccionAqui, 2000); 
                    }
                }) 
            }
        })
    }

</script>
<?php } ?>