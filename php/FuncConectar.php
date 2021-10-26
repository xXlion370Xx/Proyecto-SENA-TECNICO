<?php

// ----------------------Conexion con la base de datos

function ConectarBD()
{
	$servidor = "bxlngyzd44tt8erqf7w3-mysql.services.clever-cloud.com";
	$usuario = "ucu5kywu4fa4y2kj";
	$contraseña = "iD9NECJrlEt4L1SNCxFR";
	$BaseDeDatos = "bxlngyzd44tt8erqf7w3";

$conexion = mysqli_connect($servidor, $usuario, $contraseña, $BaseDeDatos) or die("Problemas al conectar con la Base de datos");


return $conexion;
}


?>