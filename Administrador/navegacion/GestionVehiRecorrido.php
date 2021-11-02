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
$mostrarTabla = "SELECT * FROM asigvehiculorecorrido";
$query = mysqli_query($conexion, $mostrarTabla);
$Array = mysqli_fetch_array($query);

//---------------- CODIGO PARA REGISTRAR LOS DATOS A LA TABLA Asigvehiculorecorrido
$idAsigvehiculorecorrido = (isset($_POST['idAsigvehiculorecorrido']))?$_POST['idAsigvehiculorecorrido']:"";
$fechaAsigvehiculorecorrido = (isset($_POST['nomAsigvehiculorecorrido']))?$_POST['nomAsigvehiculorecorrido']:"";
$estadoAsigvehiculorecorrido = (isset($_POST['estadoAsigvehiculorecorrido']))?$_POST['estadoAsigvehiculorecorrido']:"";

$accion = (isset($_POST['Accion']))?$_POST['Accion']:"";

$accionAgregar = "";
$acccionModificar = $accionEliminar = $accionCancelar = "disabled";
$mostrarModal = false;

// SWITCH PARA APLICAR CASOS A CLICK DE BOTONES
switch ($accion) {
	
	case 'Agregar':
	$insertDatos = "INSERT INTO asigvehiculorecorrido(idAsigVehiculo, fechaAsigVehiculo, estadoAsigVehiculo) values('$_REQUEST[idAsigvehiculorecorrido]', '$_REQUEST[fechaAsigvehiculorecorrido]', '$_REQUEST[estadoAsigvehiculorecorrido]')";
	mysqli_query($conexion, $insertDatos) or die(" El Asigvehiculorecorrido ya existe " . mysqli_error($conexion));
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionVehiRecorrido.php");
	break;

	case 'Modificar':
	$updateDatos = "UPDATE asigvehiculorecorrido SET fechaAsigVehiculo = '$_REQUEST[fechaAsigvehiculorecorrido]', estadoAsigVehiculo = '$_REQUEST[estadoAsigvehiculorecorrido]' where idAsigVehiculo = '$_REQUEST[idAsigvehiculorecorrido]' ";
	$updateDatos = mysqli_query($conexion, $updateDatos);
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionVehiRecorrido.php");
	break;

	case 'Eliminar':
	$deleteDatos = "DELETE FROM asigvehiculorecorrido WHERE idAsigVehiculo = $idAsigvehiculorecorrido";
	$consulta = mysqli_query($conexion, $deleteDatos);
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location:  GestionVehiRecorrido.php");
	break;

	case 'Cancelar':
	header("Location: GestionVehiRecorrido.php");
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
	<title>Gestion Vehiculo Recorrido</title>
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
	</div>

	<form method="POST" action="" enctype="multipart/form-data" id="formulario">
		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Vehiculo Recorrido</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="form-row">
							<input required type="number" name="idAsigvehiculorecorrido" placeholder="idAsigvehiculorecorrido" id="idAsigvehiculorecorrido" value="<?php echo $idAsigvehiculorecorrido; ?>">
							<p style="color: #000;"><strong>Fecha</strong></p>
							<input required type="date" name="fechaAsigvehiculorecorrido" id="fechaAsigvehiculorecorrido" placeholder="Nombre" value="<?php echo $fechaAsigvehiculorecorrido; ?>">
							<p style="color: #000;"><strong>Estado Asigvehiculorecorrido</strong></p>
							<select  name="estadoAsigvehiculorecorrido" id="estadoAsigvehiculorecorrido" required>
								<option name="estadoAsigvehiculorecorrido"> <?php echo $estadoAsigvehiculorecorrido; ?></option>
								<option name="estadoAsigvehiculorecorrido" id="estadoAsigvehiculorecorrido">Activo</option>
								<option name="estadoAsigvehiculorecorrido" id="estadoAsigvehiculorecorrido">Inactivo</option>
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

	<h2>Gestion Asigvehiculorecorridos</h2>
	<!-- Button trigger modal -->
	<button type="button" class="Agregar btn btn-primary" class="BotonAgregar" data-bs-toggle="modal" data-bs-target="#exampleModal">
		Agregar registro +
	</button>
	<table id="TablaPanelDeControl">	
		<thead>
			<!-- Titulos tabla -->
			<tr>
				<th>id Vehiculo Recorrido</th>
				<th>Fecha</th>
				<th>Estado</th>
				<th class="thSeleccionar">Opciones</th>
			</tr>
		</thead>

		<tbody>
			<!-- Datos tabla -->

			<?php

			foreach ($query as $columna) 
				{?>
					<tr>
						<td><?php echo $columna['idAsigVehiculo'];?></td>
						<td><?php echo $columna['fechaAsigVehiculo'];?></td>
						<td><?php echo $columna['estadoAsigVehiculo'];?></td>
						<td  class="tdSeleccionar">
							<form action="" method="POST">
								<input type="hidden" name="idAsigvehiculorecorrido" value="<?php echo $columna['idAsigVehiculo'];?>">
								<input type="hidden" name="nomAsigvehiculorecorrido" value="<?php echo $columna['fechaAsigVehiculo'];?>">
								<input type="hidden" name="estadoAsigvehiculorecorrido" value="<?php echo $columna['estadoAsigVehiculo'];?>">
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