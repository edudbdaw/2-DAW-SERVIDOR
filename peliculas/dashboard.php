<?php
    session_start();
    $user_name = $_SESSION['user_name'] ?? null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Bienvenido <?php echo $user_name?></h1>
    <div>
        <?php
            
        ?>
    </div>
</body>
</html>