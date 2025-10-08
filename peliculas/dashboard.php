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
    $stmt = $conn->prepare("SELECT id, titulo, caratula FROM peliculas WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
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
</head>
<body>
    <h1>Bienvenido, <?php echo htmlspecialchars($user_name); ?>!</h1>

    <a href="subirpeliculasform.php">Subir nueva película</a> |
    <a href="logout.php">Cerrar sesión</a>

    <h2>Mis Películas</h2>
    
    <div>
        <?php if (empty($peliculas)): ?>
            <p>Aún no has subido ninguna película.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($peliculas as $pelicula): ?>
                    <li>
                        <h3><?php echo ($pelicula['titulo']); ?></h3>
                        <!-- para especificar que a partir de ahi le pasaremos (query string)-->
                        <a href="detalles_pelicula.php?id=<?php echo $pelicula['id']; ?>">
                            <img src="<?php echo ($pelicula['caratula']); ?>" alt="Carátula de <?php echo htmlspecialchars($pelicula['titulo']); ?>" width="150">
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>