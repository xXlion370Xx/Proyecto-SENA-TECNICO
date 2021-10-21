<?php

// --------------------------------------------Conexion con la base de datos

include '../../FuncConectar.php';


// --------------------------Manipulacion de datos


$consulta = "insert into usuario(correoUsuario, passwordUsuario, fotoUsuario, tipoUsuario, estadoUsuario) values('$_REQUEST[correoUsuario]','$_REQUEST[passwordUsuario]', '$_REQUEST[fotoUsuario]', '$_REQUEST[tipoUsuario]', '$_REQUEST[estadoUsuario]')"; 
$conexion = ConectarBD(); 
mysqli_query($conexion, $consulta) or die(" El usuario ya existe " . mysqli_error($conexion));




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