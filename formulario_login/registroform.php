<?php
// registroform.php
session_start();

// No incluir registro.php aquí. La lógica se separa.

// Si no existe un array de errores, crear uno vacío para evitar warnings
$errores = $_SESSION['errores'] ?? [];
$inputs = $_SESSION['inputs'] ?? [];

// Limpiar la sesión de errores e inputs para que no se muestren de nuevo
unset($_SESSION['errores']);
unset($_SESSION['inputs']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <style>
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Registro de Usuario</h1>
    
    <?php if (!empty($errores)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="registro.php" method="post">
        Nombre : <input type="text" name="nombre" value="<?php echo htmlspecialchars($inputs['nombre'] ?? ''); ?>">
        <br>
        Apellido : <input type="text" name="apellido" value="<?php echo htmlspecialchars($inputs['apellido'] ?? ''); ?>">
        <br>
        Email : <input type="email" name="correo" value="<?php echo htmlspecialchars($inputs['correo'] ?? ''); ?>">
        <br>
        Contraseña : <input type="password" name="contraseña1">
        <br>
        Repetir Contraseña : <input type="password" name="contraseña2">
        <br>
        <input type="submit" value="Registrarse">
    </form>
</body>
</html>