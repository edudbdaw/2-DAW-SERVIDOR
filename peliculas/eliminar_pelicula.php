<?php

require 'conexion.php';
session_start();

$id_pelicula = $_GET['id'] ?? null;

if (!$id_pelicula) {
    header('Location: dashboard.php');
    exit();
}

try {
    $stmt = $conn ->prepare("DELETE from peliculas where id = :id_pelicula");
    $stmt -> bindParam(':id_pelicula' , $id_pelicula);
    $stmt -> execute();

    header('Location: dashboard.php');
} catch (PDOException $e) {
    echo "error ".$e->getMessage();
}