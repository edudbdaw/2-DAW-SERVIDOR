<?php
session_start();
require 'connbbdd.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: form_login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$errores = [];
try {
   
    $sql = "SELECT username, email, profile_pic_path FROM usuarios WHERE id = :user_id LIMIT 1";
    $stmt = $conn->prepare($sql);
    
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
        
        $errores[] = 'Error: No se encontraron los datos del usuario.';
    }

} catch (PDOException $e) {
    $errores[] = 'Error de BBDD al cargar datos de perfil: ' . $e->getMessage();
}

if (!empty($errores)) {
    $_SESSION['errores'] = $errores;
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <style>
        /* Estilo básico para la foto de perfil */
        .profile-circle {
            border-radius: 50%;
            object-fit: cover;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <h1>Editar Perfil de <?= htmlspecialchars($userData['username']) ?></h1>

    <?php
        // Mostrar errores 
        if (isset($_SESSION['errores']) && !empty($_SESSION['errores'])) {
            echo '<div style="color: red;">' . implode('<br>', $_SESSION['errores']) . '</div>';
            unset($_SESSION['errores']);
        }
    ?>

    <form action="editarPerfilLogica.php" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="user_id" value="<?= $user_id ?>">

        <input type="hidden" name="username" value="<?= htmlspecialchars($userData['username']) ?>">
        <input type="hidden" name="email" value="<?= htmlspecialchars($userData['email']) ?>">

        <p><strong>Nombre de Usuario:</strong> <?= htmlspecialchars($userData['username']) ?></p>
        <p><strong>Correo Electrónico:</strong> <?= htmlspecialchars($userData['email']) ?></p>

        <label>Foto de Perfil Actual</label><br>
        <img src="<?= htmlspecialchars($userData['profile_pic_path']) ?>" 
             width="100" class="profile-circle"><br><br>
        
        <label for="profile_pic">Cambiar Foto de Perfil</label><br>
        <input type="file" name="fotoPerfil" id="profile_pic"><br><br> <input type="submit" name="submit" value="Actualizar Foto">
    </form>
</body>
</html>