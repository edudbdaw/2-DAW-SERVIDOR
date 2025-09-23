<?php
session_start();

// Validar que los campos del formulario se recibieron correctamente
if (isset($_POST['nombre']) && isset($_POST['color'])) {
    
    // Guardar los datos del formulario en variables de sesión
    $_SESSION['nombreUser'] = htmlspecialchars($_POST['nombre']);
    $_SESSION['colorUser'] = htmlspecialchars($_POST['color']);

    // Redirigir al usuario a la página de perfil
    header('Location: perfil.php');
    exit;

} else {
    // Si no se recibieron los datos del formulario, redirigir a la página de inicio
    header('Location: index.html');
    exit;
}
?>