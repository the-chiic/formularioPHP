<?php

    require_once "configBD.php";

    //Comprobamos que no este vacío ni que haya espacios en el apartado nombre
    if(!empty($_POST["name"]) && trim($_POST["name"])){
        $nombre=$_POST["name"];
    }else{
        echo "<h3>NO PUSISTE EL NOMBRE</h3>";
        echo "<h3><a href='form.php'>VOLVER</a></h3>";
        exit();
    }

    //Comprobamos que no este vacío ni que haya espacios en el apartado apellido
    if(!empty($_POST["surname"]) && trim($_POST["surname"])){
        $apellido=$_POST["surname"];
    }else{
        echo "<h3>NO PUSISTE EL APELLIDO</h3>";
        echo "<h3><a href='form.php'>VOLVER</a></h3>";
        exit();
    }

    //Comprobamos que no este vacío ni que haya espacios en el apartado pw
    if(!empty($_POST["password"]) && trim($_POST["password"])){
        $pw=$_POST["password"];
    }else{
        echo "<h3>NO PUSISTE LA CONTRASEÑA</h3>";
        echo "<h3><a href='form.php'>VOLVER</a></h3>";
        exit();
    }

    //Valido que el país este seleccionado sino valdrá 0
    if(isset($_POST["selectCountry"]) && $_POST["selectCountry"]!=0){
        $pais=$_POST["selectCountry"];
    }else{
        $pais=0;
    }


    //Declaramos el objeto donde guardamos la conexión y después hacemos que acepte todos los caracteres (ñ por ejemplo)
    $conexion=new mysqli(SERVER, USER, PASSWORD, BBDD);
    $conexion->set_charset("utf8");

    //Valido que se ejecuta la conexión con la BBDD
    if(!$conexion){
        echo "<h3>NO CONECTÓ</h3>";
        exit();
    }

    //Concatenamos la consulta y hacemos dos opciones por si no hay paises
    if($pais!=0){
        $sql="INSERT INTO usuarios(nombreUser,apellidos,pw,idPais) VALUES ('".$nombre."', '".$apellido."', '".$pw."', ".$pais.")";
        //echo $sql;
    }else{
        $sql="INSERT INTO usuarios(nombreUser,apellidos,pw,idPais) VALUES ('".$nombre."', '".$apellido."', '".$pw."', NULL)";
        //echo $sql;
    }

    //Ejecutamos la consulta
    $resultado=$conexion->query($sql);

    if(!$resultado){
        echo "<h3>ERROR EN LA CONSULTA INSERT USUARIOS</h3>";
        echo "<h3><a href='form.php'>VOLVER</a></h3>";
        exit();
    }else{
        echo "<h3>INSERTADOS</h3>";
        echo "<h4>Nombre: ".$nombre."</h4>";
        echo "<h4>Apellido: ".$apellido."</h4>";
        echo "<h4>Contraseña: ".$pw."</h4>";

        //Recupero el id de la consulta anterior con la propiedad insert_id de el objeto mysqli
        $idUsuario=$conexion->insert_id; //Antes de la siguiente consulta porque sino perdemos el id

        //Pais no obligatorio
        if($pais==0){
            echo "<h3>NO SELECCIONASTE UN PAÍS</h3>";
        }else{
            echo "<h4>País: ";

            //Guardamos la consulta
            $sql2="SELECT * FROM paises";
            //echo $sql2;

            //Ejecutamos la consulta
            $resultado2=$conexion->query($sql2);

            //Valido que se ejecuta la consulta correctamente y sea diferente de false
            if(!$resultado2){
                echo "<h3>ERROR EN LA CONSULTA SELECT PAISES</h3>";
                echo "<h3><a href='form.php'>VOLVER</a></h3>";
                exit();
            }else{
                //Recorro fila a fila el resultado de la consulta
                while($fila=$resultado2->fetch_assoc()){
                    //Miro si es igual el idPais del formulario al idPais de la BBDD y luego le meto a $nombrePais el nombrePais de la BBDD
                    if($fila['idPais']==$pais){
                        $nombrePais=$fila['nombrePais'];
                        echo $nombrePais."</h4>";
                    }
                }
            }
        }
    }

    //Valido si selecciono o no los checkboxs
    if(!isset($_POST["condition"])){
        echo "<h3>NO SELECCIONASTE LOS CHECKBOXS</h3>";
    }else{
        $condicion=$_POST["condition"];

        echo "<h4>Contactos: ";

        //Introducimos cada contacto con su idUsuario
        foreach($condicion as $i=>$cond){
            //Guardamos la consulta
            $sql3="INSERT INTO user_contactos(idUser, idContacto) VALUES (".$idUsuario.", ".$cond.")";
            //echo $sql2;

            //Ejecutamos la consulta
            $resultado3=$conexion->query($sql3);

            if(!$resultado3){
                echo "<h3>ERROR EN LA CONSULTA INSERT CONTACTOS</h3>";
                echo "<h3><a href='form.php'>VOLVER</a></h3>";
                exit();
            }else{
                //Guardamos la consulta
                $sql4="SELECT * FROM contactos";

                //Ejecutamos la consulta
                $resultado4=$conexion->query($sql4);

                //Valido que se ejecuta la consulta correctamente y sea diferente de false
                if(!$resultado4){
                    echo "<h3>ERROR EN LA CONSULTA SELECT CONTACTOS</h3>";
                    echo "<h3><a href='form.php'>VOLVER</a></h3>";
                    exit();
                }else{
                    //Recorro fila a fila el resultado de la consulta
                    while($fila=$resultado4->fetch_assoc()){
                        //Miro si es igual el idContacto del formulario al idCOntacto de la BBDD y luego le meto a $nombreContacto el contacto de la BBDD
                        if($fila['idContacto']==$cond){
                            $nombreCondicion=$fila['contacto'];
                            echo $nombreCondicion." ";
                        }
                    }
                }
            }
        }
        echo "</h4>";
    }

    $conexion->close();

?>