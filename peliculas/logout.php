<?php


session_start();

// Borramos todas las sessiones existentes 
$_SESSION = array();

// Eliminamos la session
session_destroy();


header("Location: loginform.php");
exit;
?>