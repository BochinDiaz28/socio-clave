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
                    <div class="card bg-transparent-50 overflow-hidden">
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
                                <div class="card border h-100 custom-card-border mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">Tomar Tareas</h5>
                                        <small>Tareas disponibles para aceptar!</small>
                                    </div>
                                    <div class="card-body">
                                        <div id="_MisEventos"></div>
                                    </div>
                                </div>
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
        var tareaID    = <?php echo $tareaID; ?>;
        var empresaID  = <?php echo $empresaID; ?>;
        var clienteID  = 0;
        var sucursalID = 0;
        if(tareaID>0){
            var url ='<?php echo constant('RUTA_URL'); ?>/rest-api/Tareas?tareaID='+tareaID;
            fetch(url)
            .then(response => response.json())
            .then(data => {
                $.each(data, function(i, item) {
                    if(tareaID==item.id){
                        clienteID  = item.idcliente;
                        $('#sucID').val(item.idreail);
                        $('#nombre').val(item.tarea); 
                        $('#direccion').val(item.ubicacion);                       
                        $('#fechaCheckin').val(item.fecha_sol);
                        $('#horaIngreso').val(item.hora_inicio);
                        $('#horaSalida').val(item.hora_final);
                    } 
                });
            });
           
        }else{
            ListaClientes();
        }    
        
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
            MisDisponibles();
        });  
    }
    function MisDisponibles() {     
        var agenteID = $('#clienteID').val();       
        var url     ='<?php echo constant('RUTA_URL');?>/rest-api/AgentesRetails?agenteRetailGET='+agenteID;
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
                html+='<div class="col-md-12 h-100">'+
                    '   <div class="row">'+
                    '      <div class="col-12">'+
                    '          <div class="media-body position-relative pl-3">'+
                    '              <h6 class="mt-3 mt-sm-0">'+item.tarea+'</h6>'+
                    '              <p class="fs--1 mb-0"><b>'+item.sucursal+'</b></p>'+                                            
                    '              <p class="fs--1 mb-0">'+item.ubicacion+'</p>'+                    
                    '              <p class="fs--1 mb-0">Limite desde  : <b>'+item.hora_inicio+'</b> hasta: <b>'+ item.hora_final +'</b></p>'+
                    '              <p class="fs--1 mb-0">'+he.decode(item.nota)+'</p>'+
                    '              '+checklist+''+ 
                    '              <button class="btn btn-outline-info btn-sm me-1 mb-1" type="button" onclick="AceptarTareas('+item.id+');"><span class="fas fa-check" data-fa-transform="shrink-3"></span> Aceptar</button>'+
                    '              <hr class="border-dashed border-bottom-0">'+
                    '          </div>'+
                    '       </div>'+
                    '   </div>'+
                    '</div>';
            }); 
            html+='</div>';
            $('#_MisEventos').html(html);
           
        });
    }

        
    function AceptarTareas(tareaID) {
        var userID    = <?php echo $userID; ?>;
        var empresaID = <?php echo $empresaID; ?>;
        var agenteID  = $('#clienteID').val(); 
        var Accion    = 'Aceptar';  
        var rtaAccion = 'Aceptada!'; 
        var metodo    = 'PUT';
        var comentario = '';
        var original   = '';
        var Archivo    = '';
        Swal.fire({
            title: '<strong>Confirma '+Accion+'?</strong>',
            icon : 'info',
            html : 'Si nadie tomo esta tarea se le asignara!',
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
                    usuarioID : userID,
                    tareaID   : tareaID,              
                    empresaID : empresaID,
                    agenteID  : agenteID,
                    estado    : 2,
                    Archivo    : Archivo,
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
        window.location = "<?php echo constant('RUTA_URL');?>/tareasasignadas";
    }
</script>