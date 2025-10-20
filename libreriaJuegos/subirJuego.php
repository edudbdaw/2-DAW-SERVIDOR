<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORMULARIO SUBIR JUEGOS</title>
</head>
<body>
    <h1>¿Que juego quires subir?</h1>
    <?php
        session_start();
        if (isset($_SESSION['errores']) && !empty($_SESSION['errores']) ) {
            echo '<div style="color: red; border: 1px solid red; padding: 10px;">';
            foreach ($_SESSION['errores'] as $error) {
                echo "$error<br>";
            }
        }
        echo "</div>";
        unset($_SESSION['errores']);
    ?>
    <form method="post" action="subirJuegoLogica.php" enctype = "multipart/form-data">
        <label for="titulo">Titulo del juego</label><br><input type="text" name="titulo" id="titulo"><br>
        <label for="autor">Autor</label><br><input type="text" name="autor" id="autor"><br>
        <label for="Categoria">Seleciona la categoria del juego</label><br>
        <select name="categoria" id="categoria">
            <option value="accion">Accion</option>
            <option value="aventura">Aventura</option>
            <option value="rol">RPG</option>
            <option value="estrategia">Estrategia</option>
            <option value="deportes">Deportes</option>
            <option value="simulacion">Simulacion</option>
            <option value="carreras">Carreras</option>
            <option value="shooter">Shooter</option>
            <option value="puzzle">Puzzle</option>
            <option value="mundoAbierto">Mundo Abierto</option>
        </select>
        <br>
        <label for="url">Url</label><br><input type="url" name="url" id="url" size="30"><br>
        <label for="caratula">Caratula</label><br><input type="file" name="caratula" id="caratula">
        <input type="submit" name="submit" id="submit">
    </form>
</body>
</html>