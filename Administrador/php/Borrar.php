<?php

// ----------------------------Conexion con la base de datos

include '../../FuncConectar.php'; 

// ----------------------------------Manipulacion y borrado de datos


$IdUsuario = $_POST['IdUsuario'];

$conexion = ConectarBD();
$sql = "delete from usuario where IdUsuario = '$IdUsuario'";
$consulta = mysqli_query($conexion, $sql);


if ($sql == true) {
	echo "<script>
	alert('Borrado exitosamente');
	window.location = '../navegacion/GestionUsuarios.php';
	</script>";
}
else{ 
	echo "<script>
	alert('No se pudo borrar el usuario');
	</script>";

}

mysqli_close($conexion);


?>