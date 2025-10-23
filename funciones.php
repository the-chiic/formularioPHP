<?php

    require_once "configBD.php";

    function mostrarPaises(){
        //Declaramos el objeto donde guardamos la conexión y después hacemos que acepte todos los caracteres (ñ por ejemplo)
        $conexion=new mysqli(SERVER, USER, PASSWORD, BBDD);
        $conexion->set_charset("utf8");

        if(!$conexion){
            echo "<h3>NO CONECTÓ</h3>";
            exit();
        }

        //Creo el array donde guardaré los $paises
        $paises=[];

        //Ejecutamos la consulta
        $sql="SELECT idPais, nombrePais FROM paises ORDER BY nombrePais";
        //echo $sql;

        //Guardamos la consulta
        $resultado=$conexion->query($sql);

        //Si la consulta es diferente de false...
        if($resultado){
            //Recorro la consulta fila a fila
            while($fila=$resultado->fetch_assoc()){
                //Meto el nombre del pais en el array $paises
                $paises[$fila['idPais']]=$fila['nombrePais'];
            }
        }

        //Cierro la conexión
        $conexion->close();
        //var_dump($paises);
        //print_r($paises);
        //Devuelvo el array $paises
        return $paises;
    }

    function mostrarContactos(){
        //Declaramos el objeto donde guardamos la conexión y después hacemos que acepte todos los caracteres (ñ por ejemplo)
        $conexion=new mysqli(SERVER, USER, PASSWORD, BBDD);
        $conexion->set_charset("utf8");

        if(!$conexion){
            echo "<h3>NO CONECTÓ</h3>";
            exit();
        }

        //Creo el array donde guardaré los $contactos
        $contactos=[];

        //Ejecutamos la consulta
        $sql="SELECT idContacto, contacto FROM contactos";
        //echo $sql;

        //Guardamos la consulta
        $resultado=$conexion->query($sql);

        //Si la consulta es diferente de false...
        if($resultado){
            //Recorro la consulta fila a fila
            while($fila=$resultado->fetch_assoc()){
                //Meto el nombre del pais en el array $paises
                $contactos[$fila['idContacto']]=$fila['contacto'];
            }
        }

        //Cierro la conexión
        $conexion->close();

        //Devuelvo el array $contactos
        return $contactos;
    }

?>