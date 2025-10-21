<?php
    session_start();
    require 'connbbdd.php';
    if (!isset($_SESSION['user_id'])) {
        header('Location:form_login.php');
    }
    try {
            $stmt = $conn ->prepare("SELECT * from juegos");
            $stmt -> execute();

            $juego = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $errores [] = 'Error al recoger los datos de los juegos';
            $_SESSION['errores'] = $errores;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
</head>
<body>
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
        
    ?>
    <?php
        echo "<div>";
        foreach ($juego as $juegoDatos) {
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
        }
        echo "</div>";
    ?>
</body>
</html>
