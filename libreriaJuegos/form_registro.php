<?php
    session_start();
    $inputsB = $_SESSION['inputsB'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <h1>Registro Usuarios</h1>
    <?php
        //verifico si existen errores y si el array esta no esta vacio , si se cumplen foreach
        if (isset($_SESSION['errores']) && !empty($_SESSION['errores'])) {
            echo '<div style="color: red; border: 1px solid red; padding: 10px;">';
            foreach ($_SESSION['errores'] as $error) {
                echo "<p>$error</p>";
            }
            echo '</div>';
            
            unset($_SESSION['errores']); 
        }
    ?>
    
    <form action="registro.php" method="post" enctype = "multipart/form-data">
        <label for="username">Escribe un nombre de usuario : </label>
        <input type="text" id="username" name="username" value=<?php echo htmlspecialchars($inputsB['username'] ?? '')?>><br>
        <label for="correoUser">Escribe tu correo electronico</label>
        <input type="email" name="correoUser" id="correoUser" value=<?php echo htmlspecialchars($inputsB['correoUser'] ?? '')?>><br>
        <label for="password1">Escribe la contraseña</label>
        <input type="password" name="password1" id="password1"><br>
        <label for="password2">Repite la contraseña</label>
        <input type="password" name="password2" id="password2"><br>
        <label for="perfilPicture">Sube tu foto de perfil (Opcional)</label>
        <input type="file" name="fotoPerfil" id="fotoPerfil">
        <input type="submit">
    </form>

    </div>
</body>
</html>