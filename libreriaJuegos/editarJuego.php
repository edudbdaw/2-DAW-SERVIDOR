<?php
    session_start();
    require 'connbbdd.php';

    // Control de Acceso: Verificar sesión
    if (!isset($_SESSION['user_id'])) {
        header('Location: form_login.php');
        exit();
    }

    $juegoID = $_GET['id'] ?? null;
    $user_id = $_SESSION['user_id'];
    $errores = [];
    $juegoDatos = null; // Variable para almacenar los datos del juego

    if (!$juegoID) {
        $errores[] = 'No se especificó el juego a editar.';
    }

    if (empty($errores)) {
        try {
            // Consulta Segura: Trae el juego y verifica que pertenezca al usuario logueado.
            $sql = "SELECT * FROM juegos WHERE id = :juego_id AND user_id = :user_id LIMIT 1";
            $stmt = $conn->prepare($sql);
            
           
            $stmt->bindParam(':juego_id', $juegoID);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            
            $juegoDatos = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$juegoDatos) {
                $errores[] = 'Error: Este juego no existe o no tienes permiso para editarlo.';
            }

        } catch (PDOException $e) {
            $errores[] = 'Error de BBDD al cargar el juego: ' . $e->getMessage();
        }
    }
    
    // Redirección si hay errores
    if (!empty($errores)) {
        $_SESSION['errores'] = $errores;
        header('Location: dashboard.php');
        exit();
    }

    // Definir categorías para el select 
    $categorias_validas = [
        'accion', 'aventura', 'rol', 'estrategia', 'deportes', 'simulacion', 
        'carreras', 'shooter', 'puzzle', 'mundoAbierto'
    ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Juego: <?= htmlspecialchars($juegoDatos['titulo']) ?></title>
</head>
<body>
    <h1>Editar Juego: <?= htmlspecialchars($juegoDatos['titulo']) ?></h1>

    <?php
        // Muestra errores de redirección
        if (isset($_SESSION['errores']) && !empty($_SESSION['errores'])) {
            echo "<div>";
            foreach($_SESSION['errores'] as $error) {
                echo $error;
            }
            echo "</div>";
            unset($_SESSION['errores']);
        }
    ?>

    <form action="editarJuegoLogica.php" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="id" value="<?= htmlspecialchars($juegoDatos['id']) ?>">
        <input type="hidden" name="action" value="update"> 

        <label for="titulo">Titulo del juego</label><br>
        <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($juegoDatos['titulo']) ?>"><br>

        <label for="autor">Autor</label><br>
        <input type="text" name="autor" id="autor" value="<?= htmlspecialchars($juegoDatos['autor']) ?>"><br>

        <label for="descripcion">Descripción</label><br>
        <textarea name="descripcion" id="descripcion"><?= htmlspecialchars($juegoDatos['descripcion']) ?></textarea><br>

        <label for="Categoria">Selecciona la categoría del juego</label><br>
        <select name="categoria" id="categoria">
            <?php foreach ($categorias_validas as $cat): ?>
                <option value="<?= $cat ?>" <?= ($cat === $juegoDatos['categoria']) ? 'selected' : '' ?>>
                    <?= ucfirst($cat) ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label for="url">Url</label><br>
        <input type="url" name="url" id="url" size="30" value="<?= htmlspecialchars($juegoDatos['url']) ?>"><br>
        
        <select name="year_juego" id="year_juego">
            <?php
                $añoActual = date("Y");
                for($i = 1980 ; $i<=$añoActual ; $i++ ){
                    echo "<option value=$i>$i</option>";
                }
            ?>
        </select><br>

        <p>Carátula Actual: <img src="<?= htmlspecialchars($juegoDatos['caratula_path']) ?>" width="100"></p>
        <label for="caratula">Cambiar Carátula</label><br>
        <input type="file" name="caratula" id="caratula">
        
        <input type="submit" name="submit" value="Guardar Cambios">
    </form>
</body>
</html>