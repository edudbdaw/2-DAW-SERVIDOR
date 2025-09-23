<?php

$servername = 'localhost';
$username = 'root';
$passwd = '';
$database = 'formulario';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username , $passwd);

     $conn->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    echo "Conexion correcta";
} catch (PDOException $e) {
    echo "Conexion Fallida";
    echo  $e->getMessage();
};