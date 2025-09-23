<?php

// Siempre al inicio del script para habilitar el uso de sesiones.
// Si ya hay una sesión, la reanuda; si no, crea una nueva.
session_start(); 

// En una aplicación real, estos datos se obtendrían de una base de datos.
// Los mantenemos aquí por simplicidad en el ejemplo.
$emailValido = "edudb@gmail.com";
$contraseñaValida = "bolilla123";

// 1. Verifica si se han enviado datos por el método POST y si los campos no están vacíos.
if (!empty($_POST["Email"]) && !empty($_POST['Contraseña'])) {

    // 2. Compara las credenciales ingresadas con las credenciales válidas.
    if ($_POST["Email"] === $emailValido && $_POST["Contraseña"] === $contraseñaValida) {
        
        // ¡Validación exitosa! Aquí es donde manejas la sesión.
        // Asignas una variable a la superglobal $_SESSION. Esto "loguea" al usuario.
        // La clave 'logueado' o 'usuario' es un nombre que tú eliges.
        $_SESSION['logueado'] = true;
        $_SESSION['email'] = $emailValido;

        // 3. La redirección es crucial. Envía una cabecera HTTP al navegador para que 
        // lo dirija a la página restringida.
        // No debe haber ninguna salida (echo) antes de un header().
        header('Location: restringido.php');
        
        // Es una buena práctica usar exit; después de la redirección para 
        // asegurar que no se ejecute más código del script.
        exit; 
    } else {
        // La validación falló.
        echo "Correo o contraseña incorrecta.";
    }
} else {
    // Si los campos estaban vacíos.
    echo "Por favor, completa todos los campos.";
}

?>