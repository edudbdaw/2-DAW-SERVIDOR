<?php
// conexcion.php

$servername = 'localhost';
$username = 'root';
$passwd = '';
$database = 'formulario_login';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database" , $username ,$passwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Mensaje de éxito de conexión eliminado para producción.

} catch (PDOException $e) {
    // En producción, muestra un mensaje genérico para el usuario.
    // El error detallado se puede registrar en un archivo de log en el servidor.
    die("Lo sentimos, no se pudo conectar a la base de datos.");
}
?>