<?php

// --------------------------------------------Conexion con la base de datos

include '../../php/FuncConectar.php';


// --------------------------Manipulacion de datos
$fotoUsuario = $_FILES['fotoUsuario'];

$consulta = "insert into Usuario(correoUsuario, passwordUsuario, fotoUsuario, tipoUsuario, estadoUsuario, llaveforeanea) values('$_REQUEST[correoUsuario]','$_REQUEST[passwordUsuario]', '$fotoUsuario', '$_REQUEST[tipoUsuario]', '$_REQUEST[estadoUsuario]', '')"; 
$conexion = ConectarBD(); 
mysqli_query($conexion, $consulta) or die(" El usuario ya existe " . mysqli_error($conexion));


$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");


// ----------------------finaliza la conexion
function CerrarSesion($conexion)
{
$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");

return $CerrarSesion;
}

 echo "<script>
                alert('Usuario registrado exitosamente');
                window.location= '../navegacion/GestionUsuarios.php'
    </script>";

?>