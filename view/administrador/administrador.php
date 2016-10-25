<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Administrador</title>
      <script type="text/javascript" src="js/jquery-3.1.0.js"></script>
      <script type="text/javascript" src="js/funcionesAdministrador.js"></script>
			<link rel="stylesheet" href="css/estilo_principal.css">
</head>
<body>

	<?php include("view/administrador/barraNavegacionPrincipal.php"); ?>

	<div class="contenedorSucursales">
		<p>Todas las Sucursales</p>

		<span class="addSucursal">Add</span>

		<div class="barBusqueda">
			<input type="text" id="txtBusqSucur" placeholder="Escribe el nombre de una sucursal">
		</div>
		<br>
		<li><a href="mostrar" class="sucursales">Mostrar Sucursales</a></li>
		<li><a href="editar" class="sucursales">Editar Sucursales</a></li>

		<div id="contenedor"></div>

</body>
</html>
