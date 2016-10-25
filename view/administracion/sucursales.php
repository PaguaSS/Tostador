<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <script type="text/javascript" src="js/jquery-3.1.0.js"></script>
	   <script type="text/javascript" src="js/funcionesAdministrador.js"></script>
  </head>
  <body>

  		<div id="contenedorLista" class="contenedorLista">
  			<table id="tablaSoloLista">
  				<tbody>
  					<form name="formulario1" action="index.html" method="post">

  					</form>
  					<?php
  						echo "<th>Nombre</th>";
  						echo "<th>Dirección</th>";
  						echo "<th>Teléfono</th>";
  						echo "<th></th>";
  						echo "<th></th>";
  						echo "<th></th>";

  						while ($reg=mysqli_fetch_array($registro))
  	          {
  	            echo "<tr class=\"itemListaSucursal\">";
  	            echo "<td><a href=\"012\">".$reg['nombre']."</a></td>";
  	            echo "<td><a href=\"012\">".$reg['direccion']."</a></td>";
  	            echo "<td><a href=\"012\">".$reg['telefono']."</a></td>";
  	            echo "<td><a href=\"?clase=sucursalController&accion=formEditarSucursal&codigo=".$reg['id']."\" class=\"btnEditSucr\">Editar</a></td>";
  	            echo "<td><a href=\"012\" class=\"btnEditSucr\">Eliminra</a></td>";
  	            echo "</tr>";
  	          }
  	        ?>

  				</tbody>
  			</table>
  </body>
</html>
