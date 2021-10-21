<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Inicio</title>
	<link rel="stylesheet" type="text/css" href="../css/GestionUsuario.css">
	<link rel="icon" type="image/png" href="../../img/Rueda.png">
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600&family=Vollkorn&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/c9814e8fb5.js" crossorigin="anonymous"></script>
</head>

<!----------------------------------------- Codigo php -->
<?php

include '../../FuncConectar.php';



$conexion = ConectarBD();
$consulta = "SELECT * FROM usuario";
$query = mysqli_query($conexion, $consulta);

$Array = mysqli_fetch_array($query);
?>

<!-- ---------------------------------------------------------- -->
<body>

	<div id="contenedor">

		<div id="contenido">  <!------------------- 70% de la pagina --> 

			<div id="header">   <!--  30% del contenido -->

				<div id="Header_1">
					<a href="../../logueo.html">Cerrar Sesion</a>  <!-- 10% del header -->
				</div>

				<div id="Header_2">
					<h1 id="h1_titulo">Unión Transportadora Norte y Sur</h1>   <!-- 10% del header -->
				</div>

				<div id="Header_3">    <!-- 10% del header -->
					<div class="nav">
						<ul class="nav__ul">
							<li class="nav__li"><i class=" fas fa-user"></i><a href="GestionUsuarios.php">Gestion Usuarios</a></li>
							<li class="nav__li"><i class=" fas fa-car"></i><a href="GestionVehiculos.php">Gestion Vehiculos</a></li>
							<li class="nav__li"><i class=" fas fa-tv"></i><a href="GestionOperadores.php">Gestion Relecadores</a></li>
						</ul>
						<ul class="nav__responsive-ul">
							<div class="nav__responsive-button-container">
								<div class="nav__responsive-button fas fa-bars">
								</div></div>
								<div class="nav__li-container">
									<li class="nav__responsive-li"><i class=" fas fa-user"></i><a href="GestionUsuarios.php">Gestion Usuarios</a></li>
									<li class="nav__responsive-li"><i class=" fas fa-car"></i><a href="GestionVehiculos.php">Gestion Vehiculos</a></li>
									<li class="nav__responsive-li"><i class=" fas fa-tv"></i><a href="GestionOperadores.php">Gestion Relecadores</a></li>
								</div>
							</ul>
						</div>
					</div>

				</div>

				
				<div id="relleno">        <!-- 70% del contenido -->

					<center>

						<form method="POST" action="../php/Actualizar.php" id="formulario">
							<h1>Editar Usuario</h1>
							<i>Escriba el id del usuario a modificar</i>
							<input type="number" name="IdUsuario" placeholder="Id Usuario">
							<input class="inputs" type="email" name="correoUsuario" placeholder="Correo"><br>
							<input class="inputs" type="password" name="passwordUsuario" placeholder="Password"><br><br>
							<p>Foto del Usuario</p>
							<input id="inputs" type="file" name="fotoUsuario"><br><br>
							<select class="inputs" name="tipoUsuario" id="">
								<option>Tipo de Usuario</option>
								<option name="tipoUsuario">Relevador</option>
								<option name="tipoUsuario">Conductor</option>
								<option name="tipoUsuario">Calibrador</option>
							</select><br>
							<select class="inputs" name="estadoUsuario">
								<option>Estado Usuario</option>
								<option name="estadoUsuario">Activo</option>
								<option name="estadoUsuario">Inactivo</option>
							</select>
							<br>
							<input type="submit" class="button" value="Enviar">
						</form>

						

					</center>
				</div>

			</div>
			<div id="footer">
				<p>¡Siguenos!</p>

				<a href="https://www.facebook.com/profile.php?id=100005910945632" target="blank"><img class="ima" src="../../img/facebook.png" style="width: 3%"></a>
				<a href="https://twitter.com/Danielillopill3"  target="blank"><img class="ima" src="../../img/twitter.png" style="width: 3%"></a>
				<a href="https://www.youtube.com/channel/UCzHd5ilTV8jMYYD6k2RXrvw"  target="blank"><img class="ima" src="../../img/Youtube.png" style="width: 3%"></a>

				<p>&#169:Todos los derechos reservados</p>
			</div>
		</div>



	</body>
	</html>