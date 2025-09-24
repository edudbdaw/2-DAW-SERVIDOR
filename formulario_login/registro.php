<?php

require ('conexion.php');
session_start();


$nombre = isset($_POST['nombre']) ? ($_POST['nombre']) : '';
$apellido = isset($_POST['apellido']) ? ($_POST['apellido']) : '';
$correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
$contraseña1 = isset($_POST['contraseña1']) ? $_POST['contraseña1'] : '';
$contraseña2 = isset($_POST['contraseña2']) ? $_POST['contraseña2'] : '';

$_SESSION['nombreuser'] = $nombre;
$_SESSION['apellidouser'] = $apellido;
$_SESSION['correouser'] = $correo;
$_SESSION['contraseña1user'] = $contraseña1;
$_SESSION['contraseña2user'] = $contraseña2;

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
    header('Location: registroform.php');
}

?>
