<?php
//CONFIGURACION DE ACCESO DE BD
/*
define('DB_HOST', 'localhost');
define('DB_USUARIO','root');
define('DB_PASSWORD','');
define('DB_NOMBRE','paqueteria');
^ no utilizaremos este camino de base de datos
  pero lo creo por si las moscas.
  utilizar rest-api
*/

//RUTA DE LA APLICACION
define('RUTA_APP', dirname(dirname(__FILE__)));

//RUTA DE LA URL SITIO MONTADO
define('RUTA_URL', 'http://127.0.0.1/SocioClaveMVC');

//RUTA DE LA URL REST
define('RUTA_REST', 'http://127.0.0.1/SocioClaveMVC');

//NOMBRE DEL SITIO
define('NOMBRE_SITIO', 'TASKNOW');