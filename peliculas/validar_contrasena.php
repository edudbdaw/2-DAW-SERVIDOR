<?php
// validar_contrasena.php

// Aseguramos que solo se devuelve texto plano
header('Content-Type: text/plain'); 

$contrasena = $_GET['q'] ?? '';
$mensaje = '';

if (strlen($contrasena) < 8) {
    $mensaje = "Debe tener al menos 8 caracteres.";
} elseif (strlen($contrasena) > 20) {
    $mensaje = "Máximo 20 caracteres.";
} else {
    // Patrón de símbolos: al menos un símbolo, un número y una mayúscula (validación más robusta)
    $patron = '/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>]).{8,20}$/';
    
    if (!preg_match($patron, $contrasena)) {
        $mensaje = "Debe tener mayúscula, número y símbolo.";
    }
}

// Si $mensaje está vacío, la contraseña es válida.
if (empty($mensaje)) {
    echo "<span style='color: green;'>Contraseña OK!</span>";
} else {
    echo "<span style='color: red;'>" . htmlspecialchars($mensaje) . "</span>";
}

// Nota: No usamos exit() aquí, pero nos aseguramos de que el script no imprima nada más.
?>