<?php

require 'conexion.php';
session_start();

$errores = [];

$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$correo = $_POST['correo'];
$contrasena1 = trim($_POST['contrasena1']);
$contrasena2 = trim($_POST['contrasena2']);
$fotoP = $_FILES['fotoPerfil'] ?? null ;
//'uploads/fotosP/default.png'

// FOTO PERFIL
if ($fotoP['error']!== UPLOAD_ERR_OK) {
    $errores[]= "Error al subir la foto de perfil";
} else  {
    $permitidos = ['image/jpeg', 'image/png'];

    if (!in_array($fotoP['type'], $permitidos)) {
        $errores[] = "Solose permiten imagenes JPEG y PNG";
    }
}

if (empty($nombre) || empty($apellidos) || empty($correo) || empty($contrasena1) || empty($contrasena2)) {
    $errores[] = "Debe rellenarse todos los huecos";
}

if (!filter_var($correo , FILTER_VALIDATE_EMAIL)) {
    $errores[] = "Formato de email incorrecto";
}

if ($contrasena1 !== $contrasena2) {
    $errores[] = "Error , las contraseñas no coinciden";
} else {
    $passwd_hash = password_hash($contrasena1 , PASSWORD_BCRYPT);
}

if (strlen($contrasena1)<8) {
    $errores [] = "La contrseña debe tener al menos 8 caracteres";
}

try {
    $stmt = $conn -> prepare("Select COUNT(*) from usuarios where correo = :correo");
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
    //FOTO P
    $extension = pathinfo($fotoP['name'], PATHINFO_EXTENSION);
    $nombre_aleatorio = uniqid().'.'.$extension;
    $ruta_destino = 'uploads/fotosP/'.$nombre_aleatorio;

    if(!move_uploaded_file($fotoP['tpm_name'], $ruta_destino)){
        throw new Exception("Error al guardar el archivo");
    };

    //ACORDARME NO USAR ñ POR SI ACASO ME DE ERRORES COMO Invalid parameter number: parameter was not defined
    $stmt = $conn->prepare('INSERT INTO usuarios( nombre, apellido, correo, password, fotoP) VALUES(:nombre, :apellido, :correo, :contrasena, :fotoP)');

    
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellidos);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':contrasena', $passwd_hash); 
    $stmt->bindParam(':fotoP', $fotoP);

    $stmt->execute();
    echo "registro exitoso¡¡";
    
    $_SESSION['exito'] = "Registro exitoso";
    header('Location:loginform.php');
    
}catch(PDOException $e){
    $_SESSION['errores'] = ["Error al registrar al usuario". $e->getMessage()];
    header('Location:registroform.php');
    exit();
}