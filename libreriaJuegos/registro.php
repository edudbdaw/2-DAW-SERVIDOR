<?php
session_start();
require 'connbbdd.php';

//Verificacion de si la base de datos esta funcionando
if (!isset($conn)) {
    echo "error con la base de datos";
    die();
}

//Variables del formulario
$username = $_POST['username'] ?? '';
$correoUser = $_POST['correoUser'] ?? '';
$password1 = $_POST['password1'] ?? '';
$password2= $_POST['password2'] ?? '';

$errores = [];

//funcion manejos de errores
function manejoErrores($errores_añadir) {
    if (!empty($errores_añadir)) {
        $_SESSION['errores'] = $errores_añadir;
        header('Location:form_registro.php');
        exit();
    } 
}

// Validaciones
if (empty($username)) {
    $errores[] = 'Debe introducir un usuario';
}

if (!filter_var($correoUser , FILTER_VALIDATE_EMAIL)) {
    $errores[] = 'Debe introducir un correo electronico valido';
}

// Validaciones contraseñas


if ($password1 !== $password2) {
    $errores[] = 'Las contraseñas no coinciden';
} 

$patron_contraseña = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()-=_+{};:,<.>]).{8,20}$/';
if(!preg_match($patron_contraseña , $password1)){
    $errores[] = 'La contraseña debe ser de 8 caracteres minimo , contener un simbolo , mayusculas y minusculas';
} else {
    $password = password_hash($password1,PASSWORD_DEFAULT);
}


// Manejo de errores en validaciones
if (!empty($errores)) {

    $_SESSION['inputsB'] = [
        'username' => $username,
        'correoUser' => $correoUser
    ];

    manejoErrores($errores);
}

// Consulta de email y user unico

try {
    $stmt = $conn -> prepare("SELECT COUNT(*) from usuarios where email = :correoUser");
    $stmt ->bindParam(':correoUser' , $correoUser);
    $stmt -> execute();

    if ($stmt -> fetchColumn() > 0) {
        $errores [] = "Error , ya existe el correo electronico";
    }
} catch (PDOException $e) {
    $errores [] = 'Error al verificar el email'. $e->getMessage();
}

try {
    $stmt = $conn -> prepare("SELECT COUNT(*) from usuarios where username = :username");
    $stmt -> bindParam(':username', $username);
    $stmt -> execute();

    if ($stmt->fetchColumn() > 0) {
        $errores[] = "Este usuario ya existe , use otro"; 
    }
} catch (PDOException $e) {
    $errores[] = "Error al verificar el usuario" . $e->getMessage();
}

//Manejamos los errores
manejoErrores($errores);

//Insertar datos en la bbdd
try {
    $stmt = $conn -> prepare("INSERT INTO usuarios (usename, email, password, profile_pic_path) VALUES(:username , :correoUser, :password, :fotoPerfil)");
} catch (PDOException $e) {
    $errores[] = 'Error al insertar datos'. $e->getMessage();
}

