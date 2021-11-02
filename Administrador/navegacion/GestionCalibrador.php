<?php
session_start();

if ($_SESSION['TipoUsuario'] == null) {
	echo "<script>
	alert('No tienes acceso a este sitio');
	window.location = '../../SeleccionTipoUsuario.html';
	</script>";
	die();
}

include '../../php/FuncConectar.php';

// ----------------CODIGO PARA MOSTRAR DATOS EN LA TABLA
$conexion = ConectarBD();
$mostrarTabla = "SELECT * FROM calibrador";
$query = mysqli_query($conexion, $mostrarTabla);
$Array = mysqli_fetch_array($query);

//---------------- CODIGO PARA REGISTRAR LOS DATOS A LA TABLA USUARIO
$idCalibrador = (isset($_POST['idCalibrador']))?$_POST['idCalibrador']:"";
$tipoDocCalibrador = (isset($_POST['tipoDocCalibrador']))?$_POST['tipoDocCalibrador']:"";
$numDocCalibrador = (isset($_POST['numDocCalibrador']))?$_POST['numDocCalibrador']:"";
$nombreCalibrador = (isset($_POST['nombreCalibrador']))?$_POST['nombreCalibrador']:"";
$apellidoCalibrador = (isset($_POST['apellidoCalibrador']))?$_POST['apellidoCalibrador']:"";
$fechaNacimCalibrador = (isset($_POST['fechaNacimCalibrador']))?$_POST['fechaNacimCalibrador']:"";
$telefonoCalibrador = (isset($_POST['telefonoCalibrador']))?$_POST['telefonoCalibrador']:"";
$direccionCalibrador = (isset($_POST['direccionCalibrador']))?$_POST['direccionCalibrador']:"";
$numcelularCalibrador = (isset($_POST['numcelularCalibrador']))?$_POST['numcelularCalibrador']:"";
$estadoCalibrador = (isset($_POST['estadoCalibrador']))?$_POST['estadoCalibrador']:"";	

$accion = (isset($_POST['Accion']))?$_POST['Accion']:"";

$accionAgregar = "";
$acccionModificar = $accionEliminar = $accionCancelar = "disabled";
$mostrarModal = false;

// SWITCH PARA APLICAR CASOS A CLICK DE BOTONES
switch ($accion) {
	case 'Agregar':

	$insertDatos = "INSERT INTO `calibrador`(idCalibrador, `tipoDocCalibrador`, `numDocCalibrador`, `nombreCalibrador`, `apellidoCalibrador`, `fechaNacimCalibrador`, `telefonoCalibrador`, `direccionCalibrador`, `numcelularCalibrador`, `estadoCalibrador`) VALUES ('$_REQUEST[idCalibrador]', '$_REQUEST[tipoDocCalibrador]', '$_REQUEST[numDocCalibrador]', '$_REQUEST[nombreCalibrador]', '$_REQUEST[apellidoCalibrador]', '$_REQUEST[fechaNacimCalibrador]', '$_REQUEST[telefonoCalibrador]', '$_REQUEST[direccionCalibrador]', '$_REQUEST[numcelularCalibrador]', '$_REQUEST[estadoCalibrador]')"; 
	
	mysqli_query($conexion, $insertDatos) or die(" El usuario ya existe " . mysqli_error($conexion));
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionCalibrador.php");
	break;

	case 'Modificar':
	echo "Presionaste Modificar";
	$updateDatos = "UPDATE `calibrador` SET `tipoDocCalibrador`= '$_REQUEST[tipoDocCalibrador]',`numDocCalibrador` = '$_REQUEST[numDocCalibrador]' , `nombreCalibrador` = '$_REQUEST[nombreCalibrador]', `apellidoCalibrador` = '$_REQUEST[apellidoCalibrador]',`fechaNacimCalibrador` = '$_REQUEST[fechaNacimCalibrador]', `telefonoCalibrador` = '$_REQUEST[telefonoCalibrador]', `direccionCalibrador` = '$_REQUEST[direccionCalibrador]' ,`numcelularCalibrador` = '$_REQUEST[numcelularCalibrador]', `estadoCalibrador` = '$_REQUEST[estadoCalibrador]' where `idCalibrador` = '$_REQUEST[idCalibrador]' ";
	$updateDatos = mysqli_query($conexion, $updateDatos);
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionCalibrador.php");
	break;

	case 'Eliminar':
	echo "Presionaste Eliminar";
	$deleteDatos = "DELETE FROM calibrador WHERE idCalibrador = $idCalibrador";
	$consulta = mysqli_query($conexion, $deleteDatos);
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionCalibrador.php");
	break;

	case 'Cancelar':
	header("Location: GestionCalibrador.php");
	break;

	case 'Seleccionar':
	$accionAgregar = "disabled";
	$acccionModificar = $accionEliminar = $accionCancelar = "";
	$mostrarModal = true; 
	break;
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Gestion Calibrador</title>
	<link rel="stylesheet" type="text/css" href="../../cssBootstrap/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/GestionUsuarios.css">
	<link rel="icon" type="image/png" href="../../img/Rueda.png">
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600&family=Vollkorn&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/solid.css">
	<script src="https://kit.fontawesome.com/c9814e8fb5.js" crossorigin="anonymous"></script>
	<script defer type="text/javascript" src="../../js/MovimientoMenu.js"></script>
</head>
<body>

	<a href="../../CerrarSesion.php" class="CerrarSesion">Cerrar Sesion</a>  

	<h1 id="h1_titulo">Unión Transportadora Norte y Sur</h1>  
	<button class="toggle">
		<i class="uis uis-bars"></i>
	</button>
	<div class="nav">
		<ul class="nav__ul">
			<ul class="nav__ul">
			<li class="nav__li"><i class=" fas fa-user"></i><a href="GestionUsuarios.php">Gestion Usuarios</a></li>
			<li class="nav__li"><i class=" fas fa-tv"></i><a href="GestionConductor.php">Gestion Conductor</a></li>
			<li class="nav__li"><i class=" fas fa-tv"></i><a href="GestionRelevador.php">Gestion Relevador</a></li>
			<li class="nav__li"><i class=" fas fa-tv"></i><a href="GestionCalibrador.php">Gestion Calibrador</a></li>
			<li class="nav__li"><i class=" fas fa-tv"></i><a href="GestionRecorrido.php">Gestion Recorrido</a></li>
			<li class="nav__li"><i class=" fas fa-tv"></i><a href="GestionVehiRecorrido.php">Gestion VehiculoRecorrido</a></li>
			<li class="nav__li"><i class=" fas fa-car"></i><a href="GestionVehiculo.php">Gestion Vehiculo</a></li>
			<li class="nav__li"><i class=" fas fa-tv"></i><a href="GestionMarca.php">Gestion Marca</a></li>
			<li class="nav__li"><i class=" fas fa-tv"></i><a href="GestionDestino.php">Gestion Destino</a></li>		
		</ul>		
		</ul>
	</div>
	<form method="POST" action="" id="formulario">
		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Calibrador</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="form-row">
							<input required type="number" name="idCalibrador" placeholder="idCalibrador" id="idCalibrador" value="<?php echo $idCalibrador; ?>">
							<p style="color: #000;"><strong>Tipo doc Calibrador</strong></p>
							<select required class="inputs" name="tipoDocCalibrador">
								<option><?php
								echo $tipoDocCalibrador;?></option>
								<option name="tipoDocCalibrador">C.C</option>
								<option name="tipoDocCalibrador">T.I</option>
								<option name="tipoDocCalibrador">Cedula de Extranjeria</option>
							</select> 
							<input required class="inputs" type="number" name="numDocCalibrador" placeholder="Número de Documento" value="<?php echo $numDocCalibrador; ?>">
							<input required class="inputs" type="text" name="nombreCalibrador" placeholder="Nombre" value="<?php echo $nombreCalibrador ?>">
							<input required class="inputs" type="text" name="apellidoCalibrador" placeholder="Apellido" value="<?php echo $apellidoCalibrador ?>">
							<p style="color: #000;"><strong>Fecha de nacimiento</strong></p>
							<input required class="inputs" type="date" name="fechaNacimCalibrador" placeholder="Fecha de nacimiento" value="<?php echo $fechaNacimCalibrador ?>">
							<input required class="inputs" type="number" name="telefonoCalibrador" placeholder="Telefono" value="<?php echo $telefonoCalibrador ?>">
							<input required class="inputs" type="text" name="direccionCalibrador" placeholder="Dirección" value="<?php echo $direccionCalibrador ?>">
							<input required class="inputs" type="text" name="numcelularCalibrador" placeholder="Número Celular" value="<?php echo $numcelularCalibrador ?>">
							<p style="color: #000;"><strong>Estado Calibrador</strong></p>
							<select required name="estadoCalibrador">
								<option name="estadoCalibrador"><?php echo $estadoCalibrador; ?></option>
								<option name="estadoCalibrador">Activo</option>
								<option name="estadoCalibrador">Inactivo</option>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" <?php echo $accionAgregar ?> class="btn btn-success" name="Accion" value="Agregar">Agregar</button>
						<button type="submit" <?php echo $acccionModificar ?> class="btn btn-warning" name="Accion" value="Modificar">Modificar</button>
						<button type="submit" <?php echo $accionEliminar ?> class="btn btn-danger" name="Accion" value="Eliminar">Eliminar</button>
						<button type="submit" <?php echo $accionCancelar ?> class="btn btn-primary" name="Accion" value="Cancelar">Cancelar</button>
					</div>
				</div>
			</div>
		</div>	
	</form>

	<h2>Gestion Calibradores</h2>
	<!-- Button trigger modal -->
	<button type="button" class="Agregar btn btn-primary" class="BotonAgregar" data-bs-toggle="modal" data-bs-target="#exampleModal">
		Agregar registro +
	</button>

	<table>
		<!-- Titulos -->
		<thead>
			<th>id Calibrador</th>
			<th>TipoDocCalibrador</th>
			<th>Num Doc Calibrador</th>
			<th>Nombre Calibrador</th>
			<th>Apellido Calibrador</th>
			<th>Fecha Nacimiento</th>
			<th>Telefono Calibrador</th>
			<th>Direccion Calibrador</th>
			<th>Numero Celular</th>
			<th>Estado Calibrador</th>
			<th class="thSeleccionar">Opciones</th>
		</thead>

		<tbody>
			<!-- Datos Tabla -->
			<?php

			foreach ($query as $columna) 
				{?>
					<tr>
						<td><?php echo $columna['idCalibrador'];?></td>
						<td><?php echo $columna['tipoDocCalibrador'];?></td>
						<td><?php echo $columna['numDocCalibrador'];?></td>
						<td><?php echo $columna['nombreCalibrador'];?></td>
						<td><?php echo $columna['apellidoCalibrador'];?></td>
						<td><?php echo $columna['fechaNacimCalibrador'];?></td>
						<td><?php echo $columna['telefonoCalibrador'];?></td>
						<td><?php echo $columna['direccionCalibrador'];?></td>
						<td><?php echo $columna['numcelularCalibrador'];?></td>
						<td><?php echo $columna['estadoCalibrador'];?></td>
						<td class="tdSeleccionar">
							<form action="" method="POST">
								<input required type="hidden" name="idCalibrador" placeholder="idCalibrador" id="idCalibrador" value="<?php echo $columna['idCalibrador']; ?>">
								<input type="hidden" class="inputs" name="tipoDocCalibrador" value="<?php echo $columna['tipoDocCalibrador']; ?>">
								<input class="inputs" type="hidden" name="numDocCalibrador" placeholder="Número de Documento" value="<?php echo $columna['numDocCalibrador']; ?>">
								<input class="inputs" type="hidden" name="nombreCalibrador" placeholder="Nombre" value="<?php echo $columna['nombreCalibrador']; ?>">
								<input class="inputs" type="hidden" name="apellidoCalibrador" placeholder="Apellido" value="<?php echo $columna['apellidoCalibrador']; ?>">
								<input class="inputs" type="hidden" name="fechaNacimCalibrador" placeholder="Fecha de nacimiento" value="<?php echo $columna['fechaNacimCalibrador']; ?>">
								<input class="inputs" type="hidden" name="telefonoCalibrador" placeholder="Telefono" value="<?php echo $columna['telefonoCalibrador']; ?>">
								<input class="inputs" type="hidden" name="direccionCalibrador" placeholder="Dirección" value="<?php echo $columna['direccionCalibrador']; ?>">
								<input class="inputs" type="hidden" name="numcelularCalibrador" placeholder="Número Celular" value="<?php echo $columna['numcelularCalibrador']; ?>">
								<input type="hidden" name="estadoCalibrador" class="inputs" value="<?php echo $columna['estadoCalibrador']; ?>">
								<button type="submit" name="Accion" class="btn btn-seleccionar" value="Seleccionar">Seleccionar</button>
							</form>
						</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>

		<footer>
			<p>¡Siguenos!</p>

			<a href="https://www.facebook.com/profile.php?id=100005910945632" target="blank"><img class="ima" src="../../img/facebook.png" style="width: 3%"></a>
			<a href="https://twitter.com/Danielillopill3"  target="blank"><img class="ima" src="../../img/twitter.png" style="width: 3%"></a>
			<a href="https://www.youtube.com/channel/UCzHd5ilTV8jMYYD6k2RXrvw"  target="blank"><img class="ima" src="../../img/Youtube.png" style="width: 3%"></a>

			<p>&#169:Todos los derechos reservados</p>
			<div>Iconos diseñados por <a href="" title="dmitri13">dmitri13</a> from <a href="https://www.flaticon.es/" title="Flaticon">www.flaticon.es</a></div>
			<script type="text/javascript" src="../../jsBootstrap/bootstrap.js"></script>
		</footer>

		<?php if($mostrarModal){?>
			<script>
				$('#exampleModal').modal('show');
			</script>

		<?php }?> 
	</body>
	</html>