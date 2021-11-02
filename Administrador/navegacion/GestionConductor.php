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
$mostrarTabla = "SELECT * FROM conductor";
$query = mysqli_query($conexion, $mostrarTabla);
$Array = mysqli_fetch_array($query);

//---------------- CODIGO PARA REGISTRAR LOS DATOS A LA TABLA USUARIO
$idConductor = (isset($_POST['idConductor']))?$_POST['idConductor']:"";
$tipoDocConductor = (isset($_POST['tipoDocConductor']))?$_POST['tipoDocConductor']:"";
$numDocConductor = (isset($_POST['numDocConductor']))?$_POST['numDocConductor']:"";
$nombreConductor = (isset($_POST['nombreConductor']))?$_POST['nombreConductor']:"";
$apellidoConductor = (isset($_POST['apellidoConductor']))?$_POST['apellidoConductor']:"";
$fechaNacimConductor = (isset($_POST['fechaNacimConductor']))?$_POST['fechaNacimConductor']:"";
$telefonoConductor = (isset($_POST['telefonoConductor']))?$_POST['telefonoConductor']:"";
$direccionConductor = (isset($_POST['direccionConductor']))?$_POST['direccionConductor']:"";
$numcelularConductor = (isset($_POST['numcelularConductor']))?$_POST['numcelularConductor']:"";
$rhConductor = (isset($_POST['rhConductor']))?$_POST['rhConductor']:"";
$nomContacEmergencia = (isset($_POST['nomContacEmergencia']))?$_POST['nomContacEmergencia']:"";
$idConductor = (isset($_POST['idConductor']))?$_POST['idConductor']:"";
$telContactEmergencia = (isset($_POST['telContactEmergencia']))?$_POST['telContactEmergencia']:"";
$estadoConductor = (isset($_POST['estadoConductor']))?$_POST['estadoConductor']:"";	

$accion = (isset($_POST['Accion']))?$_POST['Accion']:"";

$accionAgregar = "";
$acccionModificar = $accionEliminar = $accionCancelar = "disabled";
$mostrarModal = false;

// SWITCH PARA APLICAR CASOS A CLICK DE BOTONES
switch ($accion) {
	case 'Agregar':

	$insertDatos = "INSERT INTO `conductor`(idConductor, `tipoDocConductor`, `numDocConductor`, `nombreConductor`, `apellidoConductor`, `fechaNacimConductor`, `telefonoConductor`, `direccionConductor`, `numcelularConductor`, `rhConductor`, `nomContacEmergencia`, `telContactEmergencia`, `estadoConductor`) VALUES ('$_REQUEST[idConductor]', '$_REQUEST[tipoDocConductor]', '$_REQUEST[numDocConductor]', '$_REQUEST[nombreConductor]', '$_REQUEST[apellidoConductor]', '$_REQUEST[fechaNacimConductor]', '$_REQUEST[telefonoConductor]', '$_REQUEST[direccionConductor]', '$_REQUEST[numcelularConductor]', '$_REQUEST[rhConductor]', '$_REQUEST[nomContacEmergencia]', '$_REQUEST[telContactEmergencia]', '$_REQUEST[estadoConductor]')"; 
	
	mysqli_query($conexion, $insertDatos) or die(" El usuario ya existe " . mysqli_error($conexion));
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionConductor.php");
	break;

	case 'Modificar':
	echo "Presionaste Modificar";
	$updateDatos = "UPDATE `conductor` SET `tipoDocConductor`= '$_REQUEST[tipoDocConductor]',`numDocConductor` = '$_REQUEST[numDocConductor]' , `nombreConductor` = '$_REQUEST[nombreConductor]', `apellidoConductor` = '$_REQUEST[apellidoConductor]',`fechaNacimConductor` = '$_REQUEST[fechaNacimConductor]', `telefonoConductor` = '$_REQUEST[telefonoConductor]', `direccionConductor` = '$_REQUEST[direccionConductor]' ,`numcelularConductor` = '$_REQUEST[numcelularConductor]', `rhConductor` = '$_REQUEST[rhConductor]', `nomContacEmergencia` = '$_REQUEST[nomContacEmergencia]',`telContactEmergencia` = '$_REQUEST[telContactEmergencia]', `estadoConductor` = '$_REQUEST[estadoConductor]' where `idConductor` = '$_REQUEST[idConductor]' ";
	$updateDatos = mysqli_query($conexion, $updateDatos);
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionConductor.php");
	break;

	case 'Eliminar':
	echo "Presionaste Eliminar";
	$deleteDatos = "DELETE FROM conductor WHERE idConductor = $idConductor";
	$consulta = mysqli_query($conexion, $deleteDatos);
	$CerrarSesion = mysqli_close($conexion) or die("Probemas al cerrar sesion");
	header("Location: GestionConductor.php");
	break;

	case 'Cancelar':
	header("Location: GestionConductor.php");
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
	<title>Gestion Conductor</title>
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
						<h5 class="modal-title" id="exampleModalLabel">Conductor</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="form-row">
							<input required type="number" name="idConductor" placeholder="idConductor" id="idConductor" value="<?php echo $idConductor; ?>">
							<p style="color: #000;"><strong>Tipo doc conductor</strong></p>
							<select required class="inputs" name="tipoDocConductor">
								<option><?php
								echo $tipoDocConductor;?></option>
								<option name="tipoDocConductor">C.C</option>
								<option name="tipoDocConductor">T.I</option>
								<option name="tipoDocConductor">Cedula de Extranjeria</option>
							</select> 
							<input required class="inputs" type="number" name="numDocConductor" placeholder="Número de Documento" value="<?php echo $numDocConductor; ?>">
							<input required class="inputs" type="text" name="nombreConductor" placeholder="Nombre" value="<?php echo $nombreConductor ?>">
							<input required class="inputs" type="text" name="apellidoConductor" placeholder="Apellido" value="<?php echo $apellidoConductor ?>">
							<p style="color: #000;"><strong>Fecha de nacimiento</strong></p>
							<input required class="inputs" type="date" name="fechaNacimConductor" placeholder="Fecha de nacimiento" value="<?php echo $fechaNacimConductor ?>">
							<input required class="inputs" type="number" name="telefonoConductor" placeholder="Telefono" value="<?php echo $telefonoConductor ?>">
							<input required class="inputs" type="text" name="direccionConductor" placeholder="Dirección" value="<?php echo $direccionConductor ?>">
							<input required class="inputs" type="text" name="numcelularConductor" placeholder="Número Celular" value="<?php echo $numcelularConductor ?>">
							<input required class="inputs" type="text" name="rhConductor" placeholder="RH del Conductor" value="<?php echo $rhConductor ?>">
							<input required class="inputs" type="text" name="nomContacEmergencia" placeholder="Nombre de contacto de emergencia" value="<?php echo $nomContacEmergencia ?>">
							<input required class="inputs" type="number" name="telContactEmergencia" placeholder="Teléfono de emergencia" value="<?php echo $telContactEmergencia; ?>">
							<p style="color: #000;"><strong>Estado conductor</strong></p>
							<select required name="estadoConductor">
								<option name="estadoConductor"><?php echo $estadoConductor; ?></option>
								<option name="estadoConductor">Activo</option>
								<option name="estadoConductor">Inactivo</option>
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

	<h2>Gestion Conductores</h2>
	<!-- Button trigger modal -->
	<button type="button" class="Agregar btn btn-primary" class="BotonAgregar" data-bs-toggle="modal" data-bs-target="#exampleModal">
		Agregar registro +
	</button>

	<table>
		<!-- Titulos -->
		<thead>
			<th>id Conductor</th>
			<th>TipoDocConductor</th>
			<th>Num Doc Conductor</th>
			<th>Nombre Conductor</th>
			<th>Apellido Conductor</th>
			<th>Fecha Nacimiento</th>
			<th>Telefono Conductor</th>
			<th>Direccion Conductor</th>
			<th>Numero Celular</th>
			<th>RH Conductor</th>
			<th>Nom Contacto Emergencia</th>
			<th>Tel Contacto Emergencia</th>
			<th>Estado Conductor</th>
			<th class="thSeleccionar">Opciones</th>
		</thead>

		<tbody>
			<!-- Datos Tabla -->
			<?php

			foreach ($query as $columna) 
				{?>
					<tr>
						<td><?php echo $columna['idConductor'];?></td>
						<td><?php echo $columna['tipoDocConductor'];?></td>
						<td><?php echo $columna['numDocConductor'];?></td>
						<td><?php echo $columna['nombreConductor'];?></td>
						<td><?php echo $columna['apellidoConductor'];?></td>
						<td><?php echo $columna['fechaNacimConductor'];?></td>
						<td><?php echo $columna['telefonoConductor'];?></td>
						<td><?php echo $columna['direccionConductor'];?></td>
						<td><?php echo $columna['numcelularConductor'];?></td>
						<td><?php echo $columna['rhConductor'];?></td>
						<td><?php echo $columna['nomContacEmergencia'];?></td>
						<td><?php echo $columna['telContactEmergencia'];?></td>
						<td><?php echo $columna['estadoConductor'];?></td>
						<td class="tdSeleccionar">
							<form action="" method="POST">
								<input required type="hidden" name="idConductor" placeholder="idConductor" id="idConductor" value="<?php echo $columna['idConductor']; ?>">
								<input type="hidden" class="inputs" name="tipoDocConductor" value="<?php echo $columna['tipoDocConductor']; ?>">
								<input class="inputs" type="hidden" name="numDocConductor" placeholder="Número de Documento" value="<?php echo $columna['numDocConductor']; ?>">
								<input class="inputs" type="hidden" name="nombreConductor" placeholder="Nombre" value="<?php echo $columna['nombreConductor']; ?>">
								<input class="inputs" type="hidden" name="apellidoConductor" placeholder="Apellido" value="<?php echo $columna['apellidoConductor']; ?>">
								<input class="inputs" type="hidden" name="fechaNacimConductor" placeholder="Fecha de nacimiento" value="<?php echo $columna['fechaNacimConductor']; ?>">
								<input class="inputs" type="hidden" name="telefonoConductor" placeholder="Telefono" value="<?php echo $columna['telefonoConductor']; ?>">
								<input class="inputs" type="hidden" name="direccionConductor" placeholder="Dirección" value="<?php echo $columna['direccionConductor']; ?>">
								<input class="inputs" type="hidden" name="numcelularConductor" placeholder="Número Celular" value="<?php echo $columna['numcelularConductor']; ?>">
								<input class="inputs" type="hidden" name="rhConductor" placeholder="RH del Conductor" value="<?php echo $columna['rhConductor']; ?>">
								<input class="inputs" type="hidden" name="nomContacEmergencia" placeholder="Nombre de contacto de emergencia" value="<?php echo $columna['nomContacEmergencia']; ?>">
								<input class="inputs" type="hidden" name="telContactEmergencia" placeholder="Teléfono de emergencia" value="<?php echo $columna['telContactEmergencia']; ?>">
								<input type="hidden" name="estadoConductor" class="inputs" value="<?php echo $columna['estadoConductor']; ?>">
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