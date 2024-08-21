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
                                    <a id="linkTomar" class="link-dark active" href="<?=constant('RUTA_URL');?>/tomartarea" onclick="setActiveMenu('linkTomar')"><span class="text-dark poppins-bold">Tomar</span></a>
                                    <a id="linkAsignada" class="link-dark" href="<?=constant('RUTA_URL');?>/tareasasignadas" onclick="setActiveMenu('linkAsignada')" ><span class="text-dark poppins-bold">Asignadas</span></a>
                                    <a id="linkCurso" class="link-dark" href="<?=constant('RUTA_URL');?>/tareasencurso" onclick="setActiveMenu('linkCurso')" ><span class="text-dark poppins-bold">En curso</span></a>
                                    <a id="linkFinalizada" class="link-dark" href="<?=constant('RUTA_URL');?>/tareasfinalizadas" onclick="setActiveMenu('linkFinalizada')" >Finalizadas</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                           
                            <div id="_MisFinalizadas"></div>
                                
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
            MisFinalizadas();
        });  
    }

    function MisFinalizadas() {     
        var agenteID = $('#clienteID').val();       
        var url     ='<?php echo constant('RUTA_URL');?>/rest-api/AgentesRetails?dtagentesRetailFinalizadasGET='+agenteID;
        var html    = '';
        fetch(url)
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
            html='<div class="row">';
            
            $.each(data, function(i, item) {   
               
                if(item.cerradaAdmin==1){
                    var checklist = '<p class="fs--1 mb-0" style="color:#0C787B;"><span class="far fa-file fs-2" style="color: #0C787B;"></span><b> Aprobada por supervisión</b></p>';
                }else if(item.cerradaAdmin==0){
                    var checklist ='<p class="fs--1 mb-0" style="color:#C82A2A;"><span class="far fa-file fs-2" style="color: #C82A2A;"></span><b> No aprobada por supervisión</b></p>';
                }else{
                    var checklist ='<p class="fs--1 mb-0">*<b> Pendiente de revisión</b></p>';
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
                    '          </div>'+
                    '       </div>'+
                    '   </div>'+
                    '</div></div></div>';
            }); 
            html+='</div>';
            $('#_MisFinalizadas').html(html);
            } else {
                html='<div class="row"><p class="fs--1 mb-0"><b>Aún no haz finalizado ninguna tarea</b></p></div>';
                $('#_MisFinalizadas').html(html);
            }
        });
    }


    function recarga(){
        window.location = "<?php echo constant('RUTA_URL');?>/tareasencurso";
    }
</script>

