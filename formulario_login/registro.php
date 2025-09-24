<?php

require ('conexion.php');

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$contraseña1 = $_POST['contraseña1'];
$contraseña2 = $_POST['contraseña2'];

if($contraseña1 == $contraseña2){
    $contraseña_hash = password_hash($contraseña1, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuario(nombre, apellido, correo, contraseña) VALUES (:nombre, :apell, :correo, :contrasena_hash)");
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apell', $apellido);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':contrasena_hash', $contraseña_hash);
    
    $stmt->execute();

    echo "Insertado correctamente";
    
} else {
    echo "Error, inténtalo de nuevo";
}

?>