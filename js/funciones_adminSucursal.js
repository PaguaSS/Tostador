$(document).ready(function(){
    alertify.set('notifier','position', 'top-rigth');

    $('.opBarNav').on('click',function(e){
		e.preventDefault();
		var opcion = this.getAttribute("href");

		/*Admnistrador*/
		if(opcion=="admsucursal"){
			$("#contenedorAdministrador").empty();
			cargar_pagina("#contenedorAdministrador", "../administracion/administrar_sucursales.php");
		}else{
			if(opcion=="admempleado"){
				$("#contenedorAdministrador").empty();
				cargar_pagina("#contenedorAdministrador","../administracion/administrar_empleados.php");
			}
		}
	   });

    $(".btn-cancel").on('click',function(e){
        e.preventDefault();
        var opcion = this.getAttribute("href");
        
        if(opcion == "frmAddSucursal"){
            mostr_ocultr("frmAddSucursal");
        }

    });

    /*Muestra form Agregar sucursal*/
	$("#addSucursal").on("click",function(){
        $("#selectEmpleados").empty();
		llenarSelectEmpleados();
		mostr_ocultr("frmAddSucursal");
	});

	$("#addEmpleado").on("click",function(e){
		e.preventDefault();
		addEmpleadoTb();
	});	

	function cargar_pagina(lugarACargar,nombrePagina){
		$(lugarACargar).load(nombrePagina);
		$(lugarACargar).fadeIn(1000);
	}

	function mostr_ocultr(id){
		
        if ( $("#"+id).is (':hidden'))
            $("#"+id).show('slow');
        else
            $("#"+id).hide('slow');
    }

    /*Enviar formulario Agregar Sucursal*/

    $("#bRegistrarSucursal").on('click',function(e){
    	e.preventDefault();
    	if(validar_form_addsucursal()==false){
        	var formulario = document.frmAddSucursal;
        	var sucursal = new Object();

        	sucursal.nombre = formulario.nomSucursal.value;
			sucursal.direccion = formulario.direccion.value;
			sucursal.telf = formulario.telf.value;

			if($('input:checkbox[name=habilitado]:checked').val()==undefined){
				sucursal.disponible = "0";
			}else{
				sucursal.disponible = "1";
			}

			sucursal.empleados = obtenerEmpleadosTabla();
			enviarAjax("../../Business/sucursalController.php?accion=addSucursal",JSON.stringify(sucursal));
            limpiarFormSucursal();
            cargar_pagina("#contenedorAdministrador", "../view/administracion/administrar_sucursales.php");
            mostrarSucursalesAdmin();
    	}else{
    		notif({
                    'type': 'error',
                    'msg': 'Algunos campos estan vacios',
                    'position': 'right',
                    'timeout': 600000
            });
    	}
    });


    function enviarAjax(direccionServer, datos){
    	$.ajax({
            url:direccionServer,
            type:'GET',
            data:{arrayDatos:datos},
            success: function(responseText){
            }
        });	
    }
    function validar_form_addsucursal(){
    	var formulario=document.frmAddSucursal;
    	var respuesta = false;
    	if(formulario.nomSucursal.value.length == 0){
    		respuesta = true;
    	}else{
    		if(formulario.direccion.value.length == 0){
    			respuesta = true;
    		}else{
    			if(formulario.telf.value.length == 0){
    				respuesta = true;
    			}
    		}
    	}
    	return respuesta;
    }

    function obtenerEmpleadosTabla(){
    	var empleados=[];
    	$("#tbEmpleados tbody tr").each(function (index) 
        {
            var nombre, cedula;
            $(this).children("td").each(function (index2) 
            {
                switch (index2) 
                {
                    case 0: nombre = $(this).text();
                            break;
                    case 2: cedula = $(this).text();
                            break;
                }
            });
            item = {}
        	item ["cedula"] = cedula;
        	item ["nombre"] = nombre;
        	empleados.push(item);
        });
        return JSON.stringify(empleados);
    }

    function llenarSelectEmpleados(){
		var opciones= '';
    	 $.ajax({
            url:'../../Business/ControladoraEmpleado.php?metodo=mostrarEmpleadoNombre',
            type:'GET',
            data:{},
            success: function(responseText){
               var data = JSON.parse(responseText);
               $.each(data, function(i, item) {
				   opciones += '<option value="'+ data[i].cedula + '">' + data[i].nombre + '</option>';	
			   });

                $("#selectEmpleados").append(opciones);
            }
        });
    }

    /*Eliminar una sucursal*/
    

    
    /*FIN------------Eliminar una sucursal*/
    function eliminarOpDeTb(obj){
        var idFila = obj.getAttribute("href");
        var nombre, cedula;
        
        $("#"+idFila).children("td").each(function (index2)
        {
            switch (index2) 
            {
                case 0: nombre = $(this).text();
                break;
                case 2: cedula = $(this).text();
                break;
            }
        });
        $("#"+idFila).remove();
        addOpSelect(cedula, nombre);
    }
    function addEmpleadoTb(){
    	if($("#selectEmpleados option:selected").html()!=undefined){
	        var trs = $("#tbEmpleados tr").length;
	        var idTr = trs+1;

	        var nuevaFila = "<tr id='trTbEmpl"+idTr+"'>";
			nuevaFila += "<td>"+$("#selectEmpleados option:selected").html()+"</td>";
			nuevaFila +="<td><a href='trTbEmpl"+idTr+"' class='icono eliminar removerOpTbEmpl'><span class='icon-bin2'></span></a></td>";
			nuevaFila += "<td class='ocultaTd'>"+$("#selectEmpleados").val()+"</td>";
			nuevaFila += "</tr>";

			eliminarOpSelect($("#selectEmpleados").val());
			$("#tbEmpleados").append(nuevaFila);
			$("a.removerOpTbEmpl").off('click');
			$("a.removerOpTbEmpl").on('click', function(e) {
				e.preventDefault();
		     	eliminarOpDeTb(this);
		    });;
		}else{
			mostrarMsjError("No hay empleados para añadir");
		}
    }

    function eliminarOpSelect(valor){
    	$("#selectEmpleados").find("option[value='"+valor+"']").remove(); 
    }

    function addOpSelect(value,descrip){
    	$('#selectEmpleados').append('<option value="'+value+'">'+descrip+'</option>');  
    }

    function limpiarFormSucursal(){
        var formulario = document.frmAddSucursal;
        formulario.nomSucursal.value = "";
        formulario.direccion.value = "";
        formulario.telf.value = "";
        $("#selectEmpleados").empty();

        $("#tbEmpleados tbody tr").each(function (index){
            $(this).remove();
        });

        $("input:checkbox[name=habilitado]").prop("checked", false);
        llenarSelectEmpleados();
    }

    function limpiarTablaPorId(id){
       $("#"+id+" tbody tr").each(function (index){
            $(this).remove();
        }); 
    }

    function mostrarMsjError(mensaje){
    	alertify.error(mensaje);
    }
});