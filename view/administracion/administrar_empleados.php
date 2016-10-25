<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	<div class="contenedorSucursales" id="contenedorOpAdmin">
		<p>Empleados</p>
		<a class="add tooltip" id="addNewEmpleado" data-tooltip="Agregar nuevo empleado"><span class="icon-plus2"></span></a>
		<div class="barBusqueda">
			<input type="text" id="txtBusqSucur" placeholder="Escribe el nombe de un empleado" class="inputShadow">
		</div>
		<div class="contenedorLista">
			<table id="tablaEmpleados" class="listaCnNombres">
				<tbody>
					
				</tbody>
			</table>

		</div>
	<div class="contenedorModal" id="frmAddEmpleado" name="frmAddEmpleado" style="display:none;">
		
		<form action="" name="frmAddEmpleado" method="get" accept-charset="utf-8" class="frmAdd">
			<p>Formulario para empleado</p>
			<input type="text" name="cedula" id="cedula" placeholder="Cédula, ejemplo:102220333">
			<input type="text" name="nombreEmpl" placeholder="Nombre completo">
			<input type="text" name="telf" id="telf" placeholder="Teléfono, ejemplo:8888-2222" >
			<span class="etiqueta">Agregar sucursal de trabajo</span>
			<select name="selectSucursal" id="selectSucursal">
				<option value="0">Ninguna</option>
			</select>
			<div class="contenedorSwitch">
			    <span>¿Habilitado?</span>
				<div class="switch">
				  <input id="cmn-toggle-7" name="emplHabl" class="cmn-toggle cmn-toggle-yes-no" type="checkbox">
				  <label for="cmn-toggle-7" data-on="Si" data-off="No"></label>
				</div>
			</div>
			<div class="footOpsFrm">
				<a href="frmAddEmpleado" class="btn-submit bRegEmpleado">Registrar</a>
				<a href="frmAddEmpleado" class="btn-submit btn-cancel">Cancelar</a>
			</div>
		</form>
	</div>
	<script type="text/javascript" src="../../js/cargar_empleados.js"></script>
	<script type="text/javascript" src="../../js/funciones_generales.js"></script>
	<script type="text/javascript" src="../../js/jquery.tablefilter.js"></script>
	<script type="text/javascript" src="../../js/jquery.maskedinput.js" ></script>
	<script>
		$(function() {
			theTable = $("#tablaListaSucursal");
			$("#txtBusqSucur").keyup(function() {
				$.uiTableFilter(theTable, this.value);
			});

			$("#telf")
	        .mask("9999-9999")
	        .focusout(function (event) {  
	            var target, phone, element;  
	            target = (event.currentTarget) ? event.currentTarget : event.srcElement;  
	            phone = target.value.replace(/\D/g, '');
	            element = $(target);  
	            element.unmask();  
	            if(phone.length > 10) {  
	                element.mask("9999-9999");  
	            } else {  
	                element.mask("9999-9999");  
	            }  
	        });

	        $("#cedula")
	        .mask("909990999")
	        .focusout(function (event) {  
	            var target, phone, element;  
	            target = (event.currentTarget) ? event.currentTarget : event.srcElement;  
	            phone = target.value.replace(/\D/g, '');
	            element = $(target);  
	            element.unmask();  
	            if(phone.length > 10) {  
	                element.mask("909990999");  
	            } else {  
	                element.mask("909990999");  
	            }  
	        });
		});
	</script>
</body>
</html>
