$(document).ready(function(){
	//se controla el formulario cuando se ingresa una linea a la venta
	$( "#fRealizarVenta" ).submit(function(e) {
	  e.preventDefault();
	  var form = document.fRealizarVenta;
		if(form.abrev.value.trim().length != 0 && form.cantidad.value.trim().length != 0){
	  		procesarLineaProducto(form.abrev.value.trim());
	  	}else{
	  		alertify.error('Para procesar la venta no debe dejar espacios en blanco.');
		}
	});

	function procesarLineaProducto(nomProducto){
		var producto = new Object();

		$.ajax({
            url:"../../Business/ControladoraProducto.php?metodo=getPrecioProducto&idSucursal="+
            $("#sucursal").val()+"&nombreProducto="+nomProducto,
            type:'GET',
            data:{},
            
            success: function(responseText){
                var data = JSON.parse(responseText);        
                producto["codigo"] = data[0].codigo;
			    producto["nombre"] = data[0].nombre;
			    producto["stock"] = data[0].stock;
			    producto["unidadMedida"] = data[0].unidadMedida;
			    producto["precio"] = data[0].precio;
			    producto["abrev"] = data[0].abrev;
			    //Despues de que se obtiene la info del producto se procesa los datos
			    procesarLinea(producto);
            }
        });
	}

	function procesarLinea(producto){
		//ver si hay inventario
		var form = document.fRealizarVenta;
		var cantidad = form.cantidad.value.trim().replace(",",".");
		
		if(producto.unidadMedida == "k"){
			
			//digitado en gramos
			if(cantidad > 10){
				var stock = producto.stock * 1000;
				if(stock >= cantidad){
					agregarLineaVenta(producto,cantidad,"g");
				}else{
					alertify.alert('Tostador',
								'No hay suficiente inventario para abastecer la compra del producto: '+producto.nombre,
								function(){ 	
								}
							).set({transition:'zoom'}).show();
				}
			}else{
				//digitado en kilos
				if(producto.stock >= cantidad){
					agregarLineaVenta(producto,cantidad,"k");
				}else{
					alertify.alert('Tostador',
								'No hay suficiente inventario para abastecer la compra del producto: '+producto.nombre,
								function(){ 	
								}
							).set({transition:'zoom'}).show();
				}
			}
			
		}else{
			if(producto.unidadMedida == "u"){
				if(producto.stock >= cantidad){
					agregarLineaVenta(producto,cantidad,"u");
				}else{
					alertify.alert('Tostador',
								'No hay suficiente inventario para abastecer la compra del producto: '+producto.nombre,
								function(){ 	
								}
							).set({transition:'zoom'}).show();
				}
			}
		}
	}
	//tbListaDetalle
	function agregarLineaVenta(producto,cantidad,formatoIngresoCantidad){
		var trs = $("#tbListaDetalle tr").length;
	    var idTr = trs+1;
	    var totalLinea = 0;
	        
	    if(producto.unidadMedida == "k"){
	        if(formatoIngresoCantidad == "k"){
	        	totalLinea = parseFloat(((cantidad * 1000) * producto.precio)/1000); 
	        }else{
	        	if(formatoIngresoCantidad == "g"){
	        		totalLinea = parseFloat((cantidad * producto.precio)/1000); 
	        	}
	        }
	    }else{
	    	if(producto.unidadMedida == "u"){
	    		totalLinea = cantidad * producto.precio;
	    	}
	    }
		    
		var fila = "<tr id='"+idTr+"'>"
				  +"<td>"+"<input type='hidden' value='"+producto.codigo+"'>"+producto.nombre+"</td>"
				  +"<td>"+producto.precio+"</td>"
				  +"<td>"+cantidad+formatoIngresoCantidad+"</td>"
				  +"<td><img class='icon-colon' src='../../imagenes/colones.png' width='75'>"+totalLinea+"</td>"
				  +"<td><a href='#"+idTr+"' class='eliminarLinea'><span class='icon-bin2'></span></a></td>";
	    $("#tbListaDetalle").append(fila);
	    //despues de que se crea cada linea, se procede a dar el evento de eliminar linea del detalle
	    darEventoEliminarLinea();
	    limpiarFormAgregarDetalle();
	    actualizarSubTotal();
	}
	

	function darEventoEliminarLinea(){
		$(".eliminarLinea").off('click');
		$(".eliminarLinea").on("click",function(e){
			e.preventDefault();
			var idFila = this.getAttribute("href");
			restarSubtotal(idFila);
			$(idFila).remove();
		});
	}

	function restarSubtotal(id){
		$(id).children("td").each(function (index2) 
            {
                switch (index2) 
                {
                    case 3: 
                    	var nuevoSubtotal = parseFloat($("#subtotal").text())-parseFloat($(this).text());
                    	$("#subtotal").text(nuevoSubtotal);
                    	realizarIva();
                    	actualizarTotal();
                        break;
                }
            });
	}

	function limpiarFormAgregarDetalle(){
		$("#abrevProducto").focus();
		var form = document.fRealizarVenta;
		form.cantidad.value = "";
		form.abrev.value = "";
	}

	function actualizarSubTotal(){
		var subtotal = 0;
		$("#tbListaDetalle tbody tr").each(function (index) 
        {
            $(this).children("td").each(function (index2) 
            {
                switch (index2) 
                {
                    case 3:
                    	subtotal = subtotal+ parseFloat($(this).text());
                        break;
                }
            });
            
        });
	$("#subtotal").text(subtotal);
	$("#iva").text(parseFloat(subtotal*0.13));
	actualizarTotal();
	}

	function realizarIva(){
		$("#iva").text(parseFloat(parseFloat($("#subtotal").text())*0.13));
	}

	function actualizarTotal(){
		$("#total").text(parseFloat($("#subtotal").text())+parseFloat($("#iva").text()));
	}

	/*Acción de terminar una venta*/
	$("#bTerminarVenta").on("click",function(e){
		e.preventDefault();
		var trs = $("#tbListaDetalle tr").length;
		if(trs > 0){
		alertify.prompt( 
			'Tostador', 
			'Paga con', 
			''
            , function(evt, value) { 
            	
            	if(parseFloat(value.trim())>=parseFloat($("#total").text())){
            		terminarVenta();
	            	var cambio = parseFloat(value)-parseFloat($("#total").text());
					alertify.alert('Tostador',
								'<table class="tbCambio"><tr><td>Paga con:</td><td><img class="icon-colon" src="../../imagenes/colones.png">'+value.trim()+'</td></tr>'
								+'<tr><td>Subtotal: </td><td><img class="icon-colon" src="../../imagenes/colones.png">'+$("#subtotal").text()
								+'</td></tr><tr><td>Imp.Venta: </td><td><img class="icon-colon" src="../../imagenes/colones.png">'+$("#iva").text()
								+'</td></tr><tr><td>Total: </td><td><img class="icon-colon" src="../../imagenes/colones.png">'+$("#total").text()
								+'</td></tr><tr><td>Su cambio= </td><td><img class="icon-colon" src="../../imagenes/colones.png">'+cambio
								+'</td></tr></table>',
								function(){ 
									limpiarFactura();
								}
							).set({transition:'zoom'}).show();
				
				}else{
					alertify.alert('Tostador',
								'El valor ingresado es menor que el total de la compra, ' 
							   +'asegurese de ingresar una cantidad de pago valida.',
								function(){ 	
								}
							).set({transition:'zoom'}).show();
				}
            }
            , function() {
            	alertify.success('Venta Cancelada');
            	limpiarFactura();
         	}
         ).set({transition:'zoom',message: 'Paga con:'}).show();
		}else{
			alertify.alert('Tostador',
						   "Para finalizar una venta, debe de existir al"+
						   " menos una linea en la factura de compra.",
						   function(){ 	
						   }
						).set({transition:'zoom'}).show();
		}
	});

	function terminarVenta(){
		var venta = new Object();
		var listaLineaVenta = [];

		//Datos para el encabezado y pie de venta
		venta["idSucursal"] = $("#sucursal").val();
		venta["fechaHora"] = getDate()+" "+getHour();
		venta["idEmpleado"] = $("#cedulaEmpleado").val();
		venta["impuestoVenta"] = $("#iva").text();  
		venta["subtotal"] = $("#subtotal").text();
		venta["total"] = $("#total").text();

		$("#tbListaDetalle tbody tr").each(function (index) 
        {
        	var idFila = $(this).attr("id");
        	var codProducto = $("#"+idFila+" input:hidden").val();
            var precio = 0,cantidad = 0 ,totalLinea = 0;
            
            $(this).children("td").each(function (index2) 
            {
                switch (index2) 
                {
                    case 1:
                    	precio = $(this).text();
                        break;
                    case 2:
                    	var cadena = $(this).text();
                    	cantidad = cadena.substr(0, cadena.length-1);
                        break;
                    case 3:
                    	totalLinea = $(this).text();
                        break;
                }
            });
            
            var lineaVenta = {codigoProducto:codProducto, precio:precio, cantidad:cantidad, totalLinea:totalLinea}; 
            listaLineaVenta.push(lineaVenta);
        });
	
		agregarVenta(JSON.stringify(venta),JSON.stringify(listaLineaVenta));
	}

	function agregarVenta(venta,listaDetalleVenta){
		$.ajax({
            url:"../../Business/ControladoraVenta.php?metodo=agregarVenta",
            type:'GET',
            data:{encabezado:venta, detalleVenta:listaDetalleVenta},
            success: function(responseText){
            	limpiarFactura();
            }
        });
	}

	function getDate(){
        var hoy = new Date();
        var dd = hoy.getDate();
        var mm = hoy.getMonth()+1;
        var yyyy = hoy.getFullYear();

        if(dd<10) {
            dd='0'+dd
        } 
        if(mm<10) {
            mm='0'+mm
        } 
        var fecha = yyyy+"-"+mm+'-'+dd;
        return fecha;
    }
    
    function getHour(){
        var fecha = new Date();
        var hora = fecha.getHours();
        var minuto = fecha.getMinutes();
        var segundo = fecha.getSeconds();
        if (hora < 10) {
            hora = "0" + hora;
        }
        if (minuto < 10) {
            minuto = "0" + minuto;
        }
        if (segundo < 10) {
            segundo = "0" + segundo;
        }
        var horaActual = hora + ":" + minuto + ":" + segundo;
        return horaActual;
    }

    function limpiarFactura(){
    	$("#iva").text("0.0"); 
    	$("#subtotal").text("0.0"); 
    	$("#total").text("0.0");

    	limpiarTabla("tbListaDetalle");
    }

    function limpiarTabla(id){
    	$("#"+id+" tbody tr").each(function (index){
            $(this).remove();
        }); 
    }
});