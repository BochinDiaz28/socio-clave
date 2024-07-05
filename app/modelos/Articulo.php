<?php

    class Articulo{
        private $db;

        public function __construct(){
            $this->db = new Base;
        }

        //OBTIENE LOS DATOS DE LA EMPRESA
        public function obtenerArticulos(){
            $this->db->query("SELECT * FROM usuarios a, empresas b 
                              WHERE a.idempresa=b.idempresa
                              AND a.id='1'");
            return $this->db->registros();
        }
        
        


    }