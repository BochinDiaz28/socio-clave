<?php
    //CLASE DE CONEXION A BASE DE DATOS PDO
    class Base{
        private $host = DB_HOST;
        private $usuario = DB_USUARIO;
        private $password = DB_PASSWORD;
        private $nombre_base = DB_NOMBRE;

        private $dbh;
        private $stmt;
        private $error;

        public function __construct(){
            //CONFIGURAR LA CONEXION
            $dsn = 'mysql:host=' . $this->host . ';dbname=' .$this->nombre_base;
            $opciones = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            //CREAR INSTANCIA PDO
            try {
                $this->dbh = new PDO($dsn, $this->usuario, $this->password, $opciones);
                $this->dbh->exec('set names utf8');
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }
        //PREPARAMOS LA CONSULTA
        public function query($sql){
            $this->stmt = $this->dbh->prepare($sql);
        }
        //VINCULAMOS LA CONSULTA Y DEFINIMOS EL TIPO DE DATO
        public function bind($parametro, $valor, $tipo=null){
            if(is_null($tipo)){
                switch (true){
                    case is_int($valor):
                        $tipo = PDO::PARAM_INT;
                    break;
                    case is_bool($valor):
                        $tipo = PDO::PARAM_BOOL;
                    break;
                    case is_null($valor):
                        $tipo = PDO::PARAM_NULL;
                    break;
                    default:
                        $tipo = PDO::PARAM_STR;
                    break;

                }

            }
            $this->stmt->bindValue($parametro, $valor, $tipo);

        }
        //EJECUTA LA CONSULTA
        public function execute(){
            return $this->stmt->execute();
        }

        //obtener los registros
        public function registros(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

        //obtener 1 REGISTRO
        public function registro(){
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

         //obtener cantidad de registros
         public function rowCount(){            
            return $this->stmt->rowCount();
        }
    }