<nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">

    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
    <a class="navbar-brand me-1 me-sm-3" href="#">
        <div class="d-flex align-items-center">
        <img class="me-2" src="<?php echo constant('RUTA_URL'); ?>/public/assets/img/favicons/sienvio.png" alt="" width="70" />
        <span class="font-sans-serif"><!--falcon--></span></div>
    </a>

    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
        <?php if ($_SESSION['rol']<>200) {?>
            <li class="nav-item">
                <div class="theme-control-toggle fa-icon-wait px-2">
                <input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle" type="checkbox" data-theme-control="theme" value="dark" />
                <label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Cambiar a modo claro"><span class="fas fa-sun fs-0"></span></label>
                <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Cambiar a modo oscuro"><span class="fas fa-moon fs-0"></span></label>
                </div>
            </li>
        <?php } ?>
        <?php if($_SESSION['rol']==150){ ?>
            <li class="nav-item dropdown">
                <!--
                    <a class="nav-link notification-indicator notification-indicator-primary px-0 fa-icon-wait" 
                       id="navbarDropdownNotification" href="#" role="button" 
                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <span class="fas fa-bell" data-fa-transform="shrink-6" style="font-size: 33px;"></span>
                    </a>
              
                
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-card dropdown-menu-notification" aria-labelledby="navbarDropdownNotification">
                        <div class="card card-notification shadow-none">
                            <div class="card-header">
                                <div class="row justify-content-between align-items-center">
                                    <div class="col-auto">
                                        <h6 class="card-header-title mb-0">Notificaciones</h6>
                                    </div>
                                    
                                    <div class="col-auto ps-0 ps-sm-3">
                                        <a class="card-link fw-normal" 
                                        href="#" onclick="ConfirmarVistaTotdas(0)">Marcar todas leidas</a></div>
                                </div>
                            </div>
                          
                            <div class="scrollbar-overlay" style="max-height:19rem">
                                <div class="list-group list-group-flush fw-normal fs--1">
                                    <div class="list-group-title border-bottom">Nuevas</div>
                                    <div class="list-group-item">
                                        <div id="NotiClientes"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-footer text-center border-top"><a class="card-link d-block" 
                                href="<?php //echo constant('RUTA_URL'); ?>/clientenotificacion">Ver todas</a></div>
                        </div>
                    </div>
                    -->
            </li>
        <?php }?>
        <li class="nav-item dropdown"><a class="nav-link pe-0" id="navbarDropdownUser" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="avatar avatar-xl">
                <img class="rounded-circle" src="<?php echo constant('RUTA_URL'); ?>/public/assets/img/team/avatar.png" alt="" />

            </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
            <div class="bg-white dark__bg-1000 rounded-2 py-2">
                <a class="dropdown-item fw-bold text-warning" href="#!">
                    <span class="fas fa-crown me-1"></span>
                    <span><?php echo $_SESSION['nombre']; ?></span>
                </a>
                <?php if($_SESSION['rol']==150){ ?>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="https://api.whatsapp.com/send?phone=+56933746099" 
                   target="_blank">Ayudas</a>
                <div class="dropdown-divider"></div>
                <?php }?>
                <a class="dropdown-item" id="cerrarSession" href="<?php echo constant('RUTA_URL'); ?>/ingresar">Cerrar</a>
            </div>
            </div>
        </li>
    </ul>
</nav>