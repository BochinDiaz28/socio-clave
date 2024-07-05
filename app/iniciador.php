<?php
    if(!isset($_SESSION)){
        session_start();
    }
    //CARGAMOS TODAS LAS LIBRERIAS
    require_once 'config/configurar.php';

    //AUTOLOAD PARA LIBRERIAS PHP
    spl_autoload_register(function($nombreClase){
        require_once 'librerias/'.$nombreClase .'.php';
    });

    