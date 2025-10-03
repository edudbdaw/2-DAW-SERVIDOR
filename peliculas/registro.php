<?php

require 'conexion.php';
session_start();

$errores = [];

$nombre = $_POST['nombre'];
$apellidos = $_POST['apellido'];
$correo = $_POST['correo'];
$contraseña1 = trim($_POST['contraseña1']);
$contraseña2 = trim($_POST['contraseña2']);
$contraseña_hash;

if (empty($nombre) || empty($apellidos) || empty($correo) || empty($contraseña1) || empty($contraseña2)) {
    $errores[] = "Debe rellenarse todos los huecos";
}

if (!filter_var($correo , FILTER_VALIDATE_EMAIL)) {
    $errores[] = "Formato de email incorrecto";
}

if ($contraseña1 !== $contraseña2) {
    $errores[] = "Error , las contraseñas no coinciden";
} else {
    $contraseña_hash = password_hash($contraseña1 , PASSWORD_BCRYPT);
}

if (strlen($contraseña1)<8) {
    $errores [] = "La contrseña debe tener al menos 8 caracteres";
}

try {
    $stmt = $conn -> prepare("Select COUNT(*) from usuario where correo = :correo");
    $stmt-> bindParam(':correo' , $correo);
    $stmt -> execute();

    if ($stmt -> fetchColumn() > 0) {
        $errores[] = "Error , ya existe el correo electronico ";
    }
} catch (PDOException $e) {
    $errores[] = "Error al verificar el email". $e->getMessage();
}

if(!empty($errores)) {
    $_SESSION['errores'] = $errores;
    $_SESSION['inputs'] = $inputs;
    header('Location:registroform.php');
    exit();
}  

try{
    $stmt = $conn->prepare('INSERT INTO usuarios( nombre, apellido, correo, contraseña) VALUES(:nombre, :apellido, :correo, :contraseña)');
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellidos);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':contraseña', $contraseña_hash);
    $stmt -> execute();

    $_SESSION['exito'] = "Registro exitoso";
    header('Location:loginform.php');

}catch(PDOException $e){
    $_SESSION['errores'] = ["Error al registrar al usuario". $e->getMessage()];
    header('Location:registroform.php');
    exit();
}