<?php

require 'conexion.php';
session_start();

$q = $_GET['q'];

if ($srtlen($q)<8) {
    echo "---" ;
}