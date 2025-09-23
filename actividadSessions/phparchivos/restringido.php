<?php
session_start();
if (isset($_SESSION['logueado'])) {
    echo 'Bienvenido, ' . htmlspecialchars($_SESSION['email']) . '!';
} else {
    header('Location: ../index.html');
    exit;
}
?>