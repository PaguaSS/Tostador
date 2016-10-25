<?php
    session_start();
    include_once '../../Data/DataCategoria.php';
    $dataCategoria = new DataCategoria();
    $categorias = $dataCategoria->getCategoria(0);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="">
    <script type="text/javascript" src="../../js/gestion_inventario.js"></script>
</head>
<body>
    <div class="contenedorAdmInventario">
        <div class="menuLateral">
            <p>Gestión de:</p>
            <ul>
                <li>
                    <a href="shProductos" data-id="<?php echo $_SESSION["idSucursal"];?>" class="shListaInventario"><span class="icon-database"></span>Productos</a>
                </li>
                <li>
                    <a href="shCategoria" data-id="0" class="shListaInventario"><span class="icon-location-arrow"></span>Categorias</a>
                </li>
            </ul>
        </div>
        <div id="contenedorListas" class="contenedorSecundario">
            
        </div>
    </div>
    <div style="display: none;" class="contenedorModal" id="formProducto">
        <form method="post" action="" name="formProducto" id="fProducto" accept-charset="UTF-8">
            <p>Sucursal <?php echo $_SESSION["nombreSucursal"];?></p>
            <input type="hidden" name="sucursal" value="<?php echo $_SESSION["idSucursal"];?>">
            <input type="hidden" name="codigo" value="0">
            <input type="hidden" name="metodo" value="insertar">

            <label>Nombre</label>
            <input type="text" class="inputShadow " name="nombre" placeholder="Producto"> 
            

            <label>Abreviatura</label>
            <input type="text" class="inputShadow" name="abrev" placeholder="No puede ser la misma para otro producto"> 
                        
            <label>Stock</label>
            <input type="text" class="inputShadow solo-numero" name="stock" placeholder="Cantidad en inventario"> 
            
            <label>Precio</label>
            <input type="text" class="inputShadow solo-numero" name="precio" placeholder="Precio por unidad o Kilo">           
            <ul>
            <li>
                <label class="lblSelect">Unidad de Medida</label>
                <select id="unidadMedida">
                    <ul>
                        <option value="n">No definido</option>
                        <option value="k">Kilo</option>
                        <option value="u">Unidad</option>
                    </ul>
                </select>
            </li>
            <li>
            <label class="lblSelect">Proveedor</label>
                <select id="proveedor">
                    <option value="i">Interno</option>
                    <option value="e">Externo</option>
                </select>
           </li>
           <li>
                <label class="lblSelect">Categoria</label>
                <select id="categoria">
                        <?php
                            foreach (json_decode($categorias) as $categoria) {
                                echo "<option value='".$categoria->id."'>".$categoria->nombre."</option>";
                            }
                        ?>
                </select>
            </li>
            <li>   
                <label class="lblSelect">Tamaño</label>
                <select id="tamanio">
                    <option value="n">No definido</option>
                    <option value="p">Pequeño</option>
                    <option value="g">Grande</option>
                </select>
            </li>
            </ul>
            <div>
                <a href="<?php echo $_SESSION["idSucursal"];?>" class="btn-bAddMixtos btn-click">Agregar productos(Ingredientes o componentes)</a>
            </div>
            <div class="opsFProducto">
               <a href="add" class="opFormProducto btn-submit" id="bAddUpdatePrdct">Agregar</a>
               <a href="can" class="opFormProducto btn-submit">Cancelar</a>
            </div>
        </form>
    </div>
    <!--Form para productos mixtos -->
    <div id="fListProductoMixto" class="contenedorModal" style="display: none;">
        <div class="sombraModal">
            <ul>
                <li>
                    <table class="tbEstandar" id="tbPrdsDisponibles">
                        <thead>
                            <tr>
                                <th>Nombre productos disponibles</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </li>
                <li>
                    <div>
                        <a href="add" class="btn-fMixtos"><span class="icon-arrow-right"></span></a>
                        <a href="rest" class="btn-fMixtos"><span class="icon-arrow-left"></span></a>
                    </div>
                </li>
                <li>
                    <table class="tbEstandar" id="tbPrdsAgregados">
                        <thead>
                            <tr class="trHeader">
                                <th>Productos agregados</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                </li>
            </ul>
            <div class="opsTbMixtos">
               <a href="add" class="opFTbMixtos btn-submit">Añadir</a>
               <a href="can" class="opFTbMixtos btn-submit">Cancelar</a>
            </div>
        </div>
    </div>
    <div class="addCategoria contenedorModal" id="formCategoria" style="display: none;">
    	<div class="formDModal sombraModal">
            <input type="hidden" id="idCategoria" value="">
            <label>Agregar nueva categoria</label>
        	<input type="text" id="nomCategoria" class="inputShadow" placeholder="Ingrese el nombre de la categoria">
        	<div class="opsAddCategoria ">
                <a href="add" class="opFormCategoria btn-submit" data-actualizar="" id="bAccionSubmit">Agregar</a>
                <a href="can" class="opFormCategoria btn-submit">Cancelar</a>
            </div>
        </div>
    </div>
	<!--Opciones para agregar categoria o producto -->
    <div class="opsProducto" style="display: none;">
    	<ul>
    		<li><a href="#"><span class="i"></span>Producto</a></li>
    		<li><a href="#"><span class="i"></span>Categoria</a></li>
    	</ul>
    	<a href="#" class=""><span class="icon-plus2"></span></a>
    </div>
    <a class='flotante' id="fabInventario" href='#'><span class="icon-plus"></span></a>
    <div class="menu-fab" style="display: none;">
        <ul>
            <li class="dropLi"><a class='dropA opMenuFab' href='#formProducto'>Producto</a></li>
            <li class="dropLi"><a class='dropA opMenuFab' href='#formCategoria'>Categoria</a></li>
        </ul>
    </div>
    <script>
        $(document).ready(function (){
          $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
          });
        });
    </script>
</body>
</html>	