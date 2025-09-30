<?php
// login.php

require 'conexion.php';
session_start();

$correo = trim($_POST['correo'] ?? '');
$contraseña = $_POST['contraseña'] ?? '';

// 1. Validar campos no vacíos
if (empty($correo) || empty($contraseña)) {
    $_SESSION['errores_login'] = "Por favor, introduce tu email y contraseña.";
    header('Location: login.html');
    exit();
}

try {
    // 2. Buscar el usuario en la base de datos
    $stmt = $conn->prepare("SELECT id, nombre, contraseña FROM usuario WHERE correo = :correo");
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // 3. Verificar si el usuario existe y la contraseña es correcta
    if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
        // Login exitoso, guardar datos en la sesión
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_name'] = $usuario['nombre'];
        
        header('Location: dashboard.php');
        exit();
    } else {
        // Credenciales incorrectas
        $_SESSION['errores_login'] = "Email o contraseña incorrectos.";
        header('Location: login.html');
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['errores_login'] = "Error de login: " . $e->getMessage();
    header('Location: login.html');
    exit();
}
?>