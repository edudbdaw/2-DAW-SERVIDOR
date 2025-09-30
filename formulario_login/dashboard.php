<?php
// dashboard.php

session_start();

// Si el usuario no está logeado, redirigir al login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

// Obtener el nombre de usuario de la sesión para mostrarlo
$userName = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-2xl text-center">
        <h1 class="text-3xl font-bold mb-4">Bienvenido, <?php echo htmlspecialchars($userName); ?>!</h1>
        <p class="text-lg text-gray-700 mb-6">Este es tu espacio personal.</p>
        <a href="logout.php" class="inline-block bg-red-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">Cerrar Sesión</a>
    </div>
</body>
</html>