<?php
session_start();

// Si el usuario no está logueado, redirigir al login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

require 'conexion.php';

$user_name = $_SESSION['user_name'];
$user_id = $_SESSION['user_id'];

// Usare FetchALL para coger todas las files que existan con el user_id = x
try {
    $stmt = $conn->prepare("SELECT id, titulo, caratula FROM peliculas");
    $stmt->execute();
    $peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error al cargar las películas: " . $e->getMessage();
    $peliculas = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans p-8">
    <div class="container mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Bienvenido, <?php echo htmlspecialchars($user_name); ?>!</h1>
            <div class="space-x-4">
                <a href="subirpeliculasform.php" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-600 transition-colors duration-300">Subir nueva película</a>
                <a href="logout.php" class="bg-red-500 text-white font-bold py-2 px-4 rounded-md hover:bg-red-600 transition-colors duration-300">Cerrar sesión</a>
            </div>
        </div>

        <h2 class="text-xl font-semibold text-gray-700 mb-4">Mis Películas</h2>
        
        <div>
            <?php if (empty($peliculas)): ?>
                <p class="text-gray-500">Aún no has subido ninguna película.</p>
            <?php else: ?>
                <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <?php foreach ($peliculas as $pelicula): ?>
                        <li class="bg-gray-50 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                            <h3 class="text-lg font-medium mb-2 text-gray-800"><?php echo htmlspecialchars($pelicula['titulo']); ?></h3>
                            <!--query string , cuando  usamos ? le decimos al navegador , a partir de aqui metemos datos-->
                            <a href="detalles_pelicula.php?id=<?php echo $pelicula['id']; ?>">
                                <img src="<?php echo htmlspecialchars($pelicula['caratula']); ?>"  class="w-full h-auto rounded-md object-cover">
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>