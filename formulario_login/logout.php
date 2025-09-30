<?php
// logout.php

session_start();

// Eliminar todas las variables de sesión
$_SESSION = array();

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de login
header('Location: login.html');
exit();
?>