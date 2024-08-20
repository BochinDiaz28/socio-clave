<?php require RUTA_APP . '/vistas/inc/header.php'; ?>
<style>
.custom-card-border {
    border-color: #0C787B !important;
}
.btn-secondary{
    background-color:#0C787B;
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
                                    <a id="linkTomar" class="link-dark active" href="<?=constant('RUTA_URL');?>/tomartarea" onclick="setActiveMenu('linkTomar')">Tomar</a>
                                    <a id="linkAsignada" class="link-dark" href="<?=constant('RUTA_URL');?>/tareasasignadas" onclick="setActiveMenu('linkAsignada')" >Asignadas</a>
                                    <a id="linkCurso" class="link-dark" href="<?=constant('RUTA_URL');?>/tareasencurso" onclick="setActiveMenu('linkCurso')" >En curso</a>
                                    <a id="linkFinalizada" class="link-dark" href="<?=constant('RUTA_URL');?>/tareasfinalizadas" onclick="setActiveMenu('linkFinalizada')" >Finalizadas</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                           
                            <div id="_MisPendientes"></div>
                                
                            <input type="hidden" id="sucID"     value="0">
                            <input type="hidden" id="clienteID" value="0">
                            <input type="hidden" id="tareaIDx" value="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require RUTA_APP . '/vistas/inc/footer.php'; ?>
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
            MisPendientes();
        });  
    }

    function MisPendientes() {     
        var agenteID = $('#clienteID').val();       
        var url     ='<?php echo constant('RUTA_URL');?>/rest-api/AgentesRetails?dtagentesRetailPendietesGET='+agenteID;
        var html    = '';
        fetch(url)
        .then(response => response.json())
        .then(data => {
            html='<div class="row">';
            $.each(data, function(i, item) {                
                if(item.checklist==1){
                    var checklist = '<p class="fs--1 mb-0">*<b> Requiere control de inventario</b></p>';
                }else{
                    var checklist ='';
                }
                html+='<div class="card border h-100 custom-card-border mb-3"><div class="card-body"><div class="col-md-12 h-100">'+
                    '   <div class="row">'+
                    '      <div class="col-12">'+
                    '          <div class="media-body position-relative pl-3">'+
                    '              <h6 class="mt-3 mt-sm-0 poppins-medium">'+item.tarea+'</h6>'+
                    '              <p class="fs--1 mb-0"><b>'+item.sucursal+'</b></p>'+                                             
                    '              <p class="fs--1 mb-0">'+item.ubicacion+'</p>'+                                     
                    '              <p class="fs--1 mb-0">Fecha  : <b>'+InvertirFechaCorta(item.fecha_sol)+'</b></p>'+
                    '              <p class="fs--1 mb-0">Limite desde  : <b>'+item.hora_inicio+'</b> hasta: <b>'+ item.hora_final +'</b></p>'+
                    '              <p class="fs--1 mb-0">'+he.decode(item.nota)+'</p>'+
                    '              '+checklist+''+ 
                    '              <button class="btn btn-secondary btn-sm me-1 mb-1" type="button" onclick="IniciarTareas('+item.id+');" style="border-color: #0C787B; background-color:#0C787B;"><span class="fas fa-check" data-fa-transform="shrink-3"></span> Iniciar</button>'+                    
                    '          </div>'+
                    '       </div>'+
                    '   </div>'+
                    '</div></div></div>';
            }); 
            html+='</div>';
            $('#_MisPendientes').html(html);
        });
    }

    
    function IniciarTareas(tareaID) {
        var userID    = <?php echo $userID; ?>;
        var empresaID = <?php echo $empresaID; ?>;
        var agenteID  = $('#clienteID').val(); 
        var Accion    = 'Iniciar';  
        var rtaAccion = 'Iniciada!'; 
        var metodo    = 'PUT';
        Swal.fire({
            title: '<strong>Confirma '+Accion+'?</strong>',
            icon : 'info',
            html : '<input type="file" id="fileInput" accept="image/*" onchange="convertToBase64()"/>'+
                   '<img id="previewImage" style="display: none; max-width: 300px; max-height: 300px;">'+
                   '<input class="form-control form-control-sm" type="text" id="comentario" placeholder="Su comentario"/>',
            showCancelButton : true,
            focusConfirm     : false,
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> '+ Accion +'!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
            //SI NO SUBIO IMAGEN REBOTO LA CARGA
            if (!selectedFile) {
                alert('Por favor, selecciona una imagen primero.');
                return;
            }
            /*tomo nombre del archivo */
            const inputElement = document.querySelector('#fileInput');
            const selectedF = inputElement.files[0];
            const original     = selectedF.name;
            const base64Image = selectedFile && selectedFile instanceof File ? previewImage.src : '';
            var comentario     = $('#comentario').val()
            if (result.value) {
                var apiUrl='<?php echo constant('RUTA_URL'); ?>/rest-api/AgentesTareas'; 
                var data = { 
                    usuarioID  : userID,
                    tareaID    : tareaID,              
                    empresaID  : empresaID,
                    agenteID   : agenteID,
                    estado     : 3,
                    Archivo    : base64Image,
                    original   : original,
                    comentario : comentario
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
        window.location = "<?php echo constant('RUTA_URL');?>/tareasencurso";
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
