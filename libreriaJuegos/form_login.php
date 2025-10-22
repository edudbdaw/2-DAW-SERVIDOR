<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php
        if (isset($_SESSION['errores']) && !empty($_SESSION['errores'])) {
            foreach ($_SESSION['errores'] as $error) {
                echo "<div>$error<br>";
            }
            echo "</div>";
        }
        unset($_SESSION['errores']);
        
    ?>
    <h1>LOGIN</h1>
    <form action="login.php" method="post">
        <label for="nombreUser">Usuario</label><br><input type="text" name="username" id="username"><br>
        <label for="password">Contraseña</label><br><input type="password" name="password" id="password"><br>
        <input type="submit"><br>
        <a href="form_registro.php">Registrate</a>
        
    </form>
</body>
</html>