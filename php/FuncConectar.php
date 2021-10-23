<?php

// ----------------------Conexion con la base de datos

function ConectarBD()
{
	$servidor = "localhost";
	$usuario = "root";
	$contraseña = "";
	$BaseDeDatos = "basededatosnorteysur";

$conexion = mysqli_connect($servidor, $usuario, $contraseña, $BaseDeDatos) or die("Problemas al conectar con la BaseDeDatos");


return $conexion;
}

?>