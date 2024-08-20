
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo constant('NOMBRE_SITIO'); ?> | <?php echo $datos['titulo']?></title>
     
        <link rel="apple-touch-icon"      sizes="180x180" href="<?php echo constant('RUTA_URL'); ?>/public/assets/img/favicons/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32"   href="<?php echo constant('RUTA_URL'); ?>/public/assets/img/favicons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16"   href="<?php echo constant('RUTA_URL'); ?>/public/assets/img/favicons/favicon-16x16.png">
        <link rel="shortcut icon" type="image/x-icon"     href="<?php echo constant('RUTA_URL'); ?>/public/assets/img/favicons/favicon.ico">
        <link rel="manifest"                              href="<?php echo constant('RUTA_URL'); ?>/public/manifest.json">
        
        <meta name="theme-color" content="#ffffff">
        <script src="<?php echo constant('RUTA_URL'); ?>/public/assets/js/config.js"></script>
        <script src="<?php echo constant('RUTA_URL'); ?>/public/vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>

        <link href="<?php echo constant('RUTA_URL'); ?>/public/vendors/swiper/swiper-bundle.min.css" rel="stylesheet" />
        <?php if ($_SESSION['rol']==200) {?>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
            <style>
                .poppins-thin {
                    font-family: "Poppins", sans-serif;
                    font-weight: 100;
                    font-style: normal;
                }

                .poppins-extralight {
                    font-family: "Poppins", sans-serif;
                    font-weight: 200;
                    font-style: normal;
                }

                .poppins-light {
                    font-family: "Poppins", sans-serif;
                    font-weight: 300;
                    font-style: normal;
                }

                .poppins-regular {
                    font-family: "Poppins", sans-serif;
                    font-weight: 400;
                    font-style: normal;
                }

                .poppins-medium {
                    font-family: "Poppins", sans-serif;
                    font-weight: 500;
                    font-style: normal;
                }

                .poppins-semibold {
                    font-family: "Poppins", sans-serif;
                    font-weight: 600;
                    font-style: normal;
                }

                .poppins-bold {
                    font-family: "Poppins", sans-serif;
                    font-weight: 700;
                    font-style: normal;
                }

                .poppins-extrabold {
                    font-family: "Poppins", sans-serif;
                    font-weight: 800;
                    font-style: normal;
                }

                .poppins-black {
                    font-family: "Poppins", sans-serif;
                    font-weight: 900;
                    font-style: normal;
                }

                .poppins-thin-italic {
                    font-family: "Poppins", sans-serif;
                    font-weight: 100;
                    font-style: italic;
                }

                .poppins-extralight-italic {
                    font-family: "Poppins", sans-serif;
                    font-weight: 200;
                    font-style: italic;
                }

                .poppins-light-italic {
                    font-family: "Poppins", sans-serif;
                    font-weight: 300;
                    font-style: italic;
                }

                .poppins-regular-italic {
                    font-family: "Poppins", sans-serif;
                    font-weight: 400;
                    font-style: italic;
                }

                .poppins-medium-italic {
                    font-family: "Poppins", sans-serif;
                    font-weight: 500;
                    font-style: italic;
                }

                .poppins-semibold-italic {
                    font-family: "Poppins", sans-serif;
                    font-weight: 600;
                    font-style: italic;
                }

                .poppins-bold-italic {
                    font-family: "Poppins", sans-serif;
                    font-weight: 700;
                    font-style: italic;
                }

                .poppins-extrabold-italic {
                    font-family: "Poppins", sans-serif;
                    font-weight: 800;
                    font-style: italic;
                }

                .poppins-black-italic {
                    font-family: "Poppins", sans-serif;
                    font-weight: 900;
                    font-style: italic;
                }
       

            </style>
        <?php }else{ ?>
            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
        <?php } ?>
        

        <link href="<?php echo constant('RUTA_URL'); ?>/public/vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet">
        <link href="<?php echo constant('RUTA_URL'); ?>/public/assets/css/theme-rtl.min.css" rel="stylesheet" id="style-rtl">
        <link href="<?php echo constant('RUTA_URL'); ?>/public/assets/css/theme.min.css" rel="stylesheet" id="style-default">
        <link href="<?php echo constant('RUTA_URL'); ?>/public/assets/css/user-rtl.min.css" rel="stylesheet" id="user-style-rtl">
        <link href="<?php echo constant('RUTA_URL'); ?>/public/assets/css/user.min.css" rel="stylesheet" id="user-style-default">
        <link href="<?php echo constant('RUTA_URL'); ?>/public/vendors/datatables-bs4/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="<?php echo constant('RUTA_URL'); ?>/public/vendors/datatables.net-responsive-bs4/responsive.bootstrap4.css" rel="stylesheet">

        

        <link href="<?php echo constant('RUTA_URL'); ?>/public/vendors/fullcalendar/main.min.css" rel="stylesheet" />

        <link rel="stylesheet" href="<?php echo constant('RUTA_URL'); ?>/public/vendors/toastr/toastr.min.css">
        <!-- ===============================================-->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <link href="<?php echo constant('RUTA_URL'); ?>/public/vendors/flatpickr/flatpickr.min.css" rel="stylesheet">

        <link href="<?php echo constant('RUTA_URL'); ?>/public/css/estilos.css" rel="stylesheet" id="">
        <script>
            var isRTL = JSON.parse(localStorage.getItem('isRTL'));
            if (isRTL) {
                var linkDefault = document.getElementById('style-default');
                var userLinkDefault = document.getElementById('user-style-default');
                linkDefault.setAttribute('disabled', true);
                userLinkDefault.setAttribute('disabled', true);
                document.querySelector('html').setAttribute('dir', 'rtl');
            } else {
                var linkRTL = document.getElementById('style-rtl');
                var userLinkRTL = document.getElementById('user-style-rtl');
                linkRTL.setAttribute('disabled', true);
                userLinkRTL.setAttribute('disabled', true);
            }
        </script>


    </head>
    <body>
    <main class="main" id="top">
        <div class="container-fluid" data-layout="container"> <!--SE CIERRA EN FOOTER-->
      
          
       