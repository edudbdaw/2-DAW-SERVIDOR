<?php
require 'conexion.php';
session_start();

$errores = [];

$correo = $_POST['correo'] ?? '';
$contrasena = $_POST['passwd'] ?? '';

if (empty($correo) || empty($contrasena)) {
    $errores[] = "Faltan campos por rellenar.";
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El correo no es válido.";
}

if (!empty($errores)) {
    $_SESSION['errores'] = $errores;
    header('Location: loginform.php');
    exit();
}

try {
    $stmt = $conn->prepare("SELECT id, nombre, password FROM usuarios WHERE correo = :correo");
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();
    
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($contrasena, $usuario['password'])) {
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_name'] = $usuario['nombre'];

        $_SESSION['mensaje_exito'] = "¡Bienvenido, " . htmlspecialchars($usuario['nombre']) . "!";
        header('Location: subirpeliculasform.php');
        exit();
    } else {
        $errores[] = "Email o contraseña incorrectos.";
        $_SESSION['errores'] = $errores;
        header('Location: loginform.php');
        exit();
    }
} catch (PDOException $e) {
    $errores[] = "Error al loguearse: " . $e->getMessage();
    $_SESSION['errores'] = $errores;
    header('Location: loginform.php');
    exit();
}


