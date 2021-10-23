<?php
session_start();

$TipoUsuario = $_POST['TipoUsuario'];
$_SESSION['TipoUsuario'] = $TipoUsuario;

if ($_SESSION['TipoUsuario'] == null) {
	echo "<script>
			alert('Debes seleccionar un tipo de usuario primero');
			window.location = 'SeleccionTipoUsuario.html';
		  </script>";
	die();
}
?> 
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Inicio de Sesión</title>
	<link rel="stylesheet" type="text/css" href="css/estilologueo.css">
	<link rel="icon" type="image/png" href="img/Rueda.png">
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600&family=Vollkorn&display=swap" rel="stylesheet">
</head>
<body>
	<h1>Inicio de sesión como <br> <?php echo $_SESSION['TipoUsuario'];?></h1>
	<form id="formulario" method="POST" action="php/Logueo.php">
		<input type="number" name="IdUsuario" placeholder="Escriba su idUsuario">
		<input type="email" name="CorreoUsuario" placeholder="Escriba su correo" class="input1">
		<input type="password" name="Contraseña" placeholder="Escriba su contraseña">
		<input id="boton1" type="submit" value="Ingresar">
		<a href="index.php" class="Volver">Volver</a>
	</form>

	<img src="img/autobus-escolar.png" class="BusEscolar">

	<footer>

		<p>¡Siguenos!</p>

		<a href="https://www.facebook.com/profile.php?id=100005910945632" target="blank"><img class="ima" src="img/facebook.png" style="width: 3%"></a>
		<a href="https://twitter.com/Danielillopill3"  target="blank"><img class="ima" src="img/twitter.png" style="width: 3%"></a>
		<a href="https://www.youtube.com/channel/UCzHd5ilTV8jMYYD6k2RXrvw"  target="blank"><img class="ima" src="img/Youtube.png" style="width: 3%"></a>

		<p>&#169:Todos los derechos reservados</p>	
		<div>Iconos diseñados por <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.es/" title="Flaticon">www.flaticon.es</a></div>
	</footer>



</body>
</html>