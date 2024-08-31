<?php require RUTA_APP . '/vistas/inc/header.php'; ?>
<style>
.custom-card-border {
    border-color: #0C787B !important;
}
.btn-secondary{
    background-color:#0C787B;
    border-color: #0C787B !important;
}

/* Oculta el input de tipo file */
/*
#fileInput {
    display: none;
}
*/
[name="fileInput"] {
    display: none;
}
/* Estilo para el botón personalizado */
.custom-file-upload {
    display: inline-block;
    padding: 10px 10px; /* Sin relleno */
    cursor: pointer;
    background-color: #fff;
    color: #545454;
    border-radius: 5px;
    font-size: 16px;
    font-weight: 600;
    transition: background-color 0.3s;
    border: 2px; /* Ancho del borde */
    border-style:  dotted; /* Estilo de borde personalizado */
    border-color: #0C787B; /* Colores del borde en orden: top, right, bottom, left */
    width: 100%;
}

.custom-file-upload:hover {
    background-color: #095a5c;
    border-color: #095a5c; /* Colores alternativos para el hover */
    color: white;
}

.custom-file-upload i {
    margin-right: 8px;
    font-size: 18px;
}

</style>
<style>
/* Estilo del contenedor */
#interactive.viewport {
    position: relative;
    width: 100%;
    height: 100%;
    max-width: 600px;
    max-height: 400px;
    margin: auto;
    border: 2px solid #0C787B; /* Borde del contenedor */
    border-radius: 10px;
    overflow: hidden;
}

/* Estilo de la barra láser */
.scanner-laser {
    position: absolute;
    width: 80%; /* Ajusta el ancho de la barra láser */
    height: 2px;
    background: red;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    animation: laser 0.5s infinite;
}

  /* Animación de la barra láser */
@keyframes laser {
    0% {
      opacity: 0;
    }
    50% {
      opacity: 1;
    }
    100% {
      opacity: 0;
    }
}

/* Estilo de las esquinas para fijar la posición */
.scanner-corner {
    position: absolute;
    width: 20px;
    height: 20px;
    border: 2px solid #0C787B;
}

/* Posiciones de las esquinas */
.corner-top-left {
    top: 10px;
    left: 10px;
    border-top-left-radius: 10px;
}

.corner-top-right {
    top: 10px;
    right: 10px;
    border-top-right-radius: 10px;
}

.corner-bottom-left {
    bottom: 10px;
    left: 10px;
    border-bottom-left-radius: 10px;
}

.corner-bottom-right {
    bottom: 10px;
    right: 10px;
    border-bottom-right-radius: 10px;
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
                                    <a id="linkTomar" class="link-dark active" href="<?=constant('RUTA_URL');?>/tomartarea" onclick="setActiveMenu('linkTomar')"><span class="text-dark poppins-bold">Tomar</span></a>
                                    <a id="linkAsignada" class="link-dark" href="<?=constant('RUTA_URL');?>/tareasasignadas" onclick="setActiveMenu('linkAsignada')" ><span class="text-dark poppins-bold">Asignadas</span></a>
                                    <a id="linkCurso" class="link-dark" href="<?=constant('RUTA_URL');?>/tareasencurso" onclick="setActiveMenu('linkCurso')" >En curso</a>
                                    <a id="linkFinalizada" class="link-dark" href="<?=constant('RUTA_URL');?>/tareasfinalizadas" onclick="setActiveMenu('linkFinalizada')" ><span class="text-dark poppins-bold">Finalizadas</span></a>
                                </div>
                            </div>
                        </div>
  
                        <div class="card-body">
                            <div id="_enCurso"></div>
                            <input type="hidden" id="sucID"     value="0">
                            <input type="hidden" id="clienteID" value="0">
                            <input type="hidden" id="tareaIDx"  value="0">
                            <input type="hidden" id="formulario" value="0">
                            <!--GEO POS NAVEGADOR-->
                            <input type="hidden" id="latitude" value="0">
                            <input type="hidden" id="longitude" value="0">
                        </div>
                        <div class="ms-2 me-2">
                            <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                                <div class="bg-danger me-3 icon-item"><span class="fas fa-exclamation-circle text-white fs-3"></span></div>
                                <p class="mb-0 flex-1 fs--2 poppins-light">Recuerda que cada tarea debe cumplirse en la temporalidad que se te indicó, de lo contrario, esta tarea se cerrará. En caso que alguna tarea haya sigo asignada por error, ponte en contacto con tu supervisor/a.</p>
                            </div>
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

<div class="modal fade" id="modalQR" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1" id="staticBackdropLabel"> Leer codebar</h4>
                    <p class="fs--2 mb-0">By Sistema Online</p>
                </div>
                <div class="p-4">
                    <div class="row">
                        <video id="camera" width="300" height="300" style="display:none;"></video>
                        <canvas id="canvas" width="300" height="300" style="display:none;"></canvas>
                        <div id="interactive" class="viewport"></div> <!-- Contenedor de QuaggaJS -->

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>

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
        .then(data => {
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
        var clienteID = 0;
        var FormExtra = 0;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data) && data.length > 0) {
                    html = '<div class="row">';
                
                    let promises = [];
                    
                    $.each(data, function(i, item) {                                
                        var dropZone = '<label for="fileInput_'+item.id+'" class="custom-file-upload"><i class="far fa-file-image"></i> * Tomar Foto</label><input type="file" name="fileInput" id="fileInput_'+item.id+'" accept="image/*" onchange="convertToBase64('+item.id+')" capture="user"/>'+
                                    '<img id="previewImage_'+item.id+'" style="display: none; max-width: 300px; max-height: 300px;">'+
                                    '<br>'+
                                    '<input class="form-control form-control-sm" type="text" id="comentario_'+item.id+'" placeholder="Su comentario"/>';
                        if (item.checklist == 1) {
                            var checklist = '<button class="btn btn-outline-danger btn-sm me-1 mb-1" type="button" onclick="modalInventario(' + item.id + ',' + item.idcliente + ');"><span class="fas fa-list" data-fa-transform="shrink-3"></span> C. Inventario</button><button class="btn btn-outline-success btn-sm me-1 mb-1" type="button" onclick="modalQR(' + item.id + ',' + item.idcliente + ');">Escanear <span class="fas fa-qrcode" data-fa-transform="shrink-3"></span></button>';
                            
                        } else {
                            var checklist = '';
                        }
                        if(item.foto_final==1){
                            var fotoFinal =dropZone;
                        }else{
                            var fotoFinal ='<input class="form-control form-control-sm" type="text" id="comentario" placeholder="Su comentario"/>';
                        }
                        clienteID = item.idcliente;
                        FormExtra = item.formulario;
                        $('#formulario').val(FormExtra);
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
                                    '              <br>'+ 
                                    '              '+fotoFinal+''+                   
                                    '              <br>'+
                                    '              <div class="row"><div class="col-12"><div class="table-responsive scrollbar"><table class="table table-sm fs--1 mb-0 overflow-hidden" id="ListaTmp"style="width:100%"><thead class="bg-200 text-900"></thead></table></div></div></div>'+ 
                                    '              <button id="iniciarBtn_'+item.id+'" class="btn btn-secondary btn-sm me-1 mb-1" type="button" onclick="ControRequeridos(' + item.id + ');" style="border-color: #0C787B; background-color:#0C787B;"><span class="fas fa-check" data-fa-transform="shrink-3"></span> Finalizar Tarea</button>' +
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
                        if(FormExtra==1){
                            documentacionAdjunta(clienteID);
                        }
                    });
                } else {
                    html='<div class="row"><p class="fs--1 mb-0"><b>En este momento no hay tareas en curso</b></p></div>';
                    $('#_enCurso').html(html);
                }
            });
    }
    
    function ControRequeridos(tareaID) {
        CheckGeo();
        var fotoFinal = 0;
        var checkList = 0;
        var url       = '<?=constant('RUTA_URL');?>/rest-api/Tareas.php?tareaID='+tareaID;
        fetch(url)
        .then(response => response.json())
        .then(data => {
            $.each(data, function(i, item) {
                fotoFinal= item.foto_final;
            }); 
            if(fotoFinal==1){
                /* TOMO NOMBRE DEL ARCHIVO */
                const inputElement = document.querySelector("#fileInput_"+tareaID);
                const selectedF    = inputElement.files[0];
                if (!selectedF) {
                    Swal.fire({
                        type : 'info',
                        icon : 'info',
                        title: 'La tarea requiere que envie una foto!',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    return;
                }else{
                    console.log("Foto Seleccionada ok")
                    /* SI NO SUBIO IMAGEN REBOTO LA CARGA */
                }          
            }
            
            /* OTROS CAMPOS DE FORM EXTRA SI EXISTEN */
            FinalizarTareas(tareaID,fotoFinal)
        });  
    }

    function FinalizarTareas(tareaID,fotoFinal) {
        /* RECUPERAMOS BOTON */
        var btn = document.getElementById('iniciarBtn_' + tareaID);
        if(fotoFinal==1){
            const inputElement = document.getElementById('fileInput_' + tareaID);
            const selectedF = inputElement.files[0];
            const previewImage = document.getElementById('previewImage_' + tareaID);
            var original = selectedF ? selectedF.name : '';           
            var base64Image = selectedFile && selectedFile instanceof File ? previewImage.src : '';
            //comentario de la foto
            var comentario = $('#comentario_'+tareaID).val();
        }else{
            var base64Image = '';
            var original    = '';
            var comentario  = '';
        }
        
        var formulario = $('#formulario').val();
        var dataExtra = []; // Array para almacenar los datos
        if(formulario==1){ 
            $('#ListaTmp input, #ListaTmp select').each(function() {
                var elementID = $(this).attr('id');  // ID del input o select
                var elementValue = $(this).val();    // Valor ingresado o seleccionado
                dataExtra.push({
                    campoID: elementID,
                    valor: elementValue
                });
            });
            console.log(dataExtra);
        }else{
                console.log("Cliente sin datos extra");
        }
        //RECUPERAR GEO
        var lat = $('#latitude').val();
        var lon = $('#longitude').val();

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
            html : '<b>Finalizando Tarea</b>',
            showCancelButton      : true,
            focusConfirm          : false,
            confirmButtonText     : '<i class="fa fa-thumbs-up"></i> '+ Accion +'!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
            
            if (result.value) {
                /* DESACTIVAMOS BOTON Y PONEMOS SPINER */
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Finalizando tarea...';
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
                    exito      : exito,
                    formulario : formulario,
                    dataExtra  : dataExtra,
                    lat        : lat,
                    lon        : lon 
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
                        /* ACTIVAMOS BOTON Y PONEMOS ICONO Y TEXTO */
                        btn.disabled = false;
                        btn.innerHTML = '<span class="fas fa-check" data-fa-transform="shrink-3"></span> Finalizar Tarea';
                        setInterval(recarga, 2000); 
                    }
                }) 

            }   
        })
    }

    function recarga(){
        window.location = "<?php echo constant('RUTA_URL');?>/tareasencurso";
    }

    function modalQR(tareaID,clienteID) {
        IniciaLector(tareaID,clienteID);
        $('#modalQR').modal('show');
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
                title: "Control Inventario",
                html: `<form id="inventoryForm">
                            <div class="form-group">
                                <input id="cantidad" type="number" class="swal2-input" placeholder="Ingrese la cantidad" min="1" required>
                            </div>
                            <div class="form-group">
                                <input id="detalle" type="text" class="swal2-input" placeholder="Detalle" required>
                            </div>
                            <div class="form-group">
                                <input id="lote" type="text" class="swal2-input" placeholder="Lote" required>
                            </div>
                        </form>`,
                showCancelButton  : true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor : '#d33',
                confirmButtonText : 'Continuar!',
                cancelButtonText  : 'No!',
            }).then((result) => {
                var cantidad = $("#cantidad").val();
                var detalle  = $("#detalle").val();
                var lote     = $("#lote").val();
                if(cantidad===''){cantidad=1;}
                var apiUrl='<?php echo constant('RUTA_URL');?>/rest-api/PanolControl.php'; 
                var data = {
                    productoID : productoID,
                    tareaID    : tareaID,
                    Cantidad   : cantidad,
                    arqueo     : 1,
                    detalle    : detalle,
                    lote       : lote
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
                            '  <div class="col-4"><div class="row"><p class="fs--1 mb-0">' + item.producto + '</p></div><div class="row"><p class="fs--2 mb-0">'+item.dato1+'</p></div><div class="row"><p class="fs--2 mb-0">'+item.dato2+'</p></div></div>' +                                             
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
    function convertToBase64(tareaID) {
        const fileInput = document.getElementById('fileInput_'+tareaID+'');
        const previewImage = document.getElementById('previewImage_'+tareaID+'');      
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

<script>

function IniciaLector(tareaID, clienteID) {
    //captureFoto();
    const video = document.getElementById("camera");
    const canvasElement = document.getElementById("canvas");
    const canvas = canvasElement.getContext("2d");
    let isBarcodeProcessed = false; // Flag para evitar lecturas múltiples

    // Acceder a la cámara
    navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } }).then((stream) => {
        video.srcObject = stream;
        video.setAttribute("playsinline", true); // Requerido para que funcione en iOS
        video.play();

        // Configurar QuaggaJS para usar el mismo stream de video
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream", // Cambiado a LiveStream
                target: document.querySelector('#interactive'), // QuaggaJS ahora usa su propio contenedor
                constraints: {
                    facingMode: "environment"
                }
            },
            locator: {
                patchSize: "medium",
                halfSample: true
            },
            numOfWorkers: 4,
            decoder: {
                readers: [
                    "code_128_reader",        // Código de barras Code 128
                    "ean_reader",             // Código de barras EAN-13
                    "ean_8_reader",           // Código de barras EAN-8
                    "code_39_reader",         // Código de barras Code 39
                    "code_39_vin_reader",     // Código de barras VIN
                    "upc_reader",             // Código de barras UPC-A
                    "upc_e_reader",           // Código de barras UPC-E
                    "i2of5_reader",           // Código de barras Interleaved 2 of 5
                    "2of5_reader",            // Código de barras Standard 2 of 5
                    "code_93_reader"          // Código de barras Code 93
                ]
            },
            locate: true
        }, function(err) {
            if (err) {
                console.log(err);
                return;
            }
            Quagga.start();
        });

        Quagga.onDetected(function(data) {
            if (!isBarcodeProcessed) { // Solo procesar si no ha sido procesado
                isBarcodeProcessed = true; // Marcar como procesado
                $('#modalQR').modal('hide');
                console.log("Código de barras detectado:", data.codeResult.code);
                
                // Llamar a la función que maneja el código detectado
                RecuperarProducto(tareaID, clienteID, data.codeResult.code);

                // Detener Quagga después de leer el código
                Quagga.stop();
            }
        });

        requestAnimationFrame(tick); // Inicia la lectura de QR con jsQR
    });

    function tick() {
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            canvasElement.height = video.videoHeight;
            canvasElement.width = video.videoWidth;
            canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
            const imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: "dontInvert",
            });

            if (code && !isBarcodeProcessed) {
                isBarcodeProcessed = true; // Marcar como procesado
                $('#modalQR').modal('hide');
                console.log("Código QR detectado:", code.data);
                
                // Llamar a la función que maneja el código detectado
                RecuperarProducto(tareaID, clienteID, code.data);
            }
        }
        requestAnimationFrame(tick); // Sigue el bucle de captura para jsQR
    }
}

function RecuperarProducto(tareaID, clienteID, codigo) {
    $('#tareaIDx').val(tareaID);
    //alert("Buscando producto..."+codigo);
    var url = '<?php echo constant('RUTA_URL');?>/rest-api/Panol.php?clienteGET=' + clienteID + '&codigoGET=' + codigo;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la solicitud: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            // Verifica si la respuesta contiene datos
            if (Array.isArray(data) && data.length > 0) {
                $.each(data, function(i, item) {
                    //alert(item.producto);  
                    AgregarCantidad(item.id);
                });
            } else {
                // Muestra alerta si no se encontraron resultados
                alert("No se encontró ningún producto con el código: " + codigo);
            }
        })
        .catch(error => {
            // Muestra alerta si hay un error en la solicitud
            alert("Error al buscar producto: " + error.message);
        });
}

//FUNCION PARA CONTROLAR SI LA CAMARA ESTA PERMITADA...
function captureFoto() {
    // Solicitar acceso a la cámara
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(function(stream) {
            // Acceso concedido
            console.log('La cámara está activa.');
            // Detener la cámara después de verificar que está activa
            stream.getTracks().forEach(track => track.stop());
        })
        .catch(function(error) {
            // Manejo de errores y permisos denegados
            console.error('Error al acceder a la cámara: ', error);
            alert('No se pudo acceder a la cámara. Por favor, permite el acceso a la cámara.');
        });
}

function documentacionAdjunta(clienteID) {
    $('#ListaTmp thead th').each(function () {
        var title = $(this).text();
        $(this).html(title);
    });
    
    var table = $('#ListaTmp').DataTable({
        "scrollX"   : true,
        "destroy"   : true, 
        "pagingType": "numbers",
        "processing": true,
        "serverSide": true,
        "searching" : false, // Ocultar buscador
        "paging"    : false, // Ocultar paginador
        "ajax"      : "<?php echo constant('RUTA_URL');?>/rest-api/ClientesExtra.php?dtdatosGET="+clienteID,
        columns: [
            { "title": "ID"},
            { "title": "Cliente"},
            { "title": "Datos extras solicitados"},
            { "title": "Requerido"},
            { "title": "T. de Dato"},                    
            { "title": "Acciones"},
        ],
        columnDefs: [
            {
                "targets"   : [ 0, 1, 3, 4, 5 ],
                "visible"   : false,
                "searchable": false
            },
            
            {
                
                targets   : [ 2 ],
                searchable: true,
                orderable : false,
                render: function(data, type, full, meta){
                    if(type === 'display'){
                        if(full[3]==0){
                            if(full[4]=='texto'){ var entrada = '<input class="form-control form-control-sm" type="text" id="'+full[5]+'" value=""/>'}
                            if(full[4]=='numero'){ var entrada = '<input class="form-control form-control-sm" type="number" id="'+full[5]+'" value=""/>'}
                            if(full[4]=='si-no'){ var entrada = '<select class="form-select form-select-sm" id="'+full[5]+'"><option value="0" selected>No</option><option value="1">Si</option></select>'}
                            data = '<label for="'+full[5]+'" class="form-label">'+data+'</label>'+entrada; 
                        }else{
                            data='';
                       }
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
                        var options = data == 0 ? '<option value="0">No</option>' : '<option value="1" selected>Si</option>';
                        data = '<select class="form-select form-select-sm" id="requer_'+full[5]+'" disabled>'+options+'</select>'; 
                    }
                    return data;
                }
            }
        ],
        language: {
            "decimal"   : "",
            "emptyTable": "No hay información",
            "info"      : "Viendo _START_ a _END_ de _TOTAL_ extras",
            "infoEmpty" : "Viendo 0 to 0 of 0 extras",
            "infoFiltered": "(Filtrado de _MAX_ total extras)",
            "infoPostFix" : "",
            "thousands"   : ",",
            "lengthMenu"  : "Ver _MENU_ extras",
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
}

/*GEO POS NAVEGADOR*/
function CheckGeo() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert ("La geolocalización no es soportada por este navegador.");
    }
}

function showPosition(position) {
    $('#latitude').val(position.coords.latitude);
    $('#longitude').val(position.coords.longitude);
    console.log("Latitud:", position.coords.latitude, "Longitud:", position.coords.longitude);
}

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            alert ("El usuario denegó la solicitud de geolocalización.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert ("La información de la ubicación no está disponible.");
            break;
        case error.TIMEOUT:
            alert ("La solicitud para obtener la ubicación ha expirado.");
            break;
        case error.UNKNOWN_ERROR:
            alert ("Se ha producido un error desconocido.");
            break;
    }
}
</script>
