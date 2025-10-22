<?php
    session_start();
    require 'connbbdd.php';
    if (!isset($_SESSION['user_id'])) {
        header('Location:form_login.php');
        exit();
    }else {
        $user_id = $_SESSION['user_id'];
    }
    //Recoger datos de todos los juegos para mostrar
    try {
            $stmt = $conn ->prepare("SELECT * from juegos");
            $stmt -> execute();

            $juego = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $errores [] = 'Error al recoger los datos de los juegos';
            $_SESSION['errores'] = $errores;
    }
    //foto de perfil user
    try {
        $stmt_user = $conn->prepare("SELECT profile_pic_path FROM usuarios WHERE id = :user_id LIMIT 1");
        $stmt_user->bindParam(':user_id', $user_id);
        $stmt_user->execute();
        $user_data = $stmt_user->fetch(PDO::FETCH_ASSOC);
        $profile_pic_path = $user_data['profile_pic_path']; 
    } catch (PDOException $e) {
        $errores[] = 'Error al cargar la foto de perfil: ' . $e->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
    <style>
        img {
            width:150px;
            height: auto;
        }
        .profile-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%; /* Hace que la imagen sea circular */
            object-fit: cover;
            margin-left: 10px;
            vertical-align: middle;
        }
        .nav-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
            margin-bottom: 20px;
        }
        .nav-right a {
            margin-left: 15px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="nav-bar">
        <div>
            <a href="subirJuego.php">[AÑADIR JUEGO]</a>
        </div>
        
        <div class="nav-right">
            <span>Bienvenido <?php echo $_SESSION['username']?></span>
            <a href="editarPerfil.php"><img src="<?php echo htmlspecialchars($profile_pic_path); ?>" alt="Foto de perfil" class="profile-circle"></a>
            
            
            <a href="logout.php">[LOGOUT]</a>
        </div>
    </div>
    <h1>Bienvenido <?php echo $_SESSION['username']?></h1>
    
    <?php
        //Muestro los errores que surgan de la toma de datos
        if (isset($_SESSION['errores']) && !empty($_SESSION['errores'])) {
            echo "<div>";
            foreach($_SESSION['errores'] as $error) {
                echo $error;
            }
            echo "</div>";
        }
        unset($_SESSION['errores']);
    ?>
    <?php
        echo "<div>";
        foreach ($juego as $juegoDatos) {
            $juego_user_id = $juegoDatos['user_id'];
            $juegoID = $juegoDatos['id'];
            $juegoNombre = $juegoDatos['titulo'];
            echo "$juegoNombre<br>";
            $juegoAutor = $juegoDatos['autor'];
            echo "$juegoAutor<br>";
            $juegoDescripcion = $juegoDatos['descripcion'];
            echo "$juegoDescripcion";
            $juegoCaratulaFoto = $juegoDatos['caratula_path'];
            echo '<img src="' . $juegoCaratulaFoto . '" alt="Carátula del juego">'; 
            echo "<br>"; 
            $juegoCategoria = $juegoDatos['categoria'];
            echo "$juegoCategoria<br>";
            $juegoUrl = $juegoDatos['url'];
            echo "$juegoUrl";
            $juegoYear = $juegoDatos['year_juego'];
            echo $juegoYear;

            // Verificacion usuario subio juego , puede editar o borrar
            if ($_SESSION['user_id'] === $juego_user_id) {
                echo "<a href='editarJuego.php?id=$juegoID'>[EDITAR]</a> ";
                echo "<a href='eliminarJuego.php?id=$juegoID'>[ELIMINAR]</a>";
            }
            echo "<hr>";
        }
        echo "</div>";
    ?>
</body>
</html>
