<?php 

require 'coneccion.php';

if ($conn) {
    
    $stmt = $conn -> prepare ("INSERT INTO usuario (nom , apell, correo) VALUES (:nom ,:apell , :correo)");
    $stmt -> bindParam(':nom' , $nombre);
    $stmt -> bindParam(':apell' , $apellido);
    $stmt -> bindParam(':correo' , $correo_e);

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apell'];
    $correo_e = $_POST['correo'];

    $stmt -> execute();

    echo "Insertado Correctamente";

}