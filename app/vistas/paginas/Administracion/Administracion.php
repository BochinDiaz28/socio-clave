<?php require RUTA_APP . '/vistas/inc/header.php'; ?>
<?php require RUTA_APP . '/vistas/inc/menuLateral.php'; ?>
<?php
    $empresaID = $datos['empresaID']; #|-> EMPRESA LOGEADA
    $userID    = $datos['userID'];    #|-> USUARIOS LOGEADO
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
                            <div class="bg-holder d-none d-md-block bg-card z-index-1" style="background-image:url(<?php echo constant('RUTA_URL'); ?>/public/img/logosEmpresas/Logo-duoc.png');background-size:230px;background-position:right bottom;z-index:-1;"></div>
                            <div class="position-relative z-index-2">
                                <div>
                                    <h3 class="text-primary mb-1">Hola, <?php echo $_SESSION['nombre'];?>!</h3>
                                    <p>Gestor y admistrador de tareas </p>
                                </div>
                                <div class="d-flex py-3">
                                    <div class="pe-3">
                                        <p class="text-600 fs--1 fw-medium">T. Para hoy </p>
                                        <h4 class="text-800 mb-0"> <span id="_TareasHoy"></span> </h4>
                                    </div>
                                    <div class="ps-3">
                                        <p class="text-600 fs--1">T. del Mes</p>
                                        <h4 class="text-800 mb-0"> <span id="_TotalMes"></span> </h4>
                                    </div>
                                    <div class="ps-3">
                                        <p class="text-600 fs--1">T. Finalizadas</p>
                                        <h4 class="text-800 mb-0"> <span id="_TotalHistorial"></span> </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--SECCION LISTA VER ORDENES WEB CUANDO ESTEN ACTIVAS-->
                        <div class="card-body p-0">
                            <ul class="mb-0 list-unstyled">                    
                                <li class="alert mb-0 rounded-0 py-3 px-card greetings-item border-top  border-0">
                                    <div class="row flex-between-center py-2">
                                        <div class="col-md-2">
                                            <div class="d-flex">
                                                <div class="fas fa-list mt-1 fs--2 text-info"></div>
                                                <p class="fs--1 ps-2 mb-0">
                                                    <a class="alert-link fs--1 fw-medium" href="<?php echo constant('RUTA_URL'); ?>/lsttareas">
                                                        <strong> Tareas </strong> Solicitadas 
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    
                                        <div class="col-auto">
                                            <div class="d-flex">
                                                <div class="fas fa-check mt-1 fs--2 text-success"></div>
                                                <p class="fs--1 ps-2 mb-0">
                                                    <a class="alert-link fs--1 fw-medium" href="<?php echo constant('RUTA_URL'); ?>/lsttareasaceptadas">
                                                        <strong> <span id="_Aceptadas"></span> Tareas </strong> Aceptadas
                                                    </a>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-auto">
                                            <div class="d-flex">
                                                <div class="fas fa-clock mt-1 fs--2 text-danger"></div>
                                                <p class="fs--1 ps-2 mb-0">
                                                    <a class="alert-link fs--1 fw-medium" href="<?php echo constant('RUTA_URL'); ?>/lsttareasencurso">
                                                        <strong> <span id="_enCurso"></span> Tareas </strong> en Curso
                                                    </a>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-auto">
                                            <div class="d-flex">
                                                <div class="fas fa-check-double mt-1 fs--2 text-secondary"></div>
                                                <p class="fs--1 ps-2 mb-0">
                                                    <a class="alert-link fs--1 fw-medium" href="<?php echo constant('RUTA_URL'); ?>/lsttareasfinalizadas">
                                                        <strong> Tareas </strong> Finalizadas
                                                    
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

           
    <div class="row g-0">
        <div class="col-sm-6 col-xxl-3 pe-sm-2 mb-3 mb-xxl-0">
            <div class="card">
                <div class="card-header d-flex flex-between-center bg-light py-2">
                    <h6 class="mb-0">Usuarios Activos</h6>
                </div>

                <div class="card-body py-2">
                    <div id="_MisUsuarios"></div>
                </div>

                <div class="card-footer bg-light p-0">
                    <a class="btn btn-sm btn-link d-block w-100 py-2" 
                        href="<?php echo constant('RUTA_URL'); ?>/lstusuarios">Ver Todos<span class="fas fa-chevron-right ms-1 fs--2"></span></a>
                </div>

            </div>
        </div>
        <div class="col-sm-6 col-xxl-3 ps-sm-2 order-xxl-1 mb-3 mb-xxl-0">
            <!--AQUI IRIA MAPA EN CASO DE ACTIVARSE-->
        </div>
        
    </div>
</div>

<?php require RUTA_APP . '/vistas/inc/footer.php'; ?>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables-bs4/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables.net-responsive/dataTables.responsive.js"></script>
<script src="<?php echo constant('RUTA_URL');?>/public/vendors/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>

<script>
    function getTareasTotal() {
        var empresaID = <?php echo $_SESSION['empresaID']; ?>;
        var url       = '<?php echo constant('RUTA_URL');?>/rest-api/Dashboard?empresaID='+empresaID;
        fetch(url)
        .then(response => response.json())
        .then(data => { 
            $.each(data, function(i, item) {
                $('#_TareasHoy').html(NumeroChile(item.Total));
                $('#_TotalMes').html(NumeroChile(item.Mes));
                $('#_TotalHistorial').html(NumeroChile(item.Historial));
                $('#_Aceptadas').html(NumeroChile(item.Aceptadas));
                $('#_enCurso').html(NumeroChile(item.Curso));
            });
        }); 
    }
    getTareasTotal();

    function UsuariosEnLinea() {     
        var empresaID = <?php echo $empresaID; ?>     
        var url     ='<?php echo constant('RUTA_URL');?>/rest-api/Usuarios?userOnlineGET='+empresaID;
        var html    = '';
        fetch(url)
        .then(response => response.json())
        .then(data => {
            html='<div class="row">';
            $.each(data, function(i, item) {
                var rol = item.rol;
                if(rol==100){
                    var rolX = "Administrador";
                }else if(rol==125){
                    var rolX = "Supervisor";
                }else if(rol==150){
                    var rolX = "Cliente";
                }else if(rol==200){
                    var rolX = "Agente";
                }
                //CONTROLAMOS QUE NO SEA NULL
                if (item.online === null) {
                    var miStatus   = 'status-offline';
                    var Actividad  = "Sin Ingreso";
                }else{
                    var miStatus   = compararFecha(item.online);
                    var Actividad  = item.online;
                }
                html+='<div class="d-flex align-items-center position-relative mb-3">'+
                '         <div class="avatar avatar-2xl '+miStatus+'">'+
                '            <img class="rounded-circle" src="<?php echo constant('RUTA_URL'); ?>/public/assets/img/team/avatar.png" alt="" />'+
                '         </div>'+
                '         <div class="flex-1 ms-3">'+
                '            <h6 class="mb-0 fw-semi-bold">'+item.nombre+'</h6>'+
                '            <p class="text-500 fs--2 mb-0">'+rolX+'</p>'+
                '            <p class="text-500 fs--2 mb-0">'+Actividad+'</p>'+
                '         </div>'+
                '      </div>';

               
            }); 
            html+='</div>';
            $('#_MisUsuarios').html(html);
        
        });
    }
    UsuariosEnLinea();

    function compararFecha(fechaIndicada){
        // Obtener la fecha y hora actual
        const fechaActual = new Date();
        // Convertir la fecha actual a un formato similar al deseado (YYYY-MM-DD HH:MM:SS)
        const formatoDeseado   = `${fechaActual.getFullYear()}-${padZero(fechaActual.getMonth() + 1)}-${padZero(fechaActual.getDate())} ${padZero(fechaActual.getHours())}:${padZero(fechaActual.getMinutes())}:${padZero(fechaActual.getSeconds())}`;
        // Convertir las fechas a objetos Date para compararlas
        const fechaActualObj   = new Date(formatoDeseado);
        const fechaIndicadaObj = new Date(fechaIndicada);
        // Calcular la diferencia en minutos
        const diferenciaEnMinutos = (fechaIndicadaObj - fechaActualObj) / (1000 * 60);       
        // Comprobar si la diferencia es mayor a 5 minutos
        if ( -5 > diferenciaEnMinutos ) {
            //console.log("offline");
            return 'status-offline';
        } else if ( -9 > diferenciaEnMinutos ) {
            return 'status-away';
        } else {
           return 'status-online';
        }
    }
    // Función para agregar un cero delante de números menores a 10
    function padZero(numero) {
        if (numero < 10) {
            return `0${numero}`;
        }
        return numero;
    }

</script>