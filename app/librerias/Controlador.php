<?php
//CLASE CONTROLADOR PRINCIPAL
//SE ENCARGA DE CARGAR MODELOS Y VISTAS
class Controlador{
    //CARGAR MODELO
    public function modelo($modelo){
        //cargamos modelo recibido
        require_once '../app/modelos/' . $modelo . '.php';
        return new $modelo();
    }

    //CARGAR VISTA  
    public function vista($vista, $datos= []){
        //COMPROBAMOS QUE VISTAS EXISTA
        if(file_exists('../app/vistas/' . $vista . '.php')){
            require_once '../app/vistas/' . $vista . '.php';
        }else{
            //MOSTRAR PAGINA 404
            die('La vista no existe');
        }
    }
}