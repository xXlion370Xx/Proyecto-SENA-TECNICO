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
$mostrarTabla = "SELECT * FROM recorrido";
$query = mysqli_query($conexion, $mostrarTabla);
$Array = mysqli_fetch_array($query);

//---------------- CODIGO PARA REGISTRAR LOS DATOS A LA TABLA Recorrido
$idRecorrido = (isset($_POST['idRecorrido']))?$_POST['idRecorrido']:"";
$nomRecorrido = (isset($_POST['nomRecorrido']))?$_POST['nomRecorrido']:"";
$estadoRecorrido = (isset($_POST['estadoRecorrido']))?$_POST['estadoRecorrido']:"";

$accion = (isset($_POST['Accion']))?$_POST['Accion']:"";

$accionAgregar = "";
$acccionModificar = $accionEliminar = $accionCancelar = "disabled";
$mostrarModal = false;

// SWITCH PARA APLICAR CASOS A CLICK DE BOTONES
switch ($accion) {
	
	case 'Agregar':
	$insertDatos = "INSERT INTO recorrido(idRecorrido, nomRecorrido, estadoRecorrido) values('$_REQUEST[idRecorrido]', '$_REQUEST[nomRecorrido]', '$_REQUEST[estadoRecorrido]')";
	mysqli_query($conexion, $insertDatos) or die(" El Recorrido ya existe " . mysqli_error($conexion));
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionRecorrido.php");
	break;

	case 'Modificar':
	$updateDatos = "UPDATE recorrido SET nomRecorrido = '$_REQUEST[nomRecorrido]', estadoRecorrido = '$_REQUEST[estadoRecorrido]' where idRecorrido = '$_REQUEST[idRecorrido]' ";
	$updateDatos = mysqli_query($conexion, $updateDatos);
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionRecorrido.php");
	break;

	case 'Eliminar':
	$deleteDatos = "DELETE FROM recorrido WHERE idRecorrido = $idRecorrido";
	$consulta = mysqli_query($conexion, $deleteDatos);
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionRecorrido.php");
	break;

	case 'Cancelar':
	header("Location: GestionRecorrido.php");
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
	<title>Gestion Recorrido</title>
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

	<form method="POST" action="" enctype="multipart/form-data" id="formulario">
		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Recorrido</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="form-row">
							<input required type="number" name="idRecorrido" placeholder="idRecorrido" id="idRecorrido" value="<?php echo $idRecorrido; ?>">
							<input required type="text" name="nomRecorrido" id="nomRecorrido" placeholder="Nombre" value="<?php echo $nomRecorrido; ?>">
							<p style="color: #000;"><strong>Estado Recorrido</strong></p>
							<select  name="estadoRecorrido" id="estadoRecorrido" required>
								<option name="estadoRecorrido"> <?php echo $estadoRecorrido; ?></option>
								<option name="estadoRecorrido" id="estadoRecorrido">Activo</option>
								<option name="estadoRecorrido" id="estadoRecorrido">Inactivo</option>
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

	<h2>Gestion Recorridos</h2>
	<!-- Button trigger modal -->
	<button type="button" class="Agregar btn btn-primary" class="BotonAgregar" data-bs-toggle="modal" data-bs-target="#exampleModal">
		Agregar registro +
	</button>
	<table id="TablaPanelDeControl">	
		<thead>
			<!-- Titulos tabla -->
			<tr>
				<th>id Recorrido</th>
				<th>Nombre</th>
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
						<td><?php echo $columna['idRecorrido'];?></td>
						<td><?php echo $columna['nomRecorrido'];?></td>
						<td><?php echo $columna['estadoRecorrido'];?></td>
						<td  class="tdSeleccionar">
							<form action="" method="POST">
								<input type="hidden" name="idRecorrido" value="<?php echo $columna['idRecorrido'];?>">
								<input type="hidden" name="nomRecorrido" value="<?php echo $columna['nomRecorrido'];?>">
								<input type="hidden" name="estadoRecorrido" value="<?php echo $columna['estadoRecorrido'];?>">
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