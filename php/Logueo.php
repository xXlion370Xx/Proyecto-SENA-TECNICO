<?php
session_start();

// Conexion con la base de datos

include 'FuncConectar.php';

$IdUsuario = $_POST['IdUsuario'];
$correoUsuario = $_POST['CorreoUsuario'];
$Contraseña = $_POST['Contraseña'];
$Array = ["Administrador", "Conductor", "Relevador", "Calibrador"];

$conexion = ConectarBD();
mysqli_set_charset($conexion, "utf8");


// ----------------------- Manipulacion de datos

$consulta = "SELECT * FROM Usuario WHERE idUsuario = '$IdUsuario' and correoUsuario = '$correoUsuario' and passwordUsuario = '$Contraseña' "; 
$resultado = mysqli_query($conexion, $consulta);
$datos = mysqli_num_rows($resultado);
	
	if ($datos>0 and $_SESSION['TipoUsuario'] == $Array[0]) {
		header("Location:../Administrador/navegacion/GestionUsuarios.php");
			}
			elseif ($datos>0 and $_SESSION['TipoUsuario'] == $Array[1]) {
			header("Location:../Conductor/navegacion/GestionVehiRecorrido.php");
				}
				elseif ($datos>0 and $_SESSION['TipoUsuario'] == $Array[2]) {
					header("Location:../Relevador/navegacion/GestionVehiRecorrido.php");
					}
					elseif ($datos>0 and $_SESSION['TipoUsuario'] == $Array[3]) {
						header("Location:../Calibrador/navegacion/GestionRecorrido.php");
					}
	else {
	echo "<script>
				alert('Usuario y/o contraseña incorrectos.');
				window.location = '../SeleccionTipoUsuario.html';
		</script>
		";
}

// ----------------------------fin de la consulta

mysqli_free_result($resultado);
mysqli_close($conexion);



?>