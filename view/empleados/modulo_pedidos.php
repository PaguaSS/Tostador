<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Pedidos</title>
	<link rel="stylesheet" type="text/css" href="../../css/jquery.datetimepicker.css">
	<script type="text/javascript" src="../../js/funciones_generales.js"></script>
	<script type="text/javascript" src="../../js/jquery.datetimepicker.full.js"></script>
</head>
<body>
	<div class="menuLateral">
		<p>Sección de:</p>
		<ul>
			<li><a href="#" id="opPedidoEspera">Pedidos en espera</a></li>
			<li><a href="#" id="opPedidoReal">Pedidos realizados</a></li>
		</ul>
	</div>
	<div class="contenedorSecundario">
	    
		<div class="contenidoPedidos">
			<p>Busqueda por filtro de fecha</p>
			<div class="barBusqueda">
				<label>De:</label>
				<input type="text" id="txtFecha1" class="fecha" placeholder="Seleccionar fecha">
				<label>a:</label>
				<input type="text" id="txtFecha2" class="fecha" placeholder="Seleccionar fecha">
				<a href="#" id="" class="btn-submit"><span class="icon-search"></span></a>
			</div>
			<div class="tabla">
			<table>
				<thead>
						<tr>
							<th>Código</th>
							<th>Fecha-hora</th>
						</tr>
					</thead>
			</table>
			<div class="detalleTablaPedido">
				<table>
					<tbody>
						<tr>
							<td>0987086</td>
							<td>07/08/2016 23434</td>
							<td>rastrear</td>
							<td><input type="checkbox" name=""></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>	
		</div>
	</div>
	<div class="contenedorModal" id="frmPedidoSucur" style="display:none;">
		<div class="contenedorPedidoSucr">
			<form class="frmPedido" action="" method="get" accept-charset="utf-8">
				<table>
					<caption>Pedido #:000987</caption>
					<thead>
						<tr>
							<th>Sucursal: Cariari</th>
							<th>Fecha-hora: 12/09/2016 23:40 p.m.</th>
							
						</tr>
						<tr>
							<th>Empleado: Steven Mendez</th> 
							
						</tr>
						<tr>
							<th>Código</th>
							<th>Nombre</th>
							<th>Cantidad</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>00099</td>
							<td>Mani salado</td>
							<td>5300k</td>
						</tr>
			
					</tbody>
				</table>
			</form>	
		
			<div class="frmInsertDetalle">
				<p>Agregar producto al pedido</p>
				<input type="text" id="txtCodigo" placeholder="Código producto" class="inputShadow">
				<input type="text" id="txtCantidad" placeholder="Cantidad" class="inputShadow">
				<a href="" id="hacerPedidoSucursal" class="btn-flat">Agregar</a>

				<div class="opPedido">
					<a href="#" id="cancelarPedido" class="btn-submit">Realizar</a>
					<a href="" id="hacerPedidoSucursal" class="btn-submit">Cancelar</a>
				</div>
			</div>
		</div>
	</div>
	<a class='flotante' href='frmPedidoSucr'>Add</a>
	 <script>
            $(function() {
                $('.fecha').datetimepicker({
                    timepicker:false,
 					format:'d/m/Y'
                });
            });
        </script>
</body>
</html>