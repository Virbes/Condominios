<?php
session_start();
$link = @mysqli_connect("localhost", "negocio_ussys012", "LuzBel2006", "negocio_panel");

if (mysqli_connect_errno()) {
    printf("Error al conectar con el sistema principal.<br>(<strong>Soporte tecnico:</strong> 01 (55) 3640 4825)" . "<br>Connect failed: %s\n", mysqli_connect_error());
    exit();
}

echo "<br>Conexion de bd Correcta<br>";
print_r($link);
exit;
