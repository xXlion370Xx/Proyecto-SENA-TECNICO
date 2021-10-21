<?php

// ---------------------Obtener datos

$Usuario = $_POST['Usuario'];
$Contraseña = $_POST['Contraseña'];


if ($Usuario == "Sofia" && $Contraseña == 19) {
	header("Location:../navegacion/GestionUsuarios.php");
}
else{
	header("Location:../logueo.html");
}

// Conexion con la base de datos

// include '../../FuncConectar.php';

// $conexion = ConectarBD();
// mysqli_set_charset($conexion, "utf8");


// ----------------------- Manipulacion de datos

// $consulta = "SELECT * FROM usuarioycontraseña WHERE Usuario = '$Usuario' and Contraseña = '$Contraseña' "; 
// $resultado = mysqli_query($conexion, $consulta);
// $datos = mysqli_num_rows($resultado);

// 	if ($datos>0) {
// 		echo "<script>
// 				alert('Usuario y Contraseña correctos, click en aceptar para continuar.');
// 				window.location = '../navegacion/PaginaInicio.html';
// 			</script>
// 		";
// 	}
// 	else {
// 		echo "Usuario y contraseña no encontrado";
// 	}

// ----------------------------fin de la consulta

// mysqli_free_result($resultado);
// mysqli_close($conexion);





?>