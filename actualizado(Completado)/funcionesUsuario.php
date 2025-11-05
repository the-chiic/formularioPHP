<?php

    require_once "conectar.php";

    class funcionesUsuario extends conectar{
        private $paises=[];
        private $contactos=[];

        public function __construct(){
            parent::__construct();
        }

        public function mostrarPaises(){
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
        }

        public function mostrarContactos(){
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
        }

        public function insertarUsuarios($conexion, $nombre, $apellido, $pw, $pais, $condicion){
            //Concatenamos la consulta
            $sql="INSERT INTO usuarios(nombreUser,apellidos,pw,idPais) VALUES ('".$nombre."', '".$apellido."', '".$pw."', ".$pais.")";
            //echo $sql;

            //Ejecuta la consulta con la función query() del objeto mysqli en este caso en la variable $conexion y lo guardamos en $resultado
            $resultado=$conexion->query($sql);

            echo "<h3>INSERTADOS</h3>";
            echo "<h4>Nombre: ".$nombre."</h4>";
            echo "<h4>Apellido: ".$apellido."</h4>";
            echo "<h4>Contraseña: ".$pw."</h4>";

            //Recupero el id de la consulta anterior con la propiedad insert_id de el objeto mysqli
            $idUsuario=$conexion->insert_id; //Antes de la siguiente consulta porque sino perdemos el id

            echo "<h4>País: ";

            //Guardamos la consulta
            $sql2="SELECT * FROM paises WHERE idPais=".$pais.";";
            //echo $sql2;

            //Ejecutamos la consulta
            $resultado2=$conexion->query($sql2);

            //Recorro fila a fila el resultado de la consulta
            if($fila=$resultado2->fetch_assoc()){
                $nombrePais=$fila['nombrePais'];
                echo $nombrePais."</h4>";
            }

            $this->insertarContactos($idUsuario, $conexion, $condicion);
        }

        public function insertarContactos($idUsuario, $conexion, $condicion){
            echo "<h4>Contactos: ";

            //Introducimos cada contacto con su idUsuario
            foreach($condicion as $i=>$cond){
                //Guardamos la consulta
                $sql3="INSERT INTO user_contactos(idUser, idContacto) VALUES (".$idUsuario.", ".$cond.")";
                //echo $sql3;

                //Ejecutamos la consulta
                $resultado3=$conexion->query($sql3);
                
                //Guardamos la consulta
                $sql4="SELECT * FROM contactos WHERE idContacto=".$cond.";";
                //echo $sql4;

                //Ejecutamos la consulta
                $resultado4=$conexion->query($sql4);

                //Recorro fila a fila el resultado de la consulta
                if($fila=$resultado4->fetch_assoc()){
                    $nombreCondicion=$fila['contacto'];
                    echo $nombreCondicion." ";
                }
            }
            echo "</h4>";
        }
    
    }

?>