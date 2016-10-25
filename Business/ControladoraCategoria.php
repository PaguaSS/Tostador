<?php
	include_once '../Domain/Categoria.php';
	require "../Data/DataCategoria.php";
	$dataCategoria = new DataCategoria();

	switch ($_REQUEST["metodo"]) {
		case 'insertar':
			$dataCategoria->agregarActualizarCategoria(new Categoria(0,$_REQUEST["nombre"]));
			break;
		case 'actualizar':
			$dataCategoria->agregarActualizarCategoria(new Categoria($_REQUEST["id"],$_REQUEST["nombre"]));
			break;
		case 'eliminar':
			echo $dataCategoria->eliminarCategoria($_REQUEST["id"]);
			break;
		case 'mostrar':
			//-----------------------------------------------------
			// Muestra una categoria en especifico si se le pasa un parametro sino de
			//devuelve todas las categorias
			//-----------------------------------------------------
			echo $dataCategoria->getCategoria($_REQUEST["id"]);
			break;
		default:
			echo "Error al ejecutar la accion";
			break;
	}
?>