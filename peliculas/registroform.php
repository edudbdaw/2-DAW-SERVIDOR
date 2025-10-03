<?php
session_start();

$errores = $_SESSION['errores'] ?? [];
$inputs = $_SESSION['inputs'] ?? [];

unset($_SESSION['errores']);
unset($_SESSION['inputs']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Peliculas</title>
</head>
<body>
    <h1>REGISTRO USUARIO</h1>
    
    <?php
    if (!empty($errores)) {
        echo '<div><ul>';
        foreach($errores as $error) {
            echo '<li>' . htmlspecialchars($error) . '</li>';
        }
        echo '</ul></div>';
    }
    ?>
    
    <form action="registro.php" method="post">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($inputs['nombre'] ?? ''); ?>">
        <br>
        
        <label for="apellidos">Apellido</label>
        <input type="text" name="apellidos" id="apellidos" value="<?php echo htmlspecialchars($inputs['apellidos'] ?? ''); ?>">
        <br>
        
        <label for="correo">Email</label>
        <input type="email" name="correo" id="correo" value="<?php echo htmlspecialchars($inputs['correo'] ?? ''); ?>">
        <br>
        
        <label for="contraseña1">Contraseña</label>
        <input type="password" name="contrasena1" id="contrasena1">
        <br>
        
        <label for="contraseña2">Repetir Contraseña</label>
        <input type="password" name="contrasena2" id="contrasena2">
        <br>
        
        <input type="submit" name="enviar" id="enviar" value="Registrarse">
    </form>
</body>
</html>