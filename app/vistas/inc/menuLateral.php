
<script>
    var isFluid = JSON.parse(localStorage.getItem('isFluid'));
    if (isFluid) {
    var container = document.querySelector('[data-layout]');
    container.classList.remove('container');
    container.classList.add('container-fluid');
    }
</script>
<nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
    <script>
        var navbarStyle = localStorage.getItem("navbarStyle");
        if (navbarStyle && navbarStyle !== 'transparent') {
        document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
        }
    </script>
    <div class="d-flex align-items-center">
        <div class="toggle-icon-wrapper">
            <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
        </div>
        <a class="navbar-brand" href="#">
            <div class="d-flex align-items-center py-3">
                <img class="me-2" src="<?php echo constant('RUTA_URL'); ?>/public/assets/img/favicons/sienvio.png" alt="" width="90" />
                <span class="font-sans-serif"><!--falcon--></span>
            </div>
        </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
    <?php if($_SESSION['rol']==100 || $_SESSION['rol']==125){ ?>
        <div class="navbar-vertical-content scrollbar">
            <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                <!--SECCION MENU ADMINISTRACION-->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#dashboard" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="dashboard">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chart-pie"></span></span><span class="nav-link-text ps-1">Administración</span>
                        </div>
                    </a>
                    <ul class="nav collapse show" id="dashboard">
                        <li class="nav-item">
                            <a class="nav-link active" href="<?php echo constant('RUTA_URL'); ?>/administracion" 
                                aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Administración</span>
                                </div>
                            </a>                            
                        </li>
                        <!--
                        <li class="nav-item">
                            <a class="nav-link active" href="<?php //echo constant('RUTA_URL'); ?>/notificaciones"
                                aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Notificaciones</span>
                                </div>
                            </a>                            
                        </li>
                        -->
                    </ul>
                </li>
                <!--SECCION MENU ADMINISTRACION-->
                <!--SECCION MENU TAREAS-->
                <li class="nav-item">
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Tareas</div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider" />
                        </div>
                    </div>
                
                    <a class="nav-link dropdown-indicator" href="#tareas" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="events">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-list-alt"></span></span><span class="nav-link-text ps-1">Tareas</span>
                        </div>
                    </a>
                    <ul class="nav collapse false" id="tareas">
                        <li class="nav-item">
                            <a class="nav-link" 
                                href="<?php echo constant('RUTA_URL'); ?>/lsttareas" 
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Lista de Tareas</span></div>
                            </a>                                        
                        </li>
                    </ul>
                </li>
                <!--FIN SECCION MENU EMPRESAS-->
                <!--SECCION PAÑOL-->
                <li class="nav-item">
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Pañol</div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider" />
                        </div>
                    </div>
                
                    <a class="nav-link dropdown-indicator" href="#panol" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="events">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-toolbox"></span></span><span class="nav-link-text ps-1">Pañol</span>
                        </div>
                    </a>    
                    <ul class="nav collapse false" id="panol">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo constant('RUTA_URL'); ?>/lstpanol" 
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Lista de Pañol</span></div>
                            </a>                                        
                        </li>
                        
                    </ul>
                </li>
                <!--FIN SECCION PAÑOL-->
                
                <!--SECCION MENU EMPRESAS-->
                <li class="nav-item">
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Clientes</div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider" />
                        </div>
                    </div>
                
                    <a class="nav-link dropdown-indicator" href="#empresas" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="events">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-user-check"></span></span><span class="nav-link-text ps-1">Clientes</span>
                        </div>
                    </a>
                    <ul class="nav collapse false" id="empresas">
                        <li class="nav-item">
                            <a class="nav-link" 
                                href="<?php echo constant('RUTA_URL'); ?>/lstclientes" 
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Lista de Clientes</span></div>
                            </a>                                        
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" 
                                href="<?php echo constant('RUTA_URL'); ?>/lstretails" 
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Lista de Retails</span></div>
                            </a>                                        
                        </li>
                    </ul>
                </li>
                <!--FIN SECCION MENU EMPRESAS-->

                <!--SECCION MENU REPONEDORES-->
                <li class="nav-item">
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Agentes</div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider" />
                        </div>
                    </div>
                
                    <a class="nav-link dropdown-indicator" href="#reponedores" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="events">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-user-secret"></span></span><span class="nav-link-text ps-1">Agentes</span>
                        </div>
                    </a>
                    <ul class="nav collapse false" id="reponedores">
                        <li class="nav-item">
                            <a class="nav-link" 
                                href="<?php echo constant('RUTA_URL'); ?>/lstagentes" 
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Lista de Agentes</span></div>
                            </a>                                        
                        </li>
                    </ul>
                </li>
                <!--FIN SECCION MENU REUNIONES-->
                <?php if($_SESSION['rol']==100){ ?>
                <!--SECCION MENU USUARIOS-->
                <li class="nav-item">
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Usuarios</div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider" />
                        </div>
                    </div>
                
                    <a class="nav-link dropdown-indicator" href="#usuarios" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="events">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-house-user"></span></span><span class="nav-link-text ps-1">Usuarios</span>
                        </div>
                    </a>    
                    <ul class="nav collapse false" id="usuarios">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo constant('RUTA_URL'); ?>/lstusuarios" 
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Lista de Usuarios</span></div>
                            </a>                                        
                        </li>
                        
                    </ul>
                </li>
                <!--FIN SECCION MENU USUARIOS-->
                <?php } ?>
            </ul>
        </div>
    <?php }elseif ($_SESSION['rol']==150) {?>
        <div class="navbar-vertical-content scrollbar">
            <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                <!--SECCION MENU ADMINISTRACION-->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#dashboard" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="dashboard">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chart-pie"></span></span><span class="nav-link-text ps-1">Administración</span>
                        </div>
                    </a>
                    <ul class="nav collapse show" id="dashboard">
                        <li class="nav-item">
                            <a class="nav-link active" href="<?php echo constant('RUTA_URL'); ?>/administracion" 
                                aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Administración</span>
                                </div>
                            </a>                            
                        </li>
                        <!--
                        <li class="nav-item">
                            <a class="nav-link active" href="<?php //echo constant('RUTA_URL'); ?>/notificaciones"
                                aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Notificaciones</span>
                                </div>
                            </a>                            
                        </li>
                        -->
                    </ul>
                </li>
                <!--SECCION MENU ADMINISTRACION-->
                <!--SECCION MENU TAREAS-->
                <li class="nav-item">
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Tareas</div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider" />
                        </div>
                    </div>
                
                    <a class="nav-link dropdown-indicator" href="#tareas" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="events">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-list-alt"></span></span><span class="nav-link-text ps-1">Tareas</span>
                        </div>
                    </a>
                    <ul class="nav collapse false" id="tareas">
                        <li class="nav-item">
                            <a class="nav-link" 
                                href="<?php echo constant('RUTA_URL'); ?>/lstsolicitadas" 
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Solicitadas</span></div>
                            </a>                                        
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" 
                                href="<?php echo constant('RUTA_URL'); ?>/lstaprobadas" 
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Aprobadas</span></div>
                            </a>                                        
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" 
                                href="<?php echo constant('RUTA_URL'); ?>/lstaceptadas" 
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Aceptadas</span></div>
                            </a>                                        
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" 
                                href="<?php echo constant('RUTA_URL'); ?>/lstencurso" 
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">En Curso</span></div>
                            </a>                                        
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" 
                                href="<?php echo constant('RUTA_URL'); ?>/lstfinalizadas" 
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Finalizadas</span></div>
                            </a>                                        
                        </li>
                    </ul>
                </li>
                <!--FIN SECCION MENU EMPRESAS-->
                <!--SECCION MENU EMPRESAS-->
                <li class="nav-item">
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Perfil</div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider" />
                        </div>
                    </div>
                
                    <a class="nav-link dropdown-indicator" href="#empresas" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="events">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-user-check"></span></span><span class="nav-link-text ps-1">Perfil</span>
                        </div>
                    </a>
                    <ul class="nav collapse false" id="empresas">
                        <li class="nav-item">
                            <a class="nav-link" 
                                href="<?php echo constant('RUTA_URL'); ?>/lstclientes" 
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Mi Perfil</span></div>
                            </a>                                        
                        </li>
                    </ul>
                </li>
                <!--FIN SECCION MENU EMPRESAS-->

                
            </ul>
        </div>
    <?php }elseif ($_SESSION['rol']==200) {?>
        <div class="navbar-vertical-content scrollbar">
            <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                <!--SECCION MENU ADMINISTRACION-->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#dashboard" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="dashboard">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chart-pie"></span></span><span class="nav-link-text ps-1">Administración</span>
                        </div>
                    </a>
                    <ul class="nav collapse show" id="dashboard">
                        <li class="nav-item">
                            <a class="nav-link active" href="<?php echo constant('RUTA_URL'); ?>/administracion" 
                                aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Administración</span>
                                </div>
                            </a>                            
                        </li>
                        <!--
                        <li class="nav-item">
                            <a class="nav-link active" href="<?php //echo constant('RUTA_URL'); ?>/notificaciones"
                                aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Notificaciones</span>
                                </div>
                            </a>                            
                        </li>
                        -->
                    </ul>
                </li>
                <!--SECCION MENU ADMINISTRACION-->
                <!--SECCION MENU TAREAS-->
                <!--
                <li class="nav-item">
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Tareas</div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider" />
                        </div>
                    </div>
                
                    <a class="nav-link dropdown-indicator" href="#tareas" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="events">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-list-alt"></span></span><span class="nav-link-text ps-1">Tareas</span>
                        </div>
                    </a>
                    <ul class="nav collapse false" id="tareas">
                        <li class="nav-item">
                            <a class="nav-link" 
                                href="<?php //echo constant('RUTA_URL'); ?>/" 
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Disponibles</span></div>
                            </a>                                        
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" 
                                href="<?php //echo constant('RUTA_URL'); ?>/lstaprobadas" 
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Pendientes</span></div>
                            </a>                                        
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" 
                                href="<?php //echo constant('RUTA_URL'); ?>/lstencurso" 
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">En Curso</span></div>
                            </a>                                        
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" 
                                href="<?php //echo constant('RUTA_URL'); ?>/lstfinalizadas" 
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Finalizadas</span></div>
                            </a>                                        
                        </li>
                    </ul>
                </li>
                -->
                <!--FIN SECCION MENU EMPRESAS-->
                <!--SECCION MENU EMPRESAS-->
                <!--
                <li class="nav-item">
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Perfil</div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider" />
                        </div>
                    </div>
                
                    <a class="nav-link dropdown-indicator" href="#empresas" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="events">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-user-check"></span></span><span class="nav-link-text ps-1">Perfil</span>
                        </div>
                    </a>
                    <ul class="nav collapse false" id="empresas">
                        <li class="nav-item">
                            <a class="nav-link" 
                                href="<?php //echo constant('RUTA_URL'); ?>/lstclientes" 
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Mi Perfil</span></div>
                            </a>                                        
                        </li>
                    </ul>
                </li>
                -->
                <!--FIN SECCION MENU EMPRESAS-->

                
            </ul>
        </div>
    <?php } ?> 
    </div>
</nav>