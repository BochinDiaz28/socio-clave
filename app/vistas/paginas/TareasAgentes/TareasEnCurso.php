<?php require RUTA_APP . '/vistas/inc/header.php'; ?>
<style>
.custom-card-border {
    border-color: #0C787B !important;
}
</style>
<?php require RUTA_APP . '/vistas/inc/menuLateral.php'; ?>
<?php
    $empresaID = $datos['empresaID']; #|-> EMPRESA LOGEADA
    $userID    = $datos['userID'];    #|-> USUARIOS LOGEADO
    $tareaID   = 0;
?>
<div class="content">
    <?php require RUTA_APP . '/vistas/inc/menuSuperior.php'; ?>
    <div class="row g-3 mb-3">
        <div class="col-xxl-6 col-xl-12">
            <div class="row g-3">
                <div class="col-12">
                    <div class="card overflow-hidden">
                        <div class="card-header position-relative">

                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <a class="btn btn-falcon-default btn-sm me-1 mb-1" href="<?=constant('RUTA_URL');?>/">
                                        <span class="fas fa-arrow-left me-1" data-fa-transform="shrink-3"></span>Inicio
                                    </a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <a class="btn btn-secondary btn-sm" href="<?=constant('RUTA_URL');?>/tareasasignadas" style="border-color: #0C787B; background-color:#0C787B;">Asignadas</a>
                                    <a class="btn btn-secondary btn-sm" href="<?=constant('RUTA_URL');?>/tareasencurso" style="border-color: #0C787B; background-color:#0C787B;">En curso</a>
                                    <a class="btn btn-secondary btn-sm" href="<?=constant('RUTA_URL');?>/tareasfinalizadas" style="border-color: #0C787B; background-color:#0C787B;">Finalizadas</a>
                                </div>
                            </div>
                        </div>
  
                        <div class="card-body">
                            
                            <div id="_enCurso"></div>
                        
                           
                            <input type="hidden" id="sucID"     value="0">
                            <input type="hidden" id="clienteID" value="0">
                            <input type="hidden" id="tareaIDx"  value="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalStock" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1" id="staticBackdropLabel"> Inventario</h4>
                    <p class="fs--2 mb-0">By Sistema Online</p>
                </div>
                <div class="p-4">
                    <div class="row">
                        <div class="table-responsive scrollbar">
                            <table class="table table-sm fs--1 mb-0 overflow-hidden"  
                                    id="SociosLista"                            
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
<?php require RUTA_APP . '/vistas/inc/footer.php'; ?>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables-bs4/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables.net-responsive/dataTables.responsive.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/he/1.2.0/he.min.js"></script>
<script>
    $(document).ready(function ()
    { 
        ListaClientes();
    });

    function ListaClientes()
    {  
        var userID = <?php echo $userID; ?>;
        var url    = '<?php echo constant('RUTA_URL');?>/rest-api/Agentes?agentesUserGET='+userID;
        fetch(url)
        .then(response => response.json())
        .then(data => {  //por aca leo los resultados de la consulta
            $.each(data, function(i, item) {
                $('#clienteID').val(item.id);
                $('#_Nombre').html(item.nombre);
            }); 
            MisCurso();
        });  
    }
    function MisCurso() {     
        var agenteID = $('#clienteID').val();       
        var url = '<?php echo constant('RUTA_URL');?>/rest-api/AgentesRetails?dtagentesRetailCursoGET=' + agenteID;
        var html = '';
        fetch(url)
            .then(response => response.json())
            .then(data => {
                html = '<div class="row">';
                let promises = [];
                
                $.each(data, function(i, item) {                                
                    if (item.checklist == 1) {
                        var checklist = '<button class="btn btn-outline-danger btn-sm me-1 mb-1" type="button" onclick="modalInventario(' + item.id + ',' + item.idcliente + ');"><span class="fas fa-list" data-fa-transform="shrink-3"></span> Controlar Inventario</button>';
                    } else {
                        var checklist = '';
                    }

                    promises.push(
                        ListaTemporal(item.id).then(rtaProductos => {
                            html += '<div class="card border h-100 custom-card-border mb-3"><div class="card-body"><div class="col-md-12 h-100">' +
                                '   <div class="row">' +
                                '      <div class="col-12">' +
                                '          <div class="media-body position-relative pl-3">' +
                                '              <h6 class="mt-3 mt-sm-0">' + item.tarea + '</h6>' +
                                '              <p class="fs--1 mb-0"><b>' + item.sucursal + '</b></p>' +                                             
                                '              <p class="fs--1 mb-0">' + item.ubicacion + '</p>' +      
                                '              <p class="fs--1 mb-0">Fecha  : <b>'+InvertirFechaCorta(item.fecha_sol)+'</b></p>'+               
                                '              <p class="fs--1 mb-0">Limite desde  : <b>' + item.hora_inicio + '</b> hasta: <b>' + item.hora_final + '</b></p>' +
                                '              <p class="fs--1 mb-0">' + he.decode(item.nota) + '</p>' +
                                '              ' + checklist + '' +                    
                                '              <button class="btn btn-secondary btn-sm me-1 mb-1" type="button" onclick="FinalizarTareas(' + item.id + ');" style="border-color: #0C787B; background-color:#0C787B;"><span class="fas fa-check" data-fa-transform="shrink-3"></span> Finalizar</button>' +
                                '              <hr class="border-dashed border-bottom-0">' +
                                '              <div id="_tempProductos">' + rtaProductos + '</div>' +                                
                                '          </div>' +                    
                                '       </div>' +
                                '   </div>' +
                                '</div></div></div>';
                        })
                    );
                });

                Promise.all(promises).then(() => {
                    html += '</div>';
                    $('#_enCurso').html(html);
                });
            });
    }
    
    function FinalizarTareas(tareaID) {
        var userID    = <?php echo $userID; ?>;
        var empresaID = <?php echo $empresaID; ?>;
        var agenteID  = $('#clienteID').val();
        var exito     = 1; 
        var Accion    = 'Finalizar';  
        var rtaAccion = 'Finalizada!'; 
        var metodo    = 'PUT';
        Swal.fire({
            title: '<strong>Confirma '+Accion+'?</strong>',
            icon : 'info',
            html : '<input type="file" id="fileInput" accept="image/*" onchange="convertToBase64()"/>'+
                   '<img id="previewImage" style="display: none; max-width: 300px; max-height: 300px;">'+
                   '<input class="form-control form-control-sm" type="text" id="comentario" placeholder="Su comentario"/>',
            showCancelButton      : true,
            focusConfirm          : false,
            confirmButtonText     : '<i class="fa fa-thumbs-up"></i> '+ Accion +'!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
            /*tomo nombre del archivo */
            const inputElement = document.querySelector('#fileInput');
            const selectedF    = inputElement.files[0];
            const original     = selectedF.name;
            const base64Image  = selectedFile && selectedFile instanceof File ? previewImage.src : '';
            var comentario     = $('#comentario').val();
            if (result.value) {
                //SI NO SUBIO IMAGEN REBOTO LA CARGA
                if (!selectedFile) {
                    alert('Por favor, selecciona una imagen primero.');
                    return;
                }
                var apiUrl='<?php echo constant('RUTA_URL'); ?>/rest-api/AgentesTareas.php'; 
                var data = { 
                    usuarioID  : userID,
                    tareaID    : tareaID,              
                    empresaID  : empresaID,
                    agenteID   : agenteID,
                    estado     : 4,
                    Archivo    : base64Image,
                    original   : original,
                    comentario : comentario,
                    exito      : exito
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

    function recarga(){
        window.location = "<?php echo constant('RUTA_URL');?>/";
    }

    function modalInventario(tareaID,clienteID) {
        $('#tareaIDx').val(tareaID);
        $('#SociosLista thead th').each(function () {
            var title = $(this).text();
            $(this).html(title);
        });
                            
        var table = $('#SociosLista').DataTable({
                "destroy"   : true, 
                "scrollX"   : true,
                "pagingType": "numbers",
                "processing": true,
                "serverSide": true,
                "ajax": "<?php echo constant('RUTA_URL');?>/rest-api/Panol.php?dtPanolGET="+clienteID,
            columns: [
                { "title": "ID" },
                { "title": "SKU" },
                { "title": "Producto" },
                { "title": "Tipo" },
                { "title": "Existencias" },
                { "title": "Combo" },
                { "title": "Acciones" },
            ],
            columnDefs: [
                {
                    "targets": [ 0,3,4,5 ],
                    "visible": false,
                    "searchable": false
                },
                {
                    targets: [ 6 ] ,
                    searchable: true,
                    orderable: false,
                    render: function(data, type, full, meta){
                        if(type === 'display'){
                            data = '<button class="btn btn-outline-primary btn-sm me-1 mb-1" title="Editar" type="button" onClick="AgregarCantidad(' + data + ')"><span class="sr-only">Editar</span><i class="fa fa-check"></i></button>';      
                        }
                        return data;
                    }  
                } 
            ],

            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Viendo _START_ a _END_ de _TOTAL_ productos",
                "infoEmpty": "Viendo 0 to 0 of 0 productos",
                "infoFiltered": "(Filtrado de _MAX_ total productos)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Ver _MENU_ productos",
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
            //botones de excel, pdf e imprimir
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

        $('#modalStock').modal('show');
    }

    function AgregarCantidad(productoID) {
        var tareaID =  $('#tareaIDx').val();
        $('#modalStock').modal('hide');
        var rtaAccion  = 'Agregado!'; 
        var metodo     = 'POST'; 
        Swal.fire({
                title: "Cantidad ",
                html:"<input id='cantidad' type='number' class='swal2-input'>",
                showCancelButton  : true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor : '#d33',
                confirmButtonText : 'Continuar!',
                cancelButtonText  : 'No!',
            }).then((result) => {
                var cantidad = $("#cantidad").val();
                if(cantidad===''){cantidad=1;}
                var apiUrl='<?php echo constant('RUTA_URL');?>/rest-api/PanolControl.php'; 
                var data = {
                    productoID : productoID,
                    tareaID    : tareaID,
                    Cantidad   : cantidad,
                    arqueo     : 1
                } 

                if (result.value) {
                    fetch(apiUrl,{ 
                        method : metodo,  
                        headers: {'Content-type' : 'application/json'},
                        body   : JSON.stringify(data) 
                    })
                    .then(response => response.json() )
                    .then(data => {
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
                                timer: 1000
                            })
                            setInterval(recarga, 1000); 
                        }
                    }); 
                   
                }
            });	
    }

    function ListaTemporal(tareaID) {
        return new Promise((resolve, reject) => {
            var url = '<?php echo constant('RUTA_URL');?>/rest-api/PanolControl.php?panolControlGET=' + tareaID;
            var html = '';
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    html = '<div class="row">';
                    $.each(data, function(i, item) {
                        html += '<div class="col-3"><h6 class="mt-3 mt-sm-0">' + item.codigo + '</h6></div>' +
                            '  <div class="col-4"><p class="fs--1 mb-0">' + item.producto + '</p></div>' +                                             
                            '  <div class="col-3"><p class="fs--1 mb-0">' + item.cantidad + '</p></div>' +
                            '  <div class="col-2"><button class="btn btn-outline-danger btn-sm me-1 mb-1" type="button" onclick="QuitarProducto(' + item.id + ');"><span class="fas fa-ban" data-fa-transform="shrink-3"></span></button></div>';
                    }); 
                    html += '</div>';
                    resolve(html);
                })
                .catch(error => reject(error));
        });
    }
    function QuitarProducto(productoID) {
        var usuarioID = <?php echo $userID ?>;
        Swal.fire({
            title                 : '<strong>Eliminar Producto?</strong>',
            icon                  : 'info',
            html                  : 'Se eliminara de la lista de control!',
            showCancelButton      : true,
            focusConfirm          : false,
            confirmButtonText     : '<i class="fa fa-thumbs-up"></i> Eliminar!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
            if (result.value) {
                var apiUrl='<?php echo constant('RUTA_REST'); ?>/rest-api/PanolControl.php'; 
                var data = { 
                    panolID   : productoID, 
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
</script>

<script>
    let selectedFile;
    function convertToBase64() {
        const fileInput = document.getElementById('fileInput');
        const previewImage = document.getElementById('previewImage');
        selectedFile = fileInput.files[0];
        const reader = new FileReader();
        reader.onload = function() {
            previewImage.src = reader.result;
            previewImage.style.display = 'block';
        };
        if (selectedFile) {
            reader.readAsDataURL(selectedFile);
        }
    }
</script>
