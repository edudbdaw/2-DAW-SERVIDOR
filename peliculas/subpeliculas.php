<?php
session_start();
require 'conexion.php';

$errores = [];

$nombre_pelicula = $_POST['nombre_pelicula'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$caratula = $_FILES['caratula'] ?? null;

if (empty($nombre_pelicula) || empty($descripcion)) {
    $errores[] = "El título y la descripción son obligatorios.";
}

// en un $_FILES se guarda lo que subimos y contiene un valor numerico error = 0/8 , que nos dice si se envio o no o otros tipòs de errores
//UPLOAD_ERR_OK es una constante de php que = 0 
//es decir que si error es distinto de 0 hay error 


if ($caratula['error'] !== UPLOAD_ERR_OK) {
    
    $errores[] = "Error al subir la carátula.";
} else {
    $permitidos = ['image/jpeg', 'image/png', 'image/gif'];
    // in_array mira si dentro del array existe lo que le pasamos , en este caso el type de caratula
    if (!in_array($caratula['type'], $permitidos)) {
        $errores[] = "Solo se permiten imágenes JPG, PNG y GIF.";
    }
    
}

if (!empty($errores)) {
    $_SESSION['errores'] = $errores;
    header('Location: subirpeliculasform.php');
    exit();
}

try {
    //funcion pathinfo que nos devuelve informacion del path , para asi obtener con _extension la extension del archivo
    $extension = pathinfo($caratula['name'], PATHINFO_EXTENSION);
    $nombre_aleatorio = uniqid() . '.' . $extension;
    $ruta_destino = 'uploads/caratulas/' . $nombre_aleatorio;

    // movemos el archivo temporal del formulario ne la ruta de destino que le damos , sobreescribiendo el nombre 
    if (!move_uploaded_file($caratula['tmp_name'], $ruta_destino)) {
        throw new Exception("Error al guardar el archivo.");
    }
    
    $user_id = $_SESSION['user_id'];
    
    $stmt = $conn->prepare("INSERT INTO peliculas (titulo, sinopsis, caratula, user_id) VALUES (:titulo, :sinopsis, :caratula, :user_id)");
    $stmt->bindParam(':titulo', $nombre_pelicula);
    $stmt->bindParam(':sinopsis', $descripcion);
    $stmt->bindParam(':caratula', $nombre_aleatorio);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $_SESSION['mensaje_exito'] = "¡Película subida con éxito!";
    header('Location: dashboard.php');
    exit();

} catch (Exception $e) {
    $_SESSION['errores'] = ["Error: " . $e->getMessage()];
    header('Location: subirpeliculasform.php');
    exit();
}
?>
