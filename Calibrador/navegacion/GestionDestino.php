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
$mostrarTabla = "SELECT * FROM destino";
$query = mysqli_query($conexion, $mostrarTabla);
$Array = mysqli_fetch_array($query);

//---------------- CODIGO PARA REGISTRAR LOS DATOS A LA TABLA USUARIO
$idDestino = (isset($_POST['idDestino']))?$_POST['idDestino']:"";
$nomDestino = (isset($_POST['nomDestino']))?$_POST['nomDestino']:"";
$direccionDestino = (isset($_POST['direccionDestino']))?$_POST['direccionDestino']:"";
$nomRespDestino = (isset($_POST['nomRespDestino']))?$_POST['nomRespDestino']:"";
$telefonoDestino = (isset($_POST['telefonoDestino']))?$_POST['telefonoDestino']:""; 
$numcelularDestino = (isset($_POST['numcelularDestino']))?$_POST['numcelularDestino']:"";
$estadoDestino = (isset($_POST['estadoDestino']))?$_POST['estadoDestino']:"";

$accion = (isset($_POST['Accion']))?$_POST['Accion']:"";

$accionAgregar = "";
$acccionModificar = $accionEliminar = $accionCancelar = "disabled";
$mostrarModal = false;

// SWITCH PARA APLICAR CASOS A CLICK DE BOTONES
switch ($accion) {
	
	case 'Agregar':
	$insertDatos = "INSERT INTO `destino`(`idDestino`, `nomDestino`, `direccionDestino`, `nomRespDestino`, `telefonoDestino`, `numcelularDestino`, `estadoDestino`) VALUES ('$_REQUEST[idDestino]','$_REQUEST[nomDestino]','$_REQUEST[direccionDestino]', '$_REQUEST[nomRespDestino]', '$_REQUEST[telefonoDestino]', '$_REQUEST[numcelularDestino]', '$_REQUEST[estadoDestino]')";
	mysqli_query($conexion, $insertDatos) or die(" El usuario ya existe " . mysqli_error($conexion));
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionDestino.php");
	break;

	case 'Modificar':
	$updateDatos = "UPDATE `destino` SET nomDestino = '$_REQUEST[nomDestino]', direccionDestino = '$_REQUEST[direccionDestino]', `nomRespDestino` = '$_REQUEST[nomRespDestino]',`telefonoDestino` = '$_REQUEST[telefonoDestino]', `numcelularDestino` = '$_REQUEST[numcelularDestino]', `estadoDestino` = '$_REQUEST[estadoDestino]' WHERE `idDestino`= '$_REQUEST[idDestino]'";
	$updateDatos = mysqli_query($conexion, $updateDatos);
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionDestino.php");
	break;

	case 'Eliminar':
	$deleteDatos = "DELETE FROM destino WHERE idDestino = $idDestino";
	$consulta = mysqli_query($conexion, $deleteDatos);
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionDestino.php");
	break;

	case 'Cancelar':
	header("Location: GestionDestino.php");
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
	<title>Gestion Usuario</title>
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

	<form method="POST" action="" enctype="multipart/form-data" id="formulario">
		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Destino</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="form-row">
							<input required type="number" name="idDestino" placeholder="id Destino" value="<?php echo$idDestino;?>">
							<input required type="text" name="nomDestino" placeholder="Nombre destino" value="<?php echo$nomDestino?>">
							<input required type="text" name="direccionDestino" placeholder="Dirección" value="<?php echo$direccionDestino?>">
							<input required type="text" name="nomRespDestino" placeholder="Responsable destino" value="<?php echo$nomRespDestino?>">
							<input required type="number" name="telefonoDestino" placeholder="Telefono" value="<?php echo$telefonoDestino?>">
							<input required type="number" name="numcelularDestino" placeholder="Numero celular" value="<?php echo$numcelularDestino?>">
							<p style="color: #000;"><strong>Estado Destino</strong></p>
							<select required name="estadoDestino">
								<option name="estadoDestino"><?php echo $estadoDestino; ?></option>
								<option name="estadoDestino">Activo</option>
								<option name="estadoDestino">Inactivo</option>
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

	<h2>Gestion Usuarios</h2>
	<!-- Button trigger modal -->
	<button type="button" class="Agregar btn btn-primary" class="BotonAgregar" data-bs-toggle="modal" data-bs-target="#exampleModal">
		Agregar registro +
	</button>
	<table id="TablaPanelDeControl">	
		<thead>
			<!-- Titulos tabla -->
			<tr>
				<th>id Destino</th>
				<th>Nombre destino</th>
				<th>Direccion Destino</th>
				<th>Nom Responsable destino</th>
				<th>Telefono Destino</th>
				<th>Num Celular Destino</th>
				<th>Estado Destino</th>
				<th class="thSeleccionar">Opciones</th>
			</tr>
		</thead>

		<tbody>
			<!-- Datos tabla -->

			<?php

			foreach ($query as $columna) 
				{?>
					<tr>
						<td><?php echo$columna['idDestino'];?></td>
						<td><?php echo$columna['nomDestino'];?></td>
						<td><?php echo$columna['direccionDestino'];?></td>
						<td><?php echo$columna['nomRespDestino'];?></td>
						<td><?php echo$columna['telefonoDestino'];?></td>
						<td><?php echo$columna['numcelularDestino'];?></td>
						<td><?php echo$columna['estadoDestino'];?></td>
						<td class="tdSeleccionar">
							<form action="" method="POST">
							<input required type="hidden" name="idDestino" value="<?php echo$columna['idDestino'];?>">
							<input required type="hidden" name="nomDestino" placeholder="Nombre destino" value="<?php echo$columna['nomDestino']?>">
							<input required type="hidden" name="direccionDestino" placeholder="Dirección" value="<?php echo$columna['direccionDestino']?>">
							<input required type="hidden" name="nomRespDestino" placeholder="Responsable destino" value="<?php echo$columna['nomRespDestino']?>">
							<input required type="hidden" name="telefonoDestino" placeholder="Telefono" value="<?php echo$columna['telefonoDestino']?>">
							<input required type="hidden" name="numcelularDestino" placeholder="Numero celular" value="<?php echo$columna['numcelularDestino']?>">
							<input required type="hidden" name="estadoDestino" value="<?php echo$columna['estadoDestino']?>">
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