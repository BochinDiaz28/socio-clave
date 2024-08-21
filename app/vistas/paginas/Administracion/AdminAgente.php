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
    <!--MENU BINEVENIDA-->
    <div class="row g-3 mb-3">
        <div class="col-xxl-6 col-xl-12">
            <div class="row g-3">
                <div class="col-12">
                    <div class="card bg-transparent-50 overflow-hidden">
                    <div class="card-header position-relative">
                    <div class="bg-holder d-none d-md-block bg-card"></div>
                        <div class="position-relative z-index-2">
                            <div>
                                <h5 class="mb-1 poppins-semibold">Hola, <span id="_Nombre"></span>!</h5>
                                <p class="poppins-semibold">¿Qué hago ahora?</p>
                            </div>
                            
                            <div class="card border h-100 custom-card-border mb-3">
                                <div class="card-header">
                                    <a href="<?php echo constant('RUTA_URL');?>/tomartarea" style="text-decoration: none;" onclick="setActiveMenu('linkTomar')">
                                        <div class="row">
                                            <div class="col-2 d-flex align-items-center justify-content-center">
                                                <div><span class="far fa-file fs-3" style="color: #0C787B;"></span> </div>
                                            </div>
                                            <div class="col-10">
                                                <div class="media-body position-relative pl-3">
                                                    <h5 class="mb-0 poppins-medium">Toma una tarea</h5>
                                                    <p class="fs--1 poppins-light"><span class="text-600">Haz click acá y selecciona una tarea que esté disponible.</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                                <div class="bg-danger me-3 icon-item"><span class="fas fa-exclamation-circle text-white fs-3"></span></div>
                                <p class="mb-0 flex-1 fs--2 poppins-light">Si fuiste asignado directamente a una tarea, podrás omitir este paso. Recuerda realizar tu tarea durante el tiempo que tengas asignado.</p>
                            </div>

                            <div>                                
                                <h5 class="poppins-semibold">Tareas</h5>
                            </div>

                            <div class="card border h-100 custom-card-border mb-3">
                                <div class="card-header">
                                    <a href="<?php echo constant('RUTA_URL');?>/tareasasignadas" style="text-decoration: none;" onclick="setActiveMenu('linkAsignada')">
                                        <div class="row">
                                            <div class="col-2 d-flex align-items-center justify-content-center">
                                                <div><span class="fas fa-user-check fs-3" style="color: #0C787B;"></span></div>
                                            </div>
                                            <div class="col-10">
                                                <div class="media-body position-relative pl-3">
                                                    <h5 class="mb-0 poppins-medium">Tareas asignadas</h5>
                                                    <p class="fs--1 poppins-light"><span class="text-600">Haz click acá y visualiza las tareas a las que fuiste asignado(a) directamente por tu jefatura.</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="card border h-100 custom-card-border mb-3">
                                <div class="card-header">
                                    <a href="<?php echo constant('RUTA_URL');?>/tareasencurso" style="text-decoration: none;" onclick="setActiveMenu('linkCurso')">
                                        <div class="row">
                                            <div class="col-2 d-flex align-items-center justify-content-center">
                                                <div><span class="fas fa-user-clock fs-3" style="color: #0C787B;"></span> </div>
                                            </div>
                                            <div class="col-10">
                                                <div class="media-body position-relative pl-3">
                                                    <h5 class="mb-0 poppins-medium">Tareas en curso</h5>
                                                    <p class="fs--1 poppins-light"><span class="text-600">Haz click acá y visualiza las tareas que están en curso (que debes ejecutar o estás ejecutando).</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="card border h-100 custom-card-border mb-3">
                                <div class="card-header">
                                    <a href="<?php echo constant('RUTA_URL');?>/tareasfinalizadas" style="text-decoration: none;" onclick="setActiveMenu('linkFinalizada')">
                                        <div class="row">
                                            <div class="col-2 d-flex align-items-center justify-content-center">
                                                <div><span class="fas fa-calendar-check fs-3" style="color: #0C787B;"></span> </div>
                                            </div>
                                            <div class="col-10">
                                                <div class="media-body position-relative pl-3">
                                                    <h5 class="mb-0 poppins-medium">Tareas finalizadas</h5>
                                                    <p class="fs--1 poppins-light"><span class="text-600">Haz click acá y visualiza las tareas que se encuentran finalizadas, así como su estado (aprobadas o no).</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                   
                </div>

            </div>
        </div>
    </div>

    
    
    
    <input type="hidden" id="sucID"     value="0">
    <input type="hidden" id="clienteID" value="0">
    <input type="hidden" id="tareaIDx" value="0">
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
        var tareaID    = <?php echo $tareaID; ?>;
        var empresaID  = <?php echo $empresaID; ?>;
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
        });  
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

