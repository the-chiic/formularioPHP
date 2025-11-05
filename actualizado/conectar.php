<?php

    require_once "configBD.php";

    class conectar{
        protected $conexion;

        public function __construct(){
            $this->crear();
        }

        public function __destruct(){
            if($this->conexion){
                $this->conexion->close();
            }
        }

        public function crear(){
            //Declaramos el objeto donde guardamos la conexión y después hacemos que acepte todos los caracteres (ñ por ejemplo)
            $this->conexion=new mysqli(SERVER, USER, PASSWORD, BBDD);
            $this->conexion->set_charset("utf8");
        }

    }

?>