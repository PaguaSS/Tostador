<input type="hidden" id="sucursal" value="<?php echo $_SESSION['idSucursal'];?>">
<div class="menuLateral">	
	<p>Mostrar por:</p>
	<ul>
		<li><a href="#" id="">Ventas del día</a></li>
		<li><a href="#" id="">Busqueda de ventas </a></li>
	</ul>
</div>
<div class="contenedorSecundario">
    <div class="venta">
    	<div class="encabezadoVenta">
    		<label id="enbzNomSucursal"></label><br>
    		<label id="enbzNomEmpleado"></label><br>
    		<label>Fecha: <?php echo date("d-m-Y");?></label><br>
    	</div>
    	<ul>
    		<li>
		    	<table class="tbEstandar tbUnida" style="width:97%;">
		    			<tbody>
		    				<tr class="tr">
		    					<td>Descripción</td>
		    					<td>Precio</td>
		    					<td>Cantidad</td>
		    					<td>Total de linea</td>
		    					<td></td>
		    				</tr>
		    			</tbody>
		    	</table>
		    		<div class="listaCompra" style="width:97%;">
		    		<table class="tbUnida" id="tbListaDetalle">
		    			<tbody>
		    				
		    			</tbody>
		    		</table>
		    	</div>
		    	<table class="tbUnida" style="width:97%;">
		    		<tbody style="min-height:280px;">
		    			<tr>
		    				<td></td>
		    				<td></td>
		    				<td style="text-align:initial;">Subtotal:  <img src='../../imagenes/colones.png' style="width:6%;"><label id="subtotal">0.0</label></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    			<tr>
		    				<td></td>
		    				<td></td>
		    				<td style="text-align:initial;width:30%;">IVA:  <img src='../../imagenes/colones.png' style="width:6%;"><label id="iva">0.0</label></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    			<tr>
		    				<td></td>
		    				<td></td>
		    				<td style="width:30%;text-align:initial;">Total:  <img src='../../imagenes/colones.png' style="width:6%;"><label id="total">0.0</label></td>
		    				<td></td>
		    				<td></td>
		    			</tr>
		    		</tbody>
		    	</table>
	    	</li>
	    	<li>
		    	<div class="fIngresoDetalle">
		    		<form name="fRealizarVenta" id="fRealizarVenta" method="POST">
		    		
		    			<p>Ingreso del detalle</p>
		    			<input type="text" class="inputShadow" name="abrev" id="abrevProducto" placeholder="Abreviatura">
						<input type="text" class="inputShadow" name="cantidad" placeholder="Cantidad">
						
						<input type="submit" class="btn-submit" value="Agregar"/>
						<a href="#" class="btn-submit" id="bTerminarVenta">Terminar venta</a>
		    		
		    		</form>
		    	</div>
	    	</li>
    	</ul>
    </div>     
</div>
<script>
	$(document).ready(function(){
	$("#enbzNomSucursal").text("Sucursal "+$("#nomSucursal").val());
	$("#enbzNomEmpleado").text("Empleado "+$("#nomEmpleado").val());
	$('#abrevProducto').autocomplete({
		source:'../../Business/ControladoraProducto.php?metodo=getNombresProducto&idSucursal='+$("#sucursal").val(), 
		minLength: 1
	    });
	});
</script>
<script type="text/javascript" src="../../js/gestion_ventas.js"></script>

