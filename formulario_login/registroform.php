<?php
include('registro.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <form action="registro.php" method="post">
        Nombre : <input type="text" name="nombre" value = "<?php echo $_SESSION['nombreuser']?>">
        <br>
        Apellido : <input type="text" name="apellido" value= "<?php echo $_SESSION['apellidouser']?>">
        <br>
        Email : <input type="email" name="correo" value = "<?php echo $_SESSION['correouser']?>">
        <br>
        Contraseña : <input type="password" name="contraseña1" value = "<?php echo $_SESSION['contraseña1user']?>">
        <br>
        Contraseña : <input type="password" name="contraseña2" value = "<?php echo $_SESSION['contraseña2user']?>">
        <input type="submit" >
    </form>
</body>
</html>