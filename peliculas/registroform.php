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
    <title>Registro | Biblioteca de Películas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">REGISTRO DE USUARIO</h1>
        
        <?php
        if (!empty($errores)) {
            echo '<div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">';
            echo '<ul class="list-disc list-inside">';
            foreach($errores as $error) {
                echo '<li>' . htmlspecialchars($error) . '</li>';
            }
            echo '</ul></div>';
        }
        ?>
        
        <form action="registro.php" method="post" class="space-y-4">
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($inputs['nombre'] ?? ''); ?>"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="apellidos" class="block text-sm font-medium text-gray-700">Apellido</label>
                <input type="text" name="apellidos" id="apellidos" value="<?php echo htmlspecialchars($inputs['apellidos'] ?? ''); ?>"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="correo" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="correo" id="correo" value="<?php echo htmlspecialchars($inputs['correo'] ?? ''); ?>"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="contrasena1" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" name="contrasena1" id="contrasena1"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="contrasena2" class="block text-sm font-medium text-gray-700">Repetir Contraseña</label>
                <input type="password" name="contrasena2" id="contrasena2"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <button type="submit" name="enviar" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-700 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Registrarse
            </button>
        </form>
    </div>
</body>
</html>