<?php
session_start();
require 'connbbdd.php';

$username = $_POST['username'] ?? '';
$correoUser = $_POST['correoUser'] ?? '';
$password1 = $_POST['password1'] ?? '';
$password2= $_POST['password2'] ?? '';

$errores = [];

if (empty($username)) {
    $errores[] = 'Debe introducir un usuario';
}

if (!filter_var($correoUser , FILTER_VALIDATE_EMAIL)) {
    $errores[] = 'Debe introducir un correo electronico valido';
}

if ($password1 !== $password2) {
    $errores[] = 'Las contraseñas no coinciden';
}

if (!empty($errores)) {

    $_SESSION['inputsB'] = [
        'username' => $username,
        'correoUser' => $correoUser
    ];

    $_SESSION['errores'] = $errores;
    header('Location:form_registro.php');
    exit();
}