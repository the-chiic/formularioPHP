<?php

    require_once "configBD.php";
    require_once "funcionesUsuario.php";

        try{
            //Activar la notificación
            $controlador=new mysqli_driver();
            $controlador->report_mode=MYSQLI_REPORT_ALL;

            $datos=new funcionesUsuario();
            $datos=$validar->validarDatos();

            $nombre=$datos["nombre"];
            $apellido=$datos["apellido"];
            $pw=$datos["pw"];
            $pais=$datos["pais"];
            $condicion=$datos["condicion"];


            //Declaramos el objeto donde guardamos la conexión y después hacemos que acepte todos los caracteres (ñ por ejemplo)
            $conexion=new mysqli(SERVER, USER, PASSWORD, BBDD);
            $conexion->set_charset("utf8");

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

            $conexion->close();
        //Captura errores de la conexion
        }catch(mysqli_sql_exception $e){
            echo "<h3>ERROR</h3>";
            echo "<h3>".$e->getMessage()."</h3>";
            $num_error=$conexion->errno;  
            $texto_error=$conexion->error;  
            echo "<br/><br/><br/>Error: ".$num_error. " -- ".$texto_error;
            echo "<h3><a href='form.php'>VOLVER</a></h3>";
        //Captura errores míos
        }catch(Exception $e){
            echo "<h3>ERROR</h3>";
            echo "<h3>".$e->getMessage()."</h3>";
            echo "<h3><a href='form.php'>VOLVER</a></h3>";
        }

    /*}*/

?>