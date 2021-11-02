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
$mostrarTabla = "SELECT * FROM marca";
$query = mysqli_query($conexion, $mostrarTabla);
$Array = mysqli_fetch_array($query);

//---------------- CODIGO PARA REGISTRAR LOS DATOS A LA TABLA Marca
$idMarca = (isset($_POST['idMarca']))?$_POST['idMarca']:"";
$nomMarca = (isset($_POST['nomMarca']))?$_POST['nomMarca']:"";
$estadoMarca = (isset($_POST['estadoMarca']))?$_POST['estadoMarca']:"";

$accion = (isset($_POST['Accion']))?$_POST['Accion']:"";

$accionAgregar = "";
$acccionModificar = $accionEliminar = $accionCancelar = "disabled";
$mostrarModal = false;

// SWITCH PARA APLICAR CASOS A CLICK DE BOTONES
switch ($accion) {
	
	case 'Agregar':
	$insertDatos = "INSERT INTO marca(idMarca, nomMarca, estadoMarca) values('$_REQUEST[idMarca]', '$_REQUEST[nomMarca]', '$_REQUEST[estadoMarca]')";
	mysqli_query($conexion, $insertDatos) or die(" El Marca ya existe " . mysqli_error($conexion));
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionMarca.php");
	break;

	case 'Modificar':
	$updateDatos = "UPDATE marca SET nomMarca = '$_REQUEST[nomMarca]', estadoMarca = '$_REQUEST[estadoMarca]' where idMarca = '$_REQUEST[idMarca]' ";
	$updateDatos = mysqli_query($conexion, $updateDatos);
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionMarca.php");
	break;

	case 'Eliminar':
	$deleteDatos = "DELETE FROM marca WHERE idMarca = $idMarca";
	$consulta = mysqli_query($conexion, $deleteDatos);
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionMarca.php");
	break;

	case 'Cancelar':
	header("Location: GestionMarca.php");
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
	<title>Gestion Marca</title>
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
						<h5 class="modal-title" id="exampleModalLabel">Marca</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="form-row">
							<input required type="number" name="idMarca" placeholder="idMarca" id="idMarca" value="<?php echo $idMarca; ?>">
							<input required type="text" name="nomMarca" id="nomMarca" placeholder="Nombre" value="<?php echo $nomMarca; ?>">
							<p style="color: #000;"><strong>Estado Marca</strong></p>
							<select  name="estadoMarca" id="estadoMarca" required>
								<option name="estadoMarca"> <?php echo $estadoMarca; ?></option>
								<option name="estadoMarca" id="estadoMarca">Activo</option>
								<option name="estadoMarca" id="estadoMarca">Inactivo</option>
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

	<h2>Gestion Marcas</h2>
	<!-- Button trigger modal -->
	<button type="button" class="Agregar btn btn-primary" class="BotonAgregar" data-bs-toggle="modal" data-bs-target="#exampleModal">
		Agregar registro +
	</button>
	<table id="TablaPanelDeControl">	
		<thead>
			<!-- Titulos tabla -->
			<tr>
				<th>id Marca</th>
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
						<td><?php echo $columna['idMarca'];?></td>
						<td><?php echo $columna['nomMarca'];?></td>
						<td><?php echo $columna['estadoMarca'];?></td>
						<td  class="tdSeleccionar">
							<form action="" method="POST">
								<input type="hidden" name="idMarca" value="<?php echo $columna['idMarca'];?>">
								<input type="hidden" name="nomMarca" value="<?php echo $columna['nomMarca'];?>">
								<input type="hidden" name="estadoMarca" value="<?php echo $columna['estadoMarca'];?>">
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