<?php
	if(!empty($_REQUEST)){
		include_once "../../Data/DataEmpleado.php";
		$dataEmpleado = new DataEmpleado();
		$empleado = json_decode($dataEmpleado->getEmpleadoById($_REQUEST["cedula"]));
	}else{
		echo "Disculpe, sucedió un error al cargar los datos del empleado.";
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Vista empleado</title>
	<link rel="stylesheet" href="">
</head>
<body>
	<table id="showEmpleados">
		<p>Empleado:     <?php echo $empleado[0]->nombre;?></p>
		<tbody>
			<tr>
				<td>
					<p>Cédula:<?php echo $empleado[0]->cedula;?></p>
				</td>
				<td>
					<p>Sucursal Actual:<?php echo $empleado[0]->nombreSucursal;?></p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Teléfono:<?php echo $empleado[0]->telefono;?></p>
				</td>
				<td>
					<p>Fecha de ingreso: <?php echo $empleado[0]->fechaIngreso;?></p>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="footShowInfoEmpleado">
		<a href="#" class="volverListEmpleados"><span class="icon-arrow-left"></span></a>
		<a href="<?php echo $empleado[0]->cedula;?>" class=""><span class="icon-pencil"></span>Editar información</a>
	</div>
</body>
</html>