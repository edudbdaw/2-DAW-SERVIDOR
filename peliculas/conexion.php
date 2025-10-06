<?php

$servername = 'localhost';
$db_name = 'mi_proyecto_peliculas';
$username = 'root';
$passwd = '';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db_name", $username, $passwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conexion correcta";
} catch (PDOException $e) {
    die($e->getMessage());
}