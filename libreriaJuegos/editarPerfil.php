<?php
session_start();
require 'connbbdd.php';

// 1. CONTROL DE ACCESO: Si no está logueado, redirigir
if (!isset($_SESSION['user_id'])) {
    header('Location: form_login.php');
    exit();
}

$logged_user_id = $_SESSION['user_id'];
$errores = [];
$userData = null; // Variable para guardar los datos actuales

try {
    // 2. CONSULTA SEGURA: Obtener datos actuales del usuario (excepto la contraseña).
    $sql = "SELECT username, email, profile_pic_path FROM usuarios WHERE id = :user_id LIMIT 1";
    $stmt = $conn->prepare($sql);
    
    $stmt->bindParam(':user_id', $logged_user_id);
    $stmt->execute();
    
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
        // Esto solo debería pasar si el registro de sesión es inválido/corrupto.
        $errores[] = 'Error: No se encontraron los datos del usuario.';
    }

} catch (PDOException $e) {
    $errores[] = 'Error de BBDD al cargar datos de perfil: ' . $e->getMessage();
}

if (!empty($errores)) {
    // Si hay errores de BBDD, los guardamos y redirigimos (por ejemplo, al dashboard).
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
    </head>
<body>
    <h1>Editar Perfil de <?= htmlspecialchars($userData['username']) ?></h1>

    <?php
        // Mostrar errores (si vienen de un intento fallido de actualización)
        if (isset($_SESSION['errores']) && !empty($_SESSION['errores'])) {
            echo '<div style="color: red;">' . implode('<br>', $_SESSION['errores']) . '</div>';
            unset($_SESSION['errores']);
        }
    ?>

    <form action="editarPerfilLogica.php" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="user_id" value="<?= $logged_user_id ?>">

        <label for="username">Nombre de Usuario : <?= htmlspecialchars($userData['username']) ?> </label><br>

        <label for="email">Correo Electrónico : <?= htmlspecialchars($userData['email']) ?> </label><br>
        <label>Foto de Perfil Actual</label><br>
        <img src="<?= htmlspecialchars($userData['profile_pic_path'])?>" width="100" class="profile-circle"><br>
        <input type="file" name="profile_pic" id="profile_pic"><br><br>
        <input type="submit" name="submit" value="Guardar Cambios">
    </form>
</body>
</html>