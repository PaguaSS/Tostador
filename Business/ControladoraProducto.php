<?php
	include_once '../Domain/Producto.php';
	require "../Data/DataProducto.php";
    $dataProducto = new DataProducto();

	switch ($_REQUEST["metodo"]) {
		case 'insertarActualizar':
		   
			$dataProducto->insertarActualizarProducto(new Producto($_REQUEST["codigo"],$_REQUEST["nombre"],$_REQUEST["stock"], $_REQUEST["precio"],$_REQUEST["unidadMedida"],$_REQUEST["proveedor"],$_REQUEST["tamanio"], $_REQUEST["idSucursal"],$_REQUEST["idCategoria"], $_REQUEST["abreviatura"]), $_REQUEST["codigosIngredientes"]);
			break;
		case 'eliminar':
			echo $dataProducto->eliminarProducto($_REQUEST["codigoProducto"]);
			break;
		case 'mostrarProductos':
			echo $dataProducto->getProductosBySucursal($_REQUEST["idSucursal"]);
			break;
		case 'mostrarProductosCompuestos':
			echo $dataProducto->getProductosProductoCompuesto($_REQUEST["codigoProducto"]);
			break;
		case 'verificarAbreviatura':
			echo $dataProducto->existeAbreviatura($_REQUEST["abreviatura"], $_REQUEST["idSucursal"]);
			break;
			//obtiene los productos que no estan compuestos por otros productos
		case 'getProductosNoMixtos':
			echo $dataProducto->getProductosNoCompuestos($_REQUEST["idSucursal"]);
			break;
		case 'getNombresProducto':
			echo $dataProducto->getNombreProductoBySucursal($_REQUEST["idSucursal"],$_GET['term']);
			break;
		case "getPrecioProducto":
			echo $dataProducto->getPrecioProducto($_REQUEST["idSucursal"],$_GET['nombreProducto']);
			break;
		default:
			echo "Error, no se ha encontrado la accion";
			break;
	}
?>