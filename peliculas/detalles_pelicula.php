<?php
session_start();
require 'conexion.php';

$user_id_session = $_SESSION['user_id'];
$id_pelicula = $_GET['id'] ?? null;

// Si no se proporciona un ID de película, redirigir al dashboard
if (!$id_pelicula) {
    header('Location: dashboard.php');
    exit();
}

try {
    $stmt = $conn->prepare("SELECT id, titulo, sinopsis, caratula, user_id FROM peliculas WHERE id = :id");
    $stmt->bindParam(':id', $id_pelicula);
    $stmt->execute();
    $pelicula = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si la película no existe, redirigir al dashboard
    if (!$pelicula) {
        header('Location: dashboard.php');
        exit();
    }

} catch (PDOException $e) {
    echo "Error al cargar los detalles: " . $e->getMessage();
    exit();
}

// Verificar si el usuario actual es el propietario de la película
$propietario = ($user_id_session == $pelicula['user_id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pelicula['titulo']); ?> - Detalles</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans p-8">
    <div class="container mx-auto bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4"><?php echo htmlspecialchars($pelicula['titulo']); ?></h1>

        <div class="flex flex-col md:flex-row items-center md:items-start gap-8 mb-8">
            <img src="<?php echo htmlspecialchars($pelicula['caratula']); ?>" 
                 alt="Carátula de <?php echo htmlspecialchars($pelicula['titulo']); ?>" 
                 class="w-full md:w-1/3 rounded-lg shadow-lg">
            
            <div class="md:w-2/3">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Sinopsis</h2>
                <p class="text-gray-600 leading-relaxed"><?php echo htmlspecialchars($pelicula['sinopsis']); ?></p>
            </div>
        </div>

        <?php if ($propietario): ?>
            <div class="mt-6 flex space-x-4">
                <a href="editar_pelicula.php?id=<?php echo $pelicula['id']; ?>">
                    <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-600 transition-colors duration-300">Editar</button>
                </a>
                <a href="eliminar_pelicula.php?id=<?php echo $pelicula['id']; ?>" 
                   onclick="return confirm('¿Estás seguro de que quieres eliminar esta película?');">
                    <button class="bg-red-500 text-white font-bold py-2 px-4 rounded-md hover:bg-red-600 transition-colors duration-300">Eliminar</button>
                </a>
            </div>
        <?php endif; ?>

        <div class="mt-8">
            <a href="dashboard.php" class="text-blue-500 hover:underline">Volver al dashboard</a>
        </div>
    </div>
</body>
</html>