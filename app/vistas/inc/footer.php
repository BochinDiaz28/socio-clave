       




        </div><!--CIERRA DE HEADER-->

        </main>
        
        <?php if ($_SESSION['rol']<>200) {?>
        <div class="offcanvas offcanvas-end settings-panel border-0" id="settings-offcanvas" tabindex="-1" aria-labelledby="settings-offcanvas">
            <div class="offcanvas-header settings-panel-header bg-shape">
                <div class="z-index-1 py-1 light">
                    <h5 class="text-white"> <span class="fas fa-palette me-2 fs-0"></span>Configuración</h5>
                    <p class="mb-0 fs--1 text-white opacity-75"> Seleccione su estilo</p>
                </div>
                <button class="btn-close btn-close-white z-index-1 mt-0" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body scrollbar-overlay px-card" id="themeController">
                <h5 class="fs-0">Color</h5>
                <p class="fs--1">Seleccione el color de su app.</p>
                <div class="btn-group d-block w-100 btn-group-navbar-style">
                    <div class="row gx-2">
                        <div class="col-6">
                            <input class="btn-check" id="themeSwitcherLight" name="theme-color" type="radio" value="light" data-theme-control="theme" />
                            <label class="btn d-inline-block btn-navbar-style fs--1" for="themeSwitcherLight"> <span class="hover-overlay mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0" src="<?php echo constant('RUTA_URL'); ?>/public/assets/img/generic/falcon-mode-default.jpg" alt=""/></span><span class="label-text">Light</span></label>
                        </div>
                        <div class="col-6">
                            <input class="btn-check" id="themeSwitcherDark" name="theme-color" type="radio" value="dark" data-theme-control="theme" />
                            <label class="btn d-inline-block btn-navbar-style fs--1" for="themeSwitcherDark"> <span class="hover-overlay mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0" src="<?php echo constant('RUTA_URL'); ?>/public/assets/img/generic/falcon-mode-dark.jpg" alt=""/></span><span class="label-text"> Dark</span></label>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-start">
                        <img class="me-2" src="<?php echo constant('RUTA_URL'); ?>/public/assets/img/icons/left-arrow-from-left.svg" width="20" alt="" />
                        <div class="flex-1">
                            <h5 class="fs-0">RTL Mode</h5>
                            <p class="fs--1 mb-0">Seleccione direccion del menu </p>
                        </div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input ms-0" id="mode-rtl" type="checkbox" data-theme-control="isRTL" />
                    </div>
                </div>
                <hr />
                
                <h5 class="fs-0 d-flex align-items-center">Menu Vertical</h5>
                <p class="fs--1 mb-0">Configure su menu vertical</p>            
                <div class="btn-group d-block w-100 btn-group-navbar-style">
                    <div class="row gx-2">
                        <div class="col-6">
                        <input class="btn-check" id="navbar-style-transparent" type="radio" name="navbarStyle" value="transparent" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-transparent"> <img class="img-fluid img-prototype" src="<?php echo constant('RUTA_URL'); ?>/public/assets/img/generic/default.png" alt="" /><span class="label-text"> Transparent</span></label>
                        </div>
                        <div class="col-6">
                        <input class="btn-check" id="navbar-style-inverted" type="radio" name="navbarStyle" value="inverted" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-inverted"> <img class="img-fluid img-prototype" src="<?php echo constant('RUTA_URL'); ?>/public/assets/img/generic/inverted.png" alt="" /><span class="label-text"> Inverted</span></label>
                        </div>
                        <div class="col-6">
                        <input class="btn-check" id="navbar-style-card" type="radio" name="navbarStyle" value="card" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-card"> <img class="img-fluid img-prototype" src="<?php echo constant('RUTA_URL'); ?>/public/assets/img/generic/card.png" alt="" /><span class="label-text"> Card</span></label>
                        </div>
                        <div class="col-6">
                        <input class="btn-check" id="navbar-style-vibrant" type="radio" name="navbarStyle" value="vibrant" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-vibrant"> <img class="img-fluid img-prototype" src="<?php echo constant('RUTA_URL'); ?>/public/assets/img/generic/vibrant.png" alt="" /><span class="label-text"> Vibrant</span></label>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <a class="card setting-toggle" href="#settings-offcanvas" data-bs-toggle="offcanvas">
            <div class="card-body d-flex align-items-center py-md-2 px-2 py-1">
                <div class="bg-soft-primary position-relative rounded-start" style="height:34px;width:28px">
                    <div class="settings-popover">
                        <span class="ripple">
                            <span class="fa-spin position-absolute all-0 d-flex flex-center">
                                <span class="icon-spin position-absolute all-0 d-flex flex-center">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19.7369 12.3941L19.1989 12.1065C18.4459 11.7041 18.0843 10.8487 18.0843 9.99495C18.0843 9.14118 18.4459 8.28582 19.1989 7.88336L19.7369 7.59581C19.9474 7.47484 20.0316 7.23291 19.9474 7.03131C19.4842 5.57973 18.6843 4.28943 17.6738 3.20075C17.5053 3.03946 17.2527 2.99914 17.0422 3.12011L16.393 3.46714C15.6883 3.84379 14.8377 3.74529 14.1476 3.3427C14.0988 3.31422 14.0496 3.28621 14.0002 3.25868C13.2568 2.84453 12.7055 2.10629 12.7055 1.25525V0.70081C12.7055 0.499202 12.5371 0.297594 12.2845 0.257272C10.7266 -0.105622 9.16879 -0.0653007 7.69516 0.257272C7.44254 0.297594 7.31623 0.499202 7.31623 0.70081V1.23474C7.31623 2.09575 6.74999 2.8362 5.99824 3.25599C5.95774 3.27861 5.91747 3.30159 5.87744 3.32493C5.15643 3.74527 4.26453 3.85902 3.53534 3.45302L2.93743 3.12011C2.72691 2.99914 2.47429 3.03946 2.30587 3.20075C1.29538 4.28943 0.495411 5.57973 0.0322686 7.03131C-0.051939 7.23291 0.0322686 7.47484 0.242788 7.59581L0.784376 7.8853C1.54166 8.29007 1.92694 9.13627 1.92694 9.99495C1.92694 10.8536 1.54166 11.6998 0.784375 12.1046L0.242788 12.3941C0.0322686 12.515 -0.051939 12.757 0.0322686 12.9586C0.495411 14.4102 1.29538 15.7005 2.30587 16.7891C2.47429 16.9504 2.72691 16.9907 2.93743 16.8698L3.58669 16.5227C4.29133 16.1461 5.14131 16.2457 5.8331 16.6455C5.88713 16.6767 5.94159 16.7074 5.99648 16.7375C6.75162 17.1511 7.31623 17.8941 7.31623 18.7552V19.2891C7.31623 19.4425 7.41373 19.5959 7.55309 19.696C7.64066 19.7589 7.74815 19.7843 7.85406 19.8046C9.35884 20.0925 10.8609 20.0456 12.2845 19.7729C12.5371 19.6923 12.7055 19.4907 12.7055 19.2891V18.7346C12.7055 17.8836 13.2568 17.1454 14.0002 16.7312C14.0496 16.7037 14.0988 16.6757 14.1476 16.6472C14.8377 16.2446 15.6883 16.1461 16.393 16.5227L17.0422 16.8698C17.2527 16.9907 17.5053 16.9504 17.6738 16.7891C18.7264 15.7005 19.4842 14.4102 19.9895 12.9586C20.0316 12.757 19.9474 12.515 19.7369 12.3941ZM10.0109 13.2005C8.1162 13.2005 6.64257 11.7893 6.64257 9.97478C6.64257 8.20063 8.1162 6.74905 10.0109 6.74905C11.8634 6.74905 13.3792 8.20063 13.3792 9.97478C13.3792 11.7893 11.8634 13.2005 10.0109 13.2005Z" fill="#2A7BE4"></path>
                                    </svg>
                                </span>
                            </span>
                        </span>
                    </div>
                </div>
                <small class="text-uppercase text-primary fw-bold bg-soft-primary py-2 pe-2 ps-1 rounded-end">CONF</small>
            </div>
        </a>
        <?php } ?>
        <!--/* SE EJECUTA EN VISTA CLIENTES */-->
        <div class="modal fade" id="modalNotificacion" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content position-relative">
                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" 
                                data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                            <h4 class="mb-1" id="modalExampleDemoLabel">Notificaciones</h4>
                        </div>
                        <div class="p-4 pb-0">
                            <div class="text-center" id="titulo"></div> 
                            <div id="mensaje"></div>
                            <div class="text-center" id="foto"></div>
                            <div class="text-center" id="expira"></div>
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--/* FIN VISTA CLIENTES */-->

        <script type="text/javascript" src="<?php echo constant('RUTA_URL'); ?>/public/js/jquery-3.4.1.min.js"></script>
        <!--<script src="https://sdk.mercadopago.com/js/v2"></script>-->
        <script src="<?php echo constant('RUTA_URL'); ?>/public/vendors/popper/popper.min.js"></script>
        <script src="<?php echo constant('RUTA_URL'); ?>/public/vendors/bootstrap/bootstrap.min.js"></script>
        <script src="<?php echo constant('RUTA_URL'); ?>/public/vendors/anchorjs/anchor.min.js"></script>
        <script src="<?php echo constant('RUTA_URL'); ?>/public/vendors/is/is.min.js"></script>
        <!--<script src="<?php //echo constant('RUTA_URL'); ?>/public/vendors/swiper/swiper-bundle.min.js"></script>-->
        <script src="<?php echo constant('RUTA_URL'); ?>/public/vendors/echarts/echarts.min.js"></script>
        <script src="<?php echo constant('RUTA_URL'); ?>/public/vendors/fontawesome/all.min.js"></script>
        <script src="<?php echo constant('RUTA_URL'); ?>/public/vendors/lodash/lodash.min.js"></script>
        <!--<script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>-->
        <script src="<?php echo constant('RUTA_URL'); ?>/public/vendors/list.js/list.min.js"></script>
        <script src="<?php echo constant('RUTA_URL'); ?>/public/js/sweetalert2.all.min.js"></script>

        <script src="<?php echo constant('RUTA_URL'); ?>/public/vendors/tinymce/tinymce.min.js"></script>

        <script src="<?php echo constant('RUTA_URL'); ?>/public/vendors/fullcalendar/main.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script src="<?php echo constant('RUTA_URL'); ?>/public/vendors/toastr/toastr.js"></script>

        <script src="<?php echo constant('RUTA_URL'); ?>/public/assets/js/theme.js"></script>

        <script type="text/javascript" src="<?php echo constant('RUTA_URL'); ?>/public/js/main.js"></script>
        
        <script type="text/javascript" src="<?php echo constant('RUTA_URL'); ?>/public/script.js"></script>
  
    <!--INTEGRO FIREBASE-->
    <?php if(isset($_SESSION['rol'])){?>
       
   
    <script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-messaging-compat.js"></script>
    <script>

        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('<?php echo constant('RUTA_URL'); ?>/firebase-messaging-sw.js')
                .then(function(registration) {
                console.log('Service Worker registrado con éxito:', registration);
                return registration;
                })
                .then(function(registration) {
                // Aquí, puedes suscribirte a las notificaciones una vez que el Service Worker esté activo
                return registration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: 'BIRNe4g4RrRxEDi1Lf5-zyuEMwWl53AopwDUIEhs3YF3-8uxgre3i5oJj_FFdLFymduV8_4b86yZwmcWh8M86Sc'
                });
                })
                .then(function(subscription) {
                console.log('Suscripción a las notificaciones exitosa:', subscription);
                })
                .catch(function(error) {
                console.log('Error al registrar el Service Worker o suscribirse a las notificaciones:', error);
                });
        }

    </script>
    <script>
        const firebaseConfig = {
            apiKey           : "AIzaSyD7QrrbSfbRvY-5E7XOhvhLL7xP98yBfYo",
            authDomain       : "sistemaonline-79c63.firebaseapp.com",
            projectId        : "sistemaonline-79c63",
            messagingSenderId: "980417301714",
            appId            : "1:980417301714:web:594c3043272dcddc31f10b"
        };
        const app       = firebase.initializeApp(firebaseConfig)
        const messaging = firebase.messaging()
        // generate device token using public id
        messaging.getToken({ vapidKey: "BIRNe4g4RrRxEDi1Lf5-zyuEMwWl53AopwDUIEhs3YF3-8uxgre3i5oJj_FFdLFymduV8_4b86yZwmcWh8M86Sc" }).then((currentToken) => {
            if (currentToken) {
                console.log(currentToken);
                sendTokenToServer(currentToken);
            } else {
                // if token is empty
                setTokenSentToServer(false);
            }
        }).catch((err) => {
            console.log(err);
            // AQUI ESTA SALIENDO EL ERROR
            setTokenSentToServer(false)
        })
        // Escuchar notificaciones push desde FCM
        messaging.onMessage((payload) => {
            console.log("Ingreso");
            // Cuando se recibe una notificación push mientras la aplicación está en primer plano
            const { title, body } = payload.notification;
            
            const notification = new Notification(title, {
                body: body
                //icon: '../HA-Codes-Pack/icon.png' // Ruta de la imagen a mostrar en la notificación
            });
            notification.onclick = function () {
                // Lo que debe ocurrir cuando se hace clic en la notificación
                // Puede ser redirigir a una página específica, abrir una ventana, etc.
            };
        });

        // token enviado al servidor donde se utiliza para enviar notificaciones
        function sendTokenToServer(currentToken) 
        {
            // primero revisa si ya lo enviamos o no
            if (!isTokenSentToServer()) {
                console.log('Sending token to server ...');
                // si el token se envía correctamente al servidor
                // luego establezca setTokenSentToServer en verdadero
                //AQUI INSERTO MI TOKEN POR ID,ROL,TOKEN
                guardarToken(currentToken);
                setTokenSentToServer(true)
            } else {
                //CHEQUEAR SI LO TENEMOS REGISTRADO CON UN CONSULTA DE TOKEN
                guardarToken(currentToken);
                console.log('Token ya disponible en el servidor');
            }
        }
        function isTokenSentToServer() 
        {
            return window.localStorage.getItem('sentToServer') === '1'
        }

        // Necesitamos establecer el valor de "sentToServer" en verdadero en el almacenamiento local.
        // Entonces, si enviamos por segunda vez, lo verificaremos desde el almacenamiento local
        function setTokenSentToServer(sent) 
        {
            window.localStorage.setItem('sentToServer', sent ? '1' : '0')
        }

        // Verificar si el navegador admite las notificaciones
        if ('Notification' in window) {
            Notification.requestPermission().then(function (permission) {
                if (permission === 'granted') {
                    // Permiso concedido, puedes recibir notificaciones
                    console.log("Permisos concedido");
                }
            });
        }
        //CHEQUEO LOS TOKEN PARA SABER SI EXISTE O LOS REGISTRO
        function guardarToken(token) {
            var userID    = <?php echo $userID ?>;              
            var empresaID = <?php echo $empresaID; ?>;
            var apiUrl    = '<?php echo constant('RUTA_URL'); ?>/rest-api/FirebaseReg'; 
            var data = { 
                usuarioID : userID,
                empresaID : empresaID,
                Token     : token
            } 
            fetch(apiUrl,{ 
                method : 'POST',  
                headers: {'Content-type' : 'application/json'},
                body   : JSON.stringify(data) 
            })
            .then(response => response.json() )
            .then(data => {
                console.log(data);
            }) 
        }

        function enLinea() {
            var userID    = <?php echo $userID ?>;              
            var empresaID = <?php echo $empresaID; ?>;
            var apiUrl='<?php echo constant('RUTA_URL'); ?>/rest-api/EstoyenLinea'; 
            var data = { 
                usuarioID : userID,
                empresaID : empresaID
            } 
            fetch(apiUrl,{ 
                method : 'PUT',  
                headers: {'Content-type' : 'application/json'},
                body   : JSON.stringify(data) 
            })
            .then(response => response.json() )
            .then(data => {
                console.log(data);
            }) 
        }
        enLinea(); // Ejecuta la función inmediatamente
        setInterval(enLinea, 7 * 60 * 1000); // Luego, cada 7 minutos
    </script>
    <?php } ?>
    </body>
</html>