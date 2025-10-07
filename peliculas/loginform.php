<?php
session_start();

$errores = $_SESSION['errores'] ?? [];
$exito = $_SESSION['exito'] ?? null; 

unset($_SESSION['errores']);
unset($_SESSION['exito']);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Iniciar Sesión</h1>
        
        <?php if (!empty($errores)): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
                <ul class="list-disc list-inside">
                    <?php foreach ($errores as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($exito): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">
                <p><?php echo htmlspecialchars($exito); ?></p>
            </div>
        <?php endif; ?>

        <form method="post" action="login.php" class="space-y-4">
            <div>
                <label for="correo" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="text" name="correo" id="correo" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="<?php echo htmlspecialchars($inputs['correo'] ?? ''); ?>">
            </div>
            
            <div>
                <label for="passwd" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" name="passwd" id="passwd" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <button type="submit" name="enviarLogin" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-700 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Login
            </button>
        </form>
        
        <p class="mt-4 text-center text-gray-600">
            ¿No tienes cuenta? <a href="registroform.php" class="text-blue-500 hover:underline">Regístrate aquí</a>
        </p>
    </div>
</body>
</html>