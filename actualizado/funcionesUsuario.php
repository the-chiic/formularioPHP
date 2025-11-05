<?php

    require_once "conectar.php";

    class funcionesUsuario extends conectar{

        private $paises=[];
        private $contactos=[];
        private $datos=[];

        public function __construct(){
            parent::__construct();
        }

        public function mostrarPaises(){
            try{
                //Activar la notificación
                $controlador=new mysqli_driver();
                $controlador->report_mode=MYSQLI_REPORT_ALL;

                //Creo el array donde guardaré los $paises
                $this->paises=[];

                //Ejecutamos la consulta
                $sql="SELECT idPais, nombrePais FROM paises WHERE idPais>0 ORDER BY nombrePais";
                //echo $sql;

                //Guardamos la consulta
                $resultado=$this->conexion->query($sql);

                //Recorro la consulta fila a fila
                while($fila=$resultado->fetch_assoc()){
                    //Meto el nombre del pais en el array $paises
                    $this->paises[$fila['idPais']]=$fila['nombrePais'];
                }

                //var_dump($paises);
                //print_r($paises);
                //Devuelvo el array $paises
                return $this->paises;
            }catch(mysqli_sql_exception $e){
                echo $e->getMessage();	
                $num_error=$this->conexion->errno;  
                $texto_error=$this->conexion->error;  
                echo "<br/><br/><br/>Error: ".$num_error. " -- ".$texto_error;
                echo "<h3><a href='form.php'>VOLVER</a></h3>";
            }
        }

        public function mostrarContactos(){
            try{
                //Activar la notificación
                $controlador=new mysqli_driver();
                $controlador->report_mode=MYSQLI_REPORT_ALL;

                //Creo el array donde guardaré los $contactos
                $this->contactos=[];

                //Ejecutamos la consulta
                $sql="SELECT idContacto, contacto FROM contactos WHERE idContacto>0";
                //echo $sql;

                //Guardamos la consulta
                $resultado=$this->conexion->query($sql);

                //Recorro la consulta fila a fila
                while($fila=$resultado->fetch_assoc()){
                    //Meto el nombre del pais en el array $paises
                    $this->contactos[$fila['idContacto']]=$fila['contacto'];
                }

                //Devuelvo el array $contactos
                return $this->contactos;
            }catch(mysqli_sql_exception $e){
                echo $e->getMessage();	
                $num_error=$this->conexion->errno;  
                $texto_error=$this->conexion->error;  
                echo "<br/><br/><br/>Error: ".$num_error. " -- ".$texto_error;
                echo "<h3><a href='form.php'>VOLVER</a></h3>";
            }
        }

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