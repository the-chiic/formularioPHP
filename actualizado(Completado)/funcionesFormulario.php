<?php

    class funcionesFormulario{
        private $datos=[];

        public function validarDatos(){

            //Comprobamos que no este vacío ni que haya espacios en el apartado nombre
            if(empty($_POST["name"]) || !trim($_POST["name"])){
                throw new Exception("NO PUSISTE EL NOMBRE");
            }
            $this->datos["nombre"]=$_POST["name"];

            //Comprobamos que no este vacío ni que haya espacios en el apartado apellido
            if(empty($_POST["surname"]) || !trim($_POST["surname"])){
                throw new Exception("NO PUSISTE EL APELLIDO");
            }
            $this->datos["apellido"]=$_POST["surname"];

            //Comprobamos que no este vacío ni que haya espacios en el apartado pw
            if(empty($_POST["password"]) || !trim($_POST["password"])){
                throw new Exception("NO PUSISTE LA CONTRASEÑA");
            }
            $this->datos["pw"]=$_POST["password"];

            //Valido que el país este seleccionado
            if(!isset($_POST["selectCountry"]) || $_POST["selectCountry"]==0){
                throw new Exception("NO PUSISTE EL PAÍS");
            }
            $this->datos["pais"]=$_POST["selectCountry"];

            //Comprueba que no sea null el checkbox
            if(!isset($_POST["condition"])){
                throw new Exception("NO PUSISTE LOS CHECKBOXS");
            }
            $this->datos["condicion"]=$_POST["condition"];

            //Devolvemos todo en un array asociativo
            return $this->datos;
        }
    
    }

?>