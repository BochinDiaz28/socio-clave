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
                        <div class="ms-2 me-2">
                            <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                                <div class="bg-danger me-3 icon-item"><span class="fas fa-exclamation-circle text-white fs-3"></span></div>
                                <p class="mb-0 flex-1 fs--2 poppins-light">Una vez que subas la foto, deberás presionar el botón de "iniciar tarea".</p>
                            </div>
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
            if (Array.isArray(data) && data.length > 0) {
                html='<div class="row">';
                
                $.each(data, function(i, item) {   
                    var dropZone = '<label for="fileInput_'+item.id+'" class="custom-file-upload"><i class="far fa-file-image"></i> * Tomar Foto</label><input type="file" name="fileInput" id="fileInput_'+item.id+'" accept="image/*" onchange="convertToBase64('+item.id+')" />'+
                                    '<img id="previewImage_'+item.id+'" style="display: none; max-width: 300px; max-height: 300px;">'+
                                    '<br>'+
                                    '<input class="form-control form-control-sm" type="text" id="comentario_'+item.id+'" placeholder="Su comentario"/>';             
                    if(item.checklist==1){
                        var checklist = '<p class="fs--1 mb-0">*<b> Requiere control de inventario</b></p>';
                    }else{
                        var checklist ='';
                    }
                    if(item.foto_inicio==1){
                        var fotoInicio =dropZone;
                    }else{
                        var fotoInicio ='<input class="form-control form-control-sm" type="text" id="comentario" placeholder="Su comentario"/>';
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
                        '              <br>'+ 
                        '              '+fotoInicio+''+ 
                        '              <button class="btn btn-secondary btn-sm me-1 mb-1" type="button" onclick="ControRequeridos('+item.id+');" style="border-color: #0C787B; background-color:#0C787B;"><span class="fas fa-check" data-fa-transform="shrink-3"></span> Iniciar Tarea</button>'+                    
                        '          </div>'+
                        '       </div>'+
                        '   </div>'+
                        '</div></div></div>';
                }); 
                html+='</div>';
                $('#_MisPendientes').html(html);
            } else {
                html='<div class="row"><p class="fs--1 mb-0"><b>En este momento no hay tareas asignadas</b></p></div>';
                $('#_MisPendientes').html(html);
            }
        });
    }

    function ControRequeridos(tareaID) {
        var fotoFinal = 0;
        var checkList = 0;
        var url       = '<?=constant('RUTA_URL');?>/rest-api/Tareas.php?tareaID='+tareaID;
        fetch(url)
        .then(response => response.json())
        .then(data => {
            $.each(data, function(i, item) {
                fotoFinal= item.foto_inicio;
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
            IniciarTareas(tareaID,fotoFinal)
        });  
    }
    function IniciarTareas(tareaID,fotoFinal) {
        var userID    = <?php echo $userID; ?>;
        var empresaID = <?php echo $empresaID; ?>;
        var agenteID  = $('#clienteID').val(); 
        var Accion    = 'Iniciar';  
        var rtaAccion = 'Iniciada!'; 
        var metodo    = 'PUT';


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
            var comentario = $('#comentario_'+tareaID).val();
        }

        Swal.fire({
            title: '<strong>Confirma '+Accion+'?</strong>',
            icon : 'info',
            html : '<b>Inciando Tarea</b>',
            showCancelButton : true,
            focusConfirm     : false,
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> '+ Accion +'!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
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
