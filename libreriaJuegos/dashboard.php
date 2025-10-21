<?php
    session_start();
    require 'connbbdd.php';
    if (!isset($_SESSION['user_id'])) {
        header('Location:form_login.php');
    }
    try {
            $stmt = $conn ->prepare("SELECT * from juegos where user_id = :user_id");
            $stmt -> bindParam(':user_id' , $_SESSION['user_id']);
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
        if (isset($_SESSION['errores']) && !empty($_SESSION['errores'])) {
            echo "<div>";
            foreach($_SESSION['errores'] as $error) {
                echo $error;
            }
            echo "</div>";
        }
    ?>
</body>
</html>