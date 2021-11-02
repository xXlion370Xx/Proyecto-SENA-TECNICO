<?php
// Include para conectarnos a la base de datos

include '../../FuncConectar.php';



function FuncAtualizar()
{
	$conexion = ConectarBD();
	$consulta = "update usuario set correoUsuario = '$_REQUEST[correoUsuario]', passwordUsuario = '$_REQUEST[passwordUsuario]', fotoUsuario = '$_REQUEST[fotoUsuario]', tipoUsuario = '$_REQUEST[tipoUsuario]', estadoUsuario = '$_REQUEST[estadoUsuario]' where IdUsuario = '$_REQUEST[IdUsuario]' ";
	$consulta = mysqli_query($conexion, $consulta);

return $consulta;
}

$function = FuncAtualizar();

if ($function == true) {
	echo "<script>
		alert('Dato modificado correctamente');
		window.location = '../navegacion/GestionUsuarios.php'
	</script>";	
}
elseif($function == false)
{
	echo"Dato no se pudo actulizar";
}

 

?>
