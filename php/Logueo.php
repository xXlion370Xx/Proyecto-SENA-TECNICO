<?php
session_start();

$Usuario = $_POST['Usuario'];
$Contraseña = $_POST['Contraseña'];

echo $_SESSION['TipoUsuario'] . $Usuario . $Contraseña;

?>