<?php
	
	require "../Data/DataEmpleado.php";
	$dataEmpleado = new DataEmpleado();

	switch ($_REQUEST['metodo']) {
		case 'addEmpleado':
			echo $dataEmpleado->insertarEmpleado($_REQUEST["arrayDatos"]);
			break;
		case 'mostrarEmpleadoNombre':
  			echo $dataEmpleado->getEmpleados();
			break;
		case "empleadosBySucursal":
			echo $dataEmpleado->getEmpleadosBySucursal();
			break;
		case "eliminarEmpleado":
			echo $dataEmpleado->eliminarEmpleado($_REQUEST["cedula"]);
			break;
	    case "getEmpleadoByCedula":
	    	echo $dataEmpleado->getEmpleadoById($_REQUEST["cedula"]);
	    	break;
		default:
			
			break;
	}

?>