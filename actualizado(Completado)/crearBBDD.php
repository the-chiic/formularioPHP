<?php

    require_once "configBD.php";


    $conexion=new mysqli(SERVER, USER, PASSWORD);
    $conexion->set_charset("utf8");

    $sql=
        "CREATE DATABASE IF NOT EXISTS formulario;
        USE formulario;

        CREATE TABLE IF NOT EXISTS paises(
            idPais tinyint AUTO_INCREMENT,
            nombrePais varchar(30) NOT NULL,
            constraint pk_paises PRIMARY KEY (idPais),
            CONSTRAINT uni_nombrePais UNIQUE (nombrePais)
        );

        CREATE TABLE IF NOT EXISTS usuarios(
            idUser smallint AUTO_INCREMENT,
            nombreUser varchar(30) NOT NULL,
            apellidos varchar(40) NOT NULL,
            pw varchar(30) NOT NULL,
            idPais tinyint NOT NULL,
            /*idPais tinyint NULL,*/
            constraint pk_usuarios PRIMARY KEY (idUser),
            constraint fk_paises FOREIGN KEY (idPais) REFERENCES paises(idPais)
        );

        CREATE TABLE IF NOT EXISTS contactos(
            idContacto tinyint AUTO_INCREMENT,
            contacto varchar(30) NOT NULL,
            constraint pk_contactos PRIMARY KEY (idContacto),
            CONSTRAINT uni_contacto UNIQUE (contacto)
        );

        CREATE TABLE IF NOT EXISTS user_contactos(
            idUser smallint,
            idContacto tinyint,
            constraint pk_user_contactos PRIMARY KEY (idUser, idContacto),
            constraint fk_idUser FOREIGN KEY (idUser) REFERENCES usuarios(idUser),
            constraint fk_idContacto FOREIGN KEY (idContacto) REFERENCES contactos(idContacto)
        );

        /*TRUNCATE TABLE paises;
        TRUNCATE TABLE usuarios;
        TRUNCATE TABLE contactos;
        TRUNCATE TABLE user_contactos;*/

        INSERT INTO paises(nombrePais) VALUES 
            ('España'),
            ('Francia'),
            ('Portugal'),
            ('Perú');
        
        INSERT INTO contactos(contacto) VALUES 
            ('Teléfono'),
            ('Correo'),
            ('Presencial');

        ";
    //echo $sql;

    if ($conexion->multi_query($sql)) {
        //echo "<h3>Base de datos y tablas creadas correctamente.</h3>"; //Uso la multiquery ínicamente para la creación de la bbdd y los insert
    }else{
        echo "<h3>ERROR!</h3>";
    }

    $conexion->close();

?>