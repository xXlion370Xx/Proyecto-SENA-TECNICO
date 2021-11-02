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
$mostrarTabla = "SELECT * FROM vehiculo";
$query = mysqli_query($conexion, $mostrarTabla);
$Array = mysqli_fetch_array($query);

//---------------- CODIGO PARA REGISTRAR LOS DATOS A LA TABLA VEHICULO
$idVehiculo = (isset($_POST['idVehiculo']))?$_POST['idVehiculo']:"";
$placaVehiculo = (isset($_POST['placaVehiculo']))?$_POST['placaVehiculo']:"";
$fechaMatricula = (isset($_POST['fechaMatricula']))?$_POST['fechaMatricula']:"";
$modeloVehiculo = (isset($_POST['modeloVehiculo']))?$_POST['modeloVehiculo']:"";
$tipoVehiculo = (isset($_POST['tipoVehiculo']))?$_POST['tipoVehiculo']:"";
$estadoVehiculo = (isset($_POST['estadoVehiculo']))?$_POST['estadoVehiculo']:"";

$accion = (isset($_POST['Accion']))?$_POST['Accion']:"";

$accionAgregar = "";
$acccionModificar = $accionEliminar = $accionCancelar = "disabled";
$mostrarModal = false;

// SWITCH PARA APLICAR CASOS A CLICK DE BOTONES
switch ($accion) {
	
	case 'Agregar':
	$insertDatos = "INSERT INTO vehiculo(idVehiculo, placaVehiculo, fechaMatricula, modeloVehiculo, tipoVehiculo, estadoVehiculo) values('$_REQUEST[idVehiculo]','$_REQUEST[placaVehiculo]', '$_REQUEST[fechaMatricula]', '$_REQUEST[modeloVehiculo]', '$_REQUEST[tipoVehiculo]', '$_REQUEST[estadoVehiculo]')";
	mysqli_query($conexion, $insertDatos) or die(" El usuario ya existe " . mysqli_error($conexion));
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionVehiculo.php");
	break;

	case 'Modificar':
	$updateDatos = "UPDATE vehiculo SET placaVehiculo = '$_REQUEST[placaVehiculo]', fechaMatricula = '$_REQUEST[fechaMatricula]', modeloVehiculo = '$_REQUEST[modeloVehiculo]', tipoVehiculo = '$_REQUEST[tipoVehiculo]',  estadoVehiculo = '$_REQUEST[estadoVehiculo]' where idVehiculo = '$_REQUEST[idVehiculo]' ";
	$updateDatos = mysqli_query($conexion, $updateDatos);
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionVehiculo.php");
	break;

	case 'Eliminar':
	echo "Presionaste Eliminar";
	$deleteDatos = "DELETE FROM vehiculo WHERE idVehiculo = $idVehiculo";
	$consulta = mysqli_query($conexion, $deleteDatos);
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionVehiculo.php");
	break;

	case 'Cancelar':
	header("Location: GestionVehiculo.php");
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
	<title>Gestion Vehiculo</title>
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
	<h1>Unión Transportadora Norte y Sur</h1> 
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
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Vehiculo</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="form-row">
							<input required type="number" name="idVehiculo" placeholder="id Vehiculo" value="<?php echo $idVehiculo ?>">
							<input required class="inputs" type="text" name="placaVehiculo" placeholder="Placa" value="<?php echo $placaVehiculo ?>">
							<p style="color: #000;"><strong>Fecha de Matricula</strong></p><input required class="inputs" type="date" name="fechaMatricula" placeholder="Fecha de Matricula" value="<?php echo $fechaMatricula; ?>">
							<input required class="inputs" type="text" name="modeloVehiculo" placeholder="Modelo Vehicular" value="<?php echo $modeloVehiculo; ?>">
							<input required class="inputs" type="text" name="tipoVehiculo" placeholder="Tipo de Vehiculo" value="<?php echo $tipoVehiculo; ?>">
							<p style="color: #000;"><strong>Estado Vehiculo</strong></p>
							<select required name="estadoVehiculo" id="estadoVehiculo">
								<option name="estadoVehiculo"> <?php echo $estadoVehiculo; ?></option>
								<option name="estadoVehiculo">Activo</option>
								<option name="estadoVehiculo">Inactivo</option>
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
	<h2>Gestion Vehiculo</h2>
	<!-- Button trigger modal -->
	<button type="button" class="Agregar btn btn-primary" class="BotonAgregar" data-bs-toggle="modal" data-bs-target="#exampleModal">
		Agregar registro +
	</button>
	<table>
		<thead>
			<!-- Titulos tabla -->
			<tr>
				<th>id Vehiculo</th>
				<th>Placa Vehiculo</th>
				<th>Fecha Matricula</th>
				<th>Modelo Vehiculo</th>
				<th>Tipo Vehiculo</th>
				<th>Estado Vehiculo</th>
				<th class="thSeleccionar">Opciones</th>	
			</tr>
		</thead>
		<tbody>
			<!-- Datos Tabla -->
			<?php

			foreach ($query as $columna) 
				{?>
					<tr>
						<td><?php echo $columna['idVehiculo'];?></td>
						<td><?php echo $columna['placaVehiculo'];?></td>
						<td><?php echo $columna['fechaMatricula'];?></td>
						<td><?php echo $columna['modeloVehiculo'];?></td>
						<td><?php echo $columna['tipoVehiculo'];?></td>
						<td><?php echo $columna['estadoVehiculo'];?></td>
						<td class="tdSeleccionar">
							<form action="" method="POST">
								<input required type="hidden" name="idVehiculo" value="<?php echo $columna['idVehiculo'];?>">
								<input required class="inputs" type="hidden" name="placaVehiculo" placeholder="Placa" value="<?php echo $columna['placaVehiculo'];?>">
								<input required class="inputs" type="hidden" name="fechaMatricula" placeholder="Fecha de Matricula" value="<?php echo $columna['fechaMatricula'];?>">
								<input required class="inputs" type="hidden" name="modeloVehiculo" placeholder="Modelo Vehicular" value="<?php echo $columna['modeloVehiculo'];?>">
								<input required class="inputs" type="hidden" name="tipoVehiculo" placeholder="Tipo de Vehiculo" value="<?php echo $columna['tipoVehiculo'];?>">
								<input required type="hidden" name="estadoVehiculo" value="<?php echo $columna['estadoVehiculo'];?>">
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
		</footer>
		<script type="text/javascript" src="../../jsBootstrap/bootstrap.js"></script>
		<?php if($mostrarModal){?>
			<script>
				$('#exampleModal').modal('show');
			</script>

		<?php }?> 
	</body>
	</html>