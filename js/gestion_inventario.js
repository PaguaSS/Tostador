$(document).ready(function(){
	/*Submenu Gestion inventario*/
    $(".shListaInventario").on("click",function(e){
        e.preventDefault();
        var mostrar = this.getAttribute("href");
        $("#contenedorListas").load("../Producto/Listar.php?metodo="+mostrar+"&id="+$(this).data("id"));
        
    });
    /*Submenu Gestion inventario*/
    $("#fabInventario").on("click",function(e){
    	e.preventDefault();
    	if($(".menu-fab").is(":visible")){
        	$(".menu-fab").hide();
    	}else{
    		$(".menu-fab").show();
    	}
        
    });
    
     $(".menu-fab").hover(function(){
        $(".menu-fab").show();
	    },function(){
	    	$(".menu-fab").hide();
    });
    /*evento para opciones de submenu del FAB*/
     $(".opMenuFab").on("click",function(e){
        e.preventDefault();
        $("#bAddUpdatePrdct").text("Agregar");
        var formulario = this.getAttribute("href");
        if(formulario == "#formCategoria"){
            $("#bAccionSubmit").text("Agregar");
        }
        $(formulario).fadeIn();
     })

    /*pFormCategoria*/
    
    $(".opFormCategoria").on("click",function(e){
        e.preventDefault();
        var accion = this.getAttribute("href");
        if(accion == "add"){
            if($("#idCategoria").val().trim().length == 0){
                var cat = $("#nomCategoria").val();
                if(cat.trim().length >= 4 ){
                    addCategoria(cat);
                }else{
                    alertify.error('Debe ingresar almenos 4 caracteres');
                }
            }else{
                var nom = $("#nomCategoria").val().trim();
                actualizarCategoria( $("#idCategoria").val().trim(), nom);
            }
        }else{
            if(accion == "can"){
                $("#nomCategoria").val("");
                $("#formCategoria").hide();
                $("#actualizarCategoria").text("Agregar");
            }
        }
    });

    function addCategoria(nombreCategoria){
        $.ajax({
            url:"../../Business/ControladoraCategoria.php?metodo=insertar",
            type:'GET',
            data:{nombre:nombreCategoria},
            success: function(responseText){
                alertify.success("Se ha insertado la nueva categoria");
                actualizarListado("shCategoria", "0");
                $("#nomCategoria").val("");
            }
        }); 
    }

    function actualizarCategoria(codigo, nombreCat){
        $.ajax({
            url:"../../Business/ControladoraCategoria.php?metodo=actualizar",
            type:'GET',
            data:{id:codigo,nombre:nombreCat},
            success: function(responseText){
                alertify.success("Se actualizó el nombre de la categoria");
                $("#nomCategoria").val("");
                $("#formCategoria").hide();
                $("#actualizarCategoria").attr("href","add");
                $("#actualizarCategoria").val("Agregar");
                actualizarListado("shCategoria", "0");
            }
        });  
    }
    /*fin metodos add categoria*/

    function actualizarListado(mostrar,id){
        $("#contenedorListas").load("../Producto/Listar.php?metodo="+mostrar+"&id="+id);
    }

    /*Metodos IMEC producto*/

    $(".opFormProducto").on("click",function(e){
        e.preventDefault();
        var accion = this.getAttribute("href");
        if(accion == "add"){
            if(validaFormProducto()){
                alertify.error("No se puede ingresar el producto \nHay campos vacios. ");
            }else{
                /*Aca no se puede obtener el valor rapido del ajax por
                  eso, en existeAbreviatura se agrega el producto para 
                  esperar la respuesta del server. 
                */
                var form = document.formProducto;
                existeAbreviatura($.trim(form.abrev.value),$.trim(form.sucursal.value));
            }
        }else{
            if(accion == "can"){
                limpiarFormProducto();
                $("#formProducto").hide();
            }
        }
    });

    function validaFormProducto(){
        var respuesta = false;
        $("#fProducto").find(':input').each(function() {
            if($(this).is( "[type=text]" )){
                var str = $(this).val();
                if(str.trim().length == 0){
                    respuesta = true;
                }
            }
        });
        return respuesta;
    }

    function limpiarFormProducto(){
        $("#fProducto").find(':input').each(function() {
            if($(this).is( "[type=text]" )){
                $(this).val("");
            }
        });
        document.getElementById("unidadMedida").selectedIndex=0;
        document.getElementById("proveedor").selectedIndex=0;
        document.getElementById("tamanio").selectedIndex=0;
        document.getElementById("categoria").selectedIndex=0;
    }

    function addProducto(codigo,nombre,abreviatura,stock,precio,unidadMedida,proveedor,tamanio,idSucursal,idCategoria){
        var codigosProducto = obtenerIngredientes();
        if(codigosProducto.length == 0) {
           codigosProducto = "";
        }

        $.ajax({
            url:"../../Business/ControladoraProducto.php?metodo=insertarActualizar",
            type:'GET',
            data:{codigo:codigo,nombre:nombre,abreviatura:abreviatura,stock:stock,precio:precio,unidadMedida:unidadMedida,
                proveedor:proveedor,tamanio:tamanio,idSucursal:idSucursal,idCategoria:idCategoria,codigosIngredientes:codigosProducto},
            success: function(responseText){
                alertify.success("Se ha agregado un nuevo producto");
                actualizarListado("shProductos", idSucursal);
                limpiarFormProducto();
                limpiarTablaPorId("tbPrdsAgregados");
                limpiarTablaPorId("tbPrdsDisponibles");
            }
        }); 
    }

    function existeAbreviatura(abrev,sucursal){
        var form = document.formProducto;
        $.ajax({
            url:"../../Business/ControladoraProducto.php?metodo=verificarAbreviatura",
            type:'GET',
            data:{abreviatura:abrev,idSucursal:sucursal},
            success: function(responseText){
                var data = JSON.parse(responseText);
                
                if(data.cantidad==undefined){
                   addProducto(form.codigo.value,form.nombre.value, form.abrev.value, 
                        form.stock.value,form.precio.value,$("#unidadMedida").val(), 
                        $("#proveedor").val(),$("#tamanio").val(), form.sucursal.value, 
                        $("#categoria").val());
                }else{
                    if(form.metodo.value=="actualizar"){
                        addProducto(form.codigo.value,form.nombre.value, form.abrev.value, 
                        form.stock.value,form.precio.value,$("#unidadMedida").val(), 
                        $("#proveedor").val(),$("#tamanio").val(), form.sucursal.value, 
                        $("#categoria").val());
                        form.metodo.value = "insertar";
                    }else{
                        alertify.error("La abreviatura existe, tiene que ser diferente");
                    }
                }
            }
        });
    }

    function obtenerIngredientes(){
        var codigosProducto = "";
        $("#tbPrdsAgregados tbody tr").each(function(index, element){
            codigosProducto += $(this).attr("id")+",";
        });

        return codigosProducto;
    }

    /*Form agregar productos mixtos*/
    $(".btn-bAddMixtos").on("click",function(e){
        e.preventDefault();
        var idSucursal = this.getAttribute("href");
        llenarTablaPrdsDisponibles(idSucursal);
        $("#fProducto").fadeOut("slow");
        $("#fListProductoMixto").fadeIn("slow");
    });

    $(".opFTbMixtos").on("click",function(e){
        e.preventDefault();
        var accion = this.getAttribute("href");
        if(accion=="add"){
            $("#fListProductoMixto").fadeOut("slow");
            $("#fProducto").fadeIn();
        }else{
            if(accion=="can"){
               $("#fListProductoMixto").fadeOut("slow");
               $("#fProducto").fadeIn();
               var form = document.formProducto;
                limpiarTablaPorId("tbPrdsAgregados");
                limpiarTablaPorId("tbPrdsDisponibles");
            }
        }
    });

    $(".btn-fMixtos").on("click",function(e){
        e.preventDefault();
        var accion = this.getAttribute("href");
        
        if(accion=="add"){
            addIngrediente();
        }else{
            var form = document.formProducto;
            if(form.metodo.value=="actualizar"){
                restarPorNombre();
            }else{
                restarIngrediente();
            }
        }

    });

    function addIngrediente(){
        $("#tbPrdsDisponibles tbody tr").each(function (index) 
        {
            var idFila = $(this).attr("id");
            var isChecked = $("#"+idFila+" input:checkbox")[0].checked;
            var producto = "";
            var isVisible = $("#"+idFila+" input:checkbox").is(":visible");
            var codigoProducto = "";
            if(isChecked && isVisible){
                $(this).children("td").each(function (index2) 
                    {
                    switch (index2) 
                    {
                        case 0: 
                            producto = $(this).text();
                            codigoProducto = $(this).find('input').val();
                            break;
                    }
                });
                var fila = "<tr id='"+codigoProducto+"'>"
                          +"<td>"
                          +"<input type='checkbox' checked='false' value='"+idFila+"'>"
                          +producto
                          +"</td>"
                          +"</tr>";
                $(this).hide();
                $("#tbPrdsAgregados").append(fila);
                quitarChecks();               
            }
        });
    }

    function restarIngrediente(){
        $("#tbPrdsAgregados tbody tr").each(function(index, element){
            var isChecked = false;
            var idFila = "";
           $(this).children("td").each(function (index2) 
            {
                switch (index2){
                        case 0: 
                        idFila = $(this).find('input').val();
                        isChecked = $(this).find(":checkbox").is(':checked');
                        break;
                }
            });
           if(isChecked){
            $(this).remove();
            mostrarTr(idFila);
           }
        });
    }
    function restarPorNombre(){
        $("#tbPrdsAgregados tbody tr").each(function(index, element){
            var isChecked = false;
            var nombre = "";
           $(this).children("td").each(function (index2) 
            {
                switch (index2){
                        case 0:
                        nombre = $(this).text();
                        isChecked = $(this).find(":checkbox").is(':checked');
                        break;
                }
            });
           if(isChecked){
            $(this).remove();
                mostrarTrPorNombre(nombre);
           }
        });
    }
    function mostrarTr(idFila){
        $("table#tbPrdsDisponibles tr#"+idFila).children("td").each(function (index2) 
        {
            $(this).find('input:checkbox').each(function(){
                $(this).attr("checked", false);
            });
        });
        $("table#tbPrdsDisponibles tr#"+idFila).show();
    }

    function mostrarTrPorNombre(nomPrdct){
        $("table#tbPrdsDisponibles tbody tr").each(function(index, element)
        {
            var nombre = "";
            $(this).children("td").each(function (index2) 
            {
                switch (index2){
                        case 0:
                        nombre = $(this).text();
                        break;
                }
            });
            if(nombre == nomPrdct){
                $(this).show();
            }
        });
    }

    function quitarChecks(){
        $("#tbPrdsAgregados tbody tr").children("td").each(function (index2) 
        {
            $(this).find('input:checkbox').each(function(){
                $(this).attr("checked", false);
            });
        });
    }

    function limpiarTablaPorId(id){
        $("#"+id+" tbody tr").each(function (index){
            $(this).remove();
        }); 
    }

    function llenarTablaPrdsDisponibles(sucursal){
        $.ajax({
            url:"../../Business/ControladoraProducto.php?metodo=getProductosNoMixtos",
            type:'GET',
            data:{idSucursal:sucursal},
            success: function(responseText){
                var data = JSON.parse(responseText);
                var filas = "";
                $.each(data, function(i, item) {
                    //cuando se quiere modifica un producto, ya se ha cargado 
                    //la lista de productos que conforman al mismo, por lo tanto 
                    //se tienen que ocultar aquellos productos que se agregaron
                    if(estaAgregado(data[i].codigo)){
                        filas += "<tr id='tr"+i+"' style='display:none;'><td><input type='checkbox' value='"+data[i].codigo+"'>"+data[i].nombre+"</td></tr>"; 
                    }else{
                        filas += "<tr id='tr"+i+"'><td><input type='checkbox' value='"+data[i].codigo+"'>"+data[i].nombre+"</td></tr>"; 
                    }
                });
                $("#tbPrdsDisponibles").append(filas);
            }
        });
    }

    function estaAgregado(codigoProducto){
        var esta=false;
            $("#tbPrdsAgregados tbody tr").each(function(index, element){
                if($(this).attr("id")==codigoProducto){
                    esta=true;
                }
        });

        return esta;
    }
});
