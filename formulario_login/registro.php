<?php
// registro.php

require 'conexion.php';
session_start();

$errores = []; // Array para guardar los mensajes de error
$inputs = []; // Array para guardar las entradas del usuario

// 1. Recoger y sanear los datos del formulario de forma segura
$nombre = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$contraseña1 = $_POST['contraseña1'] ?? '';
$contraseña2 = $_POST['contraseña2'] ?? '';

// Guardar los inputs para rellenar el formulario si hay errores
// Importante: ¡no guardamos las contraseñas en la sesión!
$inputs['nombre'] = $nombre;
$inputs['apellido'] = $apellido;
$inputs['correo'] = $correo;

// 2. Realizar todas las validaciones
// Comprobar que no haya campos vacíos
if (empty($nombre) || empty($apellido) || empty($correo) || empty($contraseña1) || empty($contraseña2)) {
    $errores[] = "Todos los campos son obligatorios.";
}

// Validar el formato del email
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El email no tiene un formato válido.";
}

// Comprobar si las contraseñas coinciden
if ($contraseña1 !== $contraseña2) {
    $errores[] = "Las contraseñas no coinciden.";
}

// Opcional: Comprobar la longitud de la contraseña
if (strlen($contraseña1) < 6) {
    $errores[] = "La contraseña debe tener al menos 6 caracteres.";
}

// 3. Comprobar si el email ya existe en la base de datos
try {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM usuario WHERE correo = :correo");
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();
    if ($stmt->fetchColumn() > 0) {
        $errores[] = "Este email ya está registrado.";
    }
} catch (PDOException $e) {
    $errores[] = "Error al verificar el email: " . $e->getMessage();
}

// 4. Procesar la validación final
if (!empty($errores)) {
    // Si hay errores, guardarlos en la sesión y redirigir al formulario
    $_SESSION['errores'] = $errores;
    $_SESSION['inputs'] = $inputs;
    header('Location: registroform.php');
    exit();
}

// 5. Si todo es correcto, hashear la contraseña e insertar el usuario
try {
    $contraseña_hash = password_hash($contraseña1, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO usuario (nombre, apellido, correo, contraseña) VALUES (:nombre, :apellido, :correo, :contrasena_hash)");
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apell', $apellido);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':contrasena_hash', $contraseña_hash);
    $stmt->execute();

    // Redirigir a una página de éxito (por ejemplo, el login)
    $_SESSION['mensaje_exito'] = "¡Registro completado con éxito! Por favor, inicia sesión.";
    header('Location: loginform.php'); // Redirige a un nuevo archivo que crearemos
    exit();
} catch (PDOException $e) {
    // Si hay un error de inserción, también redirigir con un mensaje de error
    $_SESSION['errores'] = ["Error al registrar el usuario: " . $e->getMessage()];
    header('Location: registroform.php');
    exit();
}
?>
