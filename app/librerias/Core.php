<?php
    //MAPERAR LA URL INGRESADA EN NAVEGADOR
    /*
        1-CONTROLADOR
        2-METODO
        3-PARAMETROS
        EJ: url__ CONTROLADOR/METODO/PARAMETRO
    */
    class Core{
        //SIEMPRE QUE NO SE CARGUE NINGUN CONTROLADOR DEBE CARGAR PAGINAS
        protected $controladorActual = 'paginas';
        //CUANDO NO EXISTA MEDOTO DEBE CARGAR INDEX
        protected $metodoActual ='index';
        //CUANDO NO EXISTA PARAMETROS DEBE CARGAR ARRAY VACIO
        protected $parametros = [];

        //METODO QUE SE CARGA AUTOMATICAMENTE UNA VEZ INSTANCIADA LA CLASE EN public/index.php
        public function __construct(){
            //print_r($this->getUrl());
            $url = $this->getUrl();
            //COMPROBAMOS SI EXISTE ALGO EN URL, DE SER FALSE CALGO SOLO CONTROLADOR ACTUAL
            if (isset($url[0])) {	
                //EVALUAMOS SI LOS ARCHIVOS LLAMADOS EXISTEN DENTRO DE CONTROLADORES
                if(file_exists('../app/controladores/'. ucwords($url[0]).'.php')){
                    //SI EXISTE SE SETEA COMO CONTROLADOR POR DEFECTO
                    $this->controladorActual= ucwords($url[0]);

                    //UNSET PARA DESMONTAR EL CONTROLAR ACTUAL
                    unset($url[0]);
                }
            }
            //LLAMAR EL NUEVO CONTROLARO
            require_once '../app/controladores/' . $this->controladorActual . '.php';
            $this->controladorActual = new $this->controladorActual;

            if (isset($url[1])) {	
                //VERFICAR LA SEGUNDA PARTE DE LA URL 'EL METODO'
                if(method_exists($this->controladorActual, $url[1])){
                    //SI EXISTE REVISAMO EL METODO
                    $this->metodoActual = $url[1]; 
                    //UNSET PARA DESMONTAR EL METODO ACTUAL
                    unset($url[0]);
                    unset($url[1]);
                }
            }
             //PARA PROBAR EL METODO   
            //echo $this->metodoActual;

            //OBTENER LOS PARAMETROS
            $this->parametros = $url ? array_values($url) : [];
            //LLAMAR CALLBACK CON PARAMETROS ARRAY
            call_user_func_array([$this->controladorActual, $this->metodoActual], $this->parametros);


        }

        //URL LA TOMA DEL /public .HTACCESS
        public function getUrl(){
            //echo $_GET['url'];
            if(isset($_GET['url'])){
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                return $url;
            }

        }

    }    