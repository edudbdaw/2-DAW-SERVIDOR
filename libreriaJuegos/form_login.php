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
        <label for="username">Usuario</label><br>
        <input type="text" name="username" id="username" onkeyup="verificarUsuario()"><br>
        <span id="userMsg"></span><br>

        <label for="password">Contraseña</label><br>
        <input type="password" name="password" id="password" onkeyup="verificarPassword()"><br>
        <span id="passMsg"></span><br>

        <input type="submit" value="Entrar"><br>
        <a href="form_registro.php">Regístrate</a>
        <input type="checkbox" name="recordarSesion" id="recordarSesion">
        <label for="recordarSesion">Recordar sesión</label><br>
    </form>

    <script>
        function verificarUsuario() {
            let username = document.getElementById('username').value;
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'verificar_login.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('userMsg').innerHTML = xhr.responseText;
                }
            };
            xhr.send('username=' + encodeURIComponent(username));
        }

        function verificarPassword() {
            let password = document.getElementById('password').value;
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'verificar_login.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('passMsg').innerHTML = xhr.responseText;
                }
            };
            xhr.send('password=' + encodeURIComponent(password));
        }
    </script>
</body>
</html>
</body>
</body>
</html>