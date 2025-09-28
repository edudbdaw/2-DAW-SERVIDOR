<?php

$servername = 'localhost';
$username = 'root';
$passwd = '';
$database = 'formulario_login';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database" , $username ,$passwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexion Correcta";
    
} catch (PDOException $e) {
    echo "Conexion fallida";
    die($e->getMessage());
}

//before changes