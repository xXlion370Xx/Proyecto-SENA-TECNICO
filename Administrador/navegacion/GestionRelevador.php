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
$mostrarTabla = "SELECT * FROM relevador";
$query = mysqli_query($conexion, $mostrarTabla);
$Array = mysqli_fetch_array($query);

//---------------- CODIGO PARA REGISTRAR LOS DATOS A LA TABLA USUARIO
$idRelevador = (isset($_POST['idRelevador']))?$_POST['idRelevador']:"";
$tipoDocRelevador = (isset($_POST['tipoDocRelevador']))?$_POST['tipoDocRelevador']:"";
$numDocRelevador = (isset($_POST['numDocRelevador']))?$_POST['numDocRelevador']:"";
$nombreRelevador = (isset($_POST['nombreRelevador']))?$_POST['nombreRelevador']:"";
$apellidoRelevador = (isset($_POST['apellidoRelevador']))?$_POST['apellidoRelevador']:"";
$fechaNacimRelevador = (isset($_POST['fechaNacimRelevador']))?$_POST['fechaNacimRelevador']:"";
$telefonoRelevador = (isset($_POST['telefonoRelevador']))?$_POST['telefonoRelevador']:"";
$direccionRelevador = (isset($_POST['direccionRelevador']))?$_POST['direccionRelevador']:"";
$numcelularRelevador = (isset($_POST['numcelularRelevador']))?$_POST['numcelularRelevador']:"";
$rhRelevador = (isset($_POST['rhRelevador']))?$_POST['rhRelevador']:"";
$nomContacEmergencia = (isset($_POST['nomContacEmergencia']))?$_POST['nomContacEmergencia']:"";
$telContactEmergencia = (isset($_POST['telContactEmergencia']))?$_POST['telContactEmergencia']:"";
$estadoRelevador = (isset($_POST['estadoRelevador']))?$_POST['estadoRelevador']:"";	

$accion = (isset($_POST['Accion']))?$_POST['Accion']:"";

$accionAgregar = "";
$acccionModificar = $accionEliminar = $accionCancelar = "disabled";
$mostrarModal = false;

// SWITCH PARA APLICAR CASOS A CLICK DE BOTONES
switch ($accion) {
	case 'Agregar':

	$insertDatos = "INSERT INTO `relevador`(idRelevador, `tipoDocRelevador`, `numDocRelevador`, `nombreRelevador`, `apellidoRelevador`, `fechaNacimRelevador`, `telefonoRelevador`, `direccionRelevador`, `numcelularRelevador`, `rhRelevador`, `nomContacEmergencia`, `telContactEmergencia`, `estadoRelevador`) VALUES ('$_REQUEST[idRelevador]', '$_REQUEST[tipoDocRelevador]', '$_REQUEST[numDocRelevador]', '$_REQUEST[nombreRelevador]', '$_REQUEST[apellidoRelevador]', '$_REQUEST[fechaNacimRelevador]', '$_REQUEST[telefonoRelevador]', '$_REQUEST[direccionRelevador]', '$_REQUEST[numcelularRelevador]', '$_REQUEST[rhRelevador]', '$_REQUEST[nomContacEmergencia]', '$_REQUEST[telContactEmergencia]', '$_REQUEST[estadoRelevador]')"; 
	
	mysqli_query($conexion, $insertDatos) or die(" El usuario ya existe " . mysqli_error($conexion));
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionRelevador.php");
	break;

	case 'Modificar':
	echo "Presionaste Modificar";
	$updateDatos = "UPDATE `relevador` SET `tipoDocRelevador`= '$_REQUEST[tipoDocRelevador]',`numDocRelevador` = '$_REQUEST[numDocRelevador]' , `nombreRelevador` = '$_REQUEST[nombreRelevador]', `apellidoRelevador` = '$_REQUEST[apellidoRelevador]',`fechaNacimRelevador` = '$_REQUEST[fechaNacimRelevador]', `telefonoRelevador` = '$_REQUEST[telefonoRelevador]', `direccionRelevador` = '$_REQUEST[direccionRelevador]' ,`numcelularRelevador` = '$_REQUEST[numcelularRelevador]', `rhRelevador` = '$_REQUEST[rhRelevador]', `nomContacEmergencia` = '$_REQUEST[nomContacEmergencia]',`telContactEmergencia` = '$_REQUEST[telContactEmergencia]', `estadoRelevador` = '$_REQUEST[estadoRelevador]' where `idRelevador` = '$_REQUEST[idRelevador]' ";
	$updateDatos = mysqli_query($conexion, $updateDatos);
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionRelevador.php");
	break;

	case 'Eliminar':
	echo "Presionaste Eliminar";
	$deleteDatos = "DELETE FROM relevador WHERE idRelevador = $idRelevador";
	$consulta = mysqli_query($conexion, $deleteDatos);
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionRelevador.php");
	break;

	case 'Cancelar':
	header("Location: GestionRelevador.php");
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
	<title>Gestion Relevador</title>
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
			<li class="nav__li"><i class=" fas fa-user"></i><a href="GestionUsuarios.php">Gestion Usuarios</a></li>
			<li class="nav__li"><i class=" fas fa-tv"></i><a href="GestionConductor.php">Gestion Conductor</a></li>
			<li class="nav__li"><i class=" fas fa-tv"></i><a href="GestionRelevador.php">Gestion Relevador</a></li>
			<li class="nav__li"><i class=" fas fa-tv"></i><a href="GestionCalibrador.php">Gestion Calibrador</a></li>
			<li class="nav__li"><i class=" fas fa-tv"></i><a href="GestionRecorrido.php">Gestion Recorrido</a></li>
			<li class="nav__li"><i class=" fas fa-tv"></i><a href="GestionVehiRecorrido.php">Gestion Vehiculorecorrido</a></li>
			<li class="nav__li"><i class=" fas fa-car"></i><a href="GestionVehiculo.php">Gestion Vehiculo</a></li>
			<li class="nav__li"><i class=" fas fa-tv"></i><a href="GestionMarca.php">Gestion Marca</a></li>
			<li class="nav__li"><i class=" fas fa-tv"></i><a href="GestionDestino.php">Gestion Destino</a></li>
		</ul>
	</div>
	<form method="POST" action="" id="formulario">
		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Relevador</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="form-row">
							<input required type="number" name="idRelevador" placeholder="idRelevador" id="idRelevador" value="<?php echo $idRelevador; ?>">
							<p style="color: #000;"><strong>Tipo doc Relevador</strong></p>
							<select required class="inputs" name="tipoDocRelevador">
								<option><?php
								echo $tipoDocRelevador;?></option>
								<option name="tipoDocRelevador">C.C</option>
								<option name="tipoDocRelevador">T.I</option>
								<option name="tipoDocRelevador">Cedula de Extranjeria</option>
							</select> 
							<input required class="inputs" type="number" name="numDocRelevador" placeholder="Número de Documento" value="<?php echo $numDocRelevador; ?>">
							<input required class="inputs" type="text" name="nombreRelevador" placeholder="Nombre" value="<?php echo $nombreRelevador ?>">
							<input required class="inputs" type="text" name="apellidoRelevador" placeholder="Apellido" value="<?php echo $apellidoRelevador ?>">
							<p style="color: #000;"><strong>Fecha de nacimiento</strong></p>
							<input required class="inputs" type="date" name="fechaNacimRelevador" placeholder="Fecha de nacimiento" value="<?php echo $fechaNacimRelevador ?>">
							<input required class="inputs" type="number" name="telefonoRelevador" placeholder="Telefono" value="<?php echo $telefonoRelevador ?>">
							<input required class="inputs" type="text" name="direccionRelevador" placeholder="Dirección" value="<?php echo $direccionRelevador ?>">
							<input required class="inputs" type="text" name="numcelularRelevador" placeholder="Número Celular" value="<?php echo $numcelularRelevador ?>">
							<input required class="inputs" type="text" name="rhRelevador" placeholder="RH del Relevador" value="<?php echo $rhRelevador ?>">
							<input required class="inputs" type="text" name="nomContacEmergencia" placeholder="Nombre de contacto de emergencia" value="<?php echo $nomContacEmergencia ?>">
							<input required class="inputs" type="number" name="telContactEmergencia" placeholder="Teléfono de emergencia" value="<?php echo $telContactEmergencia; ?>">
							<p style="color: #000;"><strong>Estado Relevador</strong></p>
							<select required name="estadoRelevador">
								<option name="estadoRelevador"><?php echo $estadoRelevador; ?></option>
								<option name="estadoRelevador">Activo</option>
								<option name="estadoRelevador">Inactivo</option>
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

	<h2>Gestion Relevadores</h2>
	<!-- Button trigger modal -->
	<button type="button" class="Agregar btn btn-primary" class="BotonAgregar" data-bs-toggle="modal" data-bs-target="#exampleModal">
		Agregar registro +
	</button>

	<table>
		<!-- Titulos -->
		<thead>
			<th>id Relevador</th>
			<th>TipoDocRelevador</th>
			<th>Num Doc Relevador</th>
			<th>Nombre Relevador</th>
			<th>Apellido Relevador</th>
			<th>Fecha Nacimiento</th>
			<th>Telefono Relevador</th>
			<th>Direccion Relevador</th>
			<th>Numero Celular</th>
			<th>RH Relevador</th>
			<th>Nom Contacto Emergencia</th>
			<th>Tel Contacto Emergencia</th>
			<th>Estado Relevador</th>
			<th class="thSeleccionar">Opciones</th>
		</thead>

		<tbody>
			<!-- Datos Tabla -->
			<?php

			foreach ($query as $columna) 
				{?>
					<tr>
						<td><?php echo $columna['idRelevador'];?></td>
						<td><?php echo $columna['tipoDocRelevador'];?></td>
						<td><?php echo $columna['numDocRelevador'];?></td>
						<td><?php echo $columna['nombreRelevador'];?></td>
						<td><?php echo $columna['apellidoRelevador'];?></td>
						<td><?php echo $columna['fechaNacimRelevador'];?></td>
						<td><?php echo $columna['telefonoRelevador'];?></td>
						<td><?php echo $columna['direccionRelevador'];?></td>
						<td><?php echo $columna['numcelularRelevador'];?></td>
						<td><?php echo $columna['rhRelevador'];?></td>
						<td><?php echo $columna['nomContacEmergencia'];?></td>
						<td><?php echo $columna['telContactEmergencia'];?></td>
						<td><?php echo $columna['estadoRelevador'];?></td>
						<td class="tdSeleccionar">
							<form action="" method="POST">
								<input required type="hidden" name="idRelevador" placeholder="idRelevador" id="idRelevador" value="<?php echo $columna['idRelevador']; ?>">
								<input type="hidden" class="inputs" name="tipoDocRelevador" value="<?php echo $columna['tipoDocRelevador']; ?>">
								<input class="inputs" type="hidden" name="numDocRelevador" placeholder="Número de Documento" value="<?php echo $columna['numDocRelevador']; ?>">
								<input class="inputs" type="hidden" name="nombreRelevador" placeholder="Nombre" value="<?php echo $columna['nombreRelevador']; ?>">
								<input class="inputs" type="hidden" name="apellidoRelevador" placeholder="Apellido" value="<?php echo $columna['apellidoRelevador']; ?>">
								<input class="inputs" type="hidden" name="fechaNacimRelevador" placeholder="Fecha de nacimiento" value="<?php echo $columna['fechaNacimRelevador']; ?>">
								<input class="inputs" type="hidden" name="telefonoRelevador" placeholder="Telefono" value="<?php echo $columna['telefonoRelevador']; ?>">
								<input class="inputs" type="hidden" name="direccionRelevador" placeholder="Dirección" value="<?php echo $columna['direccionRelevador']; ?>">
								<input class="inputs" type="hidden" name="numcelularRelevador" placeholder="Número Celular" value="<?php echo $columna['numcelularRelevador']; ?>">
								<input class="inputs" type="hidden" name="rhRelevador" placeholder="RH del Relevador" value="<?php echo $columna['rhRelevador']; ?>">
								<input class="inputs" type="hidden" name="nomContacEmergencia" placeholder="Nombre de contacto de emergencia" value="<?php echo $columna['nomContacEmergencia']; ?>">
								<input class="inputs" type="hidden" name="telContactEmergencia" placeholder="Teléfono de emergencia" value="<?php echo $columna['telContactEmergencia']; ?>">
								<input type="hidden" name="estadoRelevador" class="inputs" value="<?php echo $columna['estadoRelevador']; ?>">
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