<?php

require 'connbbdd.php';
session_start();

//manejo errores 
$errores = [];

function manejoErrores($errores_añadir) {
    if (!empty($errores_añadir)) {
        $_SESSION['errores'] = $errores_añadir;
        header('Location:subirJuego.php');
        exit();
    } 
}

//variables
$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$categoria = $_POST['categoria'];
$url = $_POST['url'];

//Validaciones
if(empty($titulo) || empty($autor) || empty($categoria) || empty($url)) {
    $errores = ['Debe rellenar todos los campos'];
    manejoErrores($errores);
}

$mayusculas = '/[A-Z]/';
if (!preg_match($mayusculas , $titulo)) {
    $errores [] = 'Titulo debe contener mayusculas';
}

if (!preg_match($mayusculas , $autor)) {
    $errores [] = 'El autor debe contener mayusculas';
}

if (!filter_var($url, FILTER_VALIDATE_URL)) {
    $errores [] = 'Url no valida';
}

$categorias_validas = ['accion' , 'aventura', 'rol', 'estrategia', 'deportes', 'simulacion', 'carreras', 'shooter', 'puzzle', 'mundoAbierto'];

if(!in_array($categoria , $categorias_validas)) {
    $errores = 'Categoria introducida no valida';
}

manejoErrores($errores);

define('RUTA_POR_DEFECTO' , 'subidas/caratulas/caratuladefault.png');
