<?php
session_start();

$errores = $_SESSION['errores'] ?? [];
unset($_SESSION['errores']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
</head>
<body>
    <h1>LOGIN</h1>
    <?php
    if (!empty($errores)) {
        echo '<div><ul>';
        foreach($errores as $error) {
            echo '<li>' . htmlspecialchars($error) . '</li>';
        }
        echo '</ul></div>';
    }
    ?>
    <form method="post" action="login.php">
        <label for="correo">Correo : </label><input type="text" name = "correo" id="correo">
        <br>
        <label for="passwd">Contraseña</label><input type="password" name="passwd" id="passwd">
        <br>
        <input type="submit" name="enviarLogin" value="login" >
    </form>
</body>
</html>