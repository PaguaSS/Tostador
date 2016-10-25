$(document).ready(function(){
    alertify.set('notifier','position', 'top-left');
	$("#bSubmitFrmLoginAdm").on("click",function(e){
        e.preventDefault();
        var formulario = document.frmLoginAdm;
        if(formulario.username.value.trim().length != 0 && formulario.password.value.trim().length != 0){
           formulario.submit(); 
        }else{
            $(".mensajes").text("Los campos no pueden estar vacios");
        }

    });

    /*funciones FAB*/
    $(".fabInventario").on("click",function(e){
         e.preventDefault();
        alert("");
        $(".menu-fab").show();
    });
    /*End funciones FAB*/
    $('.opBarNav').on('click',function(e){
		e.preventDefault();
		var opcion = this.getAttribute("href");

		if(opcion == "pedido"){
			cargar_pagina("#contenedorGlobal", "../empleados/modulo_pedidos.php");
		}else{
			if(opcion == "caja"){
				cargar_pagina("#contenedorGlobal", "../Ventas/GestionVentas.php");
                
				$(".xdsoft_datetimepicker").remove();
			}else{
                if(opcion == "invent"){
                   cargar_pagina("#contenedorGlobal", "../Producto/GestionInventario.php");
                    $(".xdsoft_datetimepicker").remove();
                }
            }
		}

	   });
    

    $(".btn-cancel").on('click',function(e){
        e.preventDefault();
        var opcion = this.getAttribute("href");
        
        if(opcion == "frmAddEmpleado"){
            mostr_ocultr("frmAddEmpleado");
        }

    });

	function cargar_pagina(lugarACargar,nombrePagina){
		$(lugarACargar).load(nombrePagina);
		$(lugarACargar).fadeIn(1000);
	}

	$('.flotante').on('click',function(e){
		 e.preventDefault();
		
		var opcion = this.getAttribute("href");
		if(opcion = "frmPedidoSucr"){
			mostr_ocultr("frmPedidoSucur");
		}
	});

	function mostr_ocultr(id){
		
        if ( $("#"+id).is (':hidden'))
            $("#"+id).show('slow');
        else
            $("#"+id).hide('slow');
    }

    /*Administrar empleados*/
    $("#addNewEmpleado").on("click",function(e){
        e.preventDefault();
        llenarSelectSucursal();
        mostr_ocultr("frmAddEmpleado");
    });


    $(".bRegEmpleado").on("click",function(e){
        e.preventDefault();
        var opcion = this.getAttribute("href");
        if(validarFormEmpleado()){
            var formulario = document.frmAddEmpleado;
            var empleado = new Object();
            empleado.cedula = formulario.cedula.value.trim();
            empleado.nombre = formulario.nombreEmpl.value.trim();
            empleado.telf = formulario.telf.value.trim();
            empleado.idSucursal = formulario.selectSucursal.value;
            empleado.contrasenia = empleado.nombre.substr(0,1)+empleado.cedula.substr(0,3);
            if($('input:checkbox[name=emplHabl]:checked').val()==undefined){
                empleado.disponible = "0";
            }else{
                empleado.disponible = "1";
            }
            enviarAjax("../../Business/ControladoraEmpleado.php?metodo=addEmpleado",JSON.stringify(empleado));
            limpiarFormAddEmpleado();
            mensajeExito("Empleado agregado..");
            mostrarEmpleadosBySucursal();
        }else{
            alert("Hay algunos errores");
        }
    });

    function limpiarFormAddEmpleado(){
        var formulario = document.frmAddEmpleado;
        formulario.cedula.value = "";
        formulario.nombreEmpl.value = "";
        formulario.telf.value = "";
        $('#selectSucursal > option[value="0"]').attr('selected', 'selected');
        $("input:checkbox[name=emplHabl]").prop("checked", false);
    }

    function validarFormEmpleado(){
        var respuesta = false;
        var formulario = document.frmAddEmpleado;
        
        if(formulario.cedula.value.trim().length !=0 && formulario.nombreEmpl.value.trim().length !=0 && 
            formulario.telf.value.trim().length !=0){
            respuesta = true;
        }
        return respuesta;
    }

    function llenarSelectSucursal(){
        var opciones= '';
         $.ajax({
            url:'../../Business/sucursalController.php?accion=mostrarSucursales',
            type:'GET',
            data:{},
            success: function(responseText){
               var data = JSON.parse(responseText);
               $.each(data, function(i, item) {
                   opciones += '<option value="'+ data[i].id + '">' + data[i].nombre + '</option>'; 
               });

                $("#selectSucursal").append(opciones);
            }
        });
    } 

    function enviarAjax(direccionServer, datos){
        var resultado="";
        $.ajax({
            url:direccionServer,
            type:'GET',
            data:{arrayDatos:datos},
            success: function(responseText){
                resultado = responseText;
            }
        }); 
        return resultado;
    }
    
   
    /*Fin administrar empleados*/

    function mensajeExito(mensaje){
        alertify.success(mensaje);
    }

    function limpiarTablaPorId(id){
       $("#"+id+" tbody tr").each(function (index){
            $(this).remove();
        }); 
    }

    });







