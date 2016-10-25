<?php
    include_once 'Data.php';
   
    class DataProducto{
        var $conexion;
        
        function __construct(){
            $mysqli = new Data();
            $this->conexion = $mysqli->getConexion();
        }
        
        public function insertarActualizarProducto($producto, $componentesProducto){
            $sentencia = $this->conexion->stmt_init();

            $sentencia->prepare("CALL paInsertarActualizarProducto(?,?,?,?,?,?,?,?,?,?)");

            $codigo=$producto->getCodigo();
            $nombre=$producto->getNombre();
            $stock=$producto->getStock();
            $precio=$producto->getPrecio();
            $unidadMedida=$producto->getUnidadMedida();
            $proveedor=$producto->getProveedor();
            $tamanio = $producto->getTamanio();
            $idSucursal=$producto->getIdSucursal();
            $idCategoria=$producto->getIdCategoria();
            $abreviatura=$producto->getAbreviatura();

            $sentencia->bind_param("ssssssssss", $codigo,$nombre, $abreviatura, $stock, $unidadMedida, $precio,$proveedor,$tamanio,$idSucursal,$idCategoria);

            $sentencia->execute();
            $sentencia->close();

            if(!empty($componentesProducto)){
                $query = "SELECT codigo FROM producto ORDER BY codigo DESC LIMIT 1;";
                $result = $this->conexion->query($query);

                $codigoProducto = 0;
                if(empty($producto->getCodigo())){
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $codigoProducto = $row['codigo'];
                        }
                    }
                }else{
                   $codigoProducto = $producto->getCodigo();
                }
                $this->agregarProductosCompuestos($codigoProducto,$componentesProducto);
            }else{
                mysqli_close($this->conexion);
            }
        }

        public function agregarProductosCompuestos($codigoProducto, $componentes){
           
            $this->limpiarComponentesProducto($codigoProducto);
            $array = explode(",", $componentes);
            $longitud = count($array);
 
            //Recorro todos los elementos
            for($i=0; $i<$longitud; $i++){
                if($array[$i]!=0){
                    $sentencia = $this->conexion->stmt_init();
                    $sentencia->prepare("CALL paAgregarProductosProductoCompuesto(?,?)");

                    $codigoPrdCompuesto = $codigoProducto;
                    $codigoComponeProducto = $array[$i];

                    $sentencia->bind_param("ss", $codigoPrdCompuesto, $codigoComponeProducto);
                    
                    $sentencia->execute();
                }
            }
            mysqli_close($this->conexion);
        }
        // antes de insertar los componentes de un producto, elimina todos los componentes que tiene actualmente
        public function limpiarComponentesProducto($codigoProducto){
            $sentencia = $this->conexion->stmt_init();
            $sentencia->prepare("CALL paEliminarComponentesProducto(?)");

            $codigo = $codigoProducto;
            $sentencia->bind_param("s", $codigo);

            $sentencia->execute();
            $afectados =  mysqli_affected_rows($this->conexion);

            return $afectados;
        }

        public function getProductosBySucursal($idSucursal){
            $sentencia = $this->conexion->stmt_init();
            $sentencia->prepare("CALL paGetProductosBySucursal(?);");

            $codigo = $idSucursal;
            $sentencia->bind_param("s", $codigo);

            $sentencia->execute();
            $sentencia->bind_result($codigoProducto, $nombre, $stock, $unidadMedida, $precio, $proveedor,$tamanio, $abreviatura, $idCategoria, $nombreCategoria);
            
            $productos = array();
            while($sentencia->fetch()){

                array_push($productos, array("codigo"=>$codigoProducto,"nombre"=>$nombre, "stock"=>$stock,"unidadMedida"=>$unidadMedida, "precio"=>$precio,"proveedor"=>$proveedor, "tamanio"=>$tamanio,"abreviatura"=>$abreviatura, "idCategoria"=>$idCategoria,"nombreCategoria"=>$nombreCategoria));
            }
            
            $sentencia->close();
            mysqli_close($this->conexion);

            return json_encode($productos);
        }

        public function getProductosProductoCompuesto($codigoProducto){
            $sentencia = $this->conexion->stmt_init();
            $sentencia->prepare("CALL paGetProductosProductoCompuesto(?);");

            $codigo = $codigoProducto;
            $sentencia->bind_param("s", $codigo); 

            $sentencia->execute();
            $sentencia->bind_result($codProducto, $nombre, $stock, $unidadMedida, $precio, $proveedor,$tamanio, $abreviatura, $idCategoria, $nombreCategoria);
            
            $productos = array();
            while($sentencia->fetch()){

                array_push($productos, array("codigo"=>$codProducto,"nombre"=>$nombre, "stock"=>$stock,"unidadMedida"=>$unidadMedida, "precio"=>$precio,"proveedor"=>$proveedor, "tamanio"=>$tamanio,"abreviatura"=>$abreviatura, "idCategoria"=>$idCategoria,"nombreCategoria"=>$nombreCategoria));
            }
            
            $sentencia->close();
            mysqli_close($this->conexion);

            return json_encode($productos);
        }
        //Elimina ya sea un producto compuesto o solo un producto
        public function eliminarProducto($codigoProducto){
            $sentencia = $this->conexion->stmt_init();
            $sentencia->prepare("CALL paEliminarProducto(?)");

            $codigo = $codigoProducto;
            $sentencia->bind_param("s", $codigo);

            $sentencia->execute();
            $afectados =  mysqli_affected_rows($this->conexion);
            $sentencia->close();
            mysqli_close($this->conexion);

        return $afectados;
        }

        public function existeAbreviatura($abrev,$idSucursal){
            $sentencia = $this->conexion->stmt_init();
            $sentencia->prepare("CALL paVerificarAbreviaturaProducto(?,?);");
            
            $abreviatura = $abrev; 
            $codigoSucursal = $idSucursal;
            $sentencia->bind_param("ss", $abreviatura, $codigoSucursal);
            
            $sentencia->execute();
            $sentencia->bind_result($cantidad);
            
            $data["cantidad"] = $cantidad;
            
            $sentencia->close();
            mysqli_close($this->conexion);
            return json_encode($data);
        }

        public function getProductosNoCompuestos($idSucursal){
            $sentencia = $this->conexion->stmt_init();
            $sentencia->prepare("CALL paGetProductosNoMixtosBySucursal(?);");

            $codigo = $idSucursal; 
            $sentencia->bind_param("s", $codigo);

            $sentencia->execute();
            $sentencia->bind_result($codigoPrdct, $nombre, $stock, $unidadMedida, $precio, $proveedor,$tamanio, $abreviatura, $idCategoria, $nombreCategoria);

            $productos = array();
            while($sentencia->fetch()){
                array_push($productos, array("codigo"=>$codigoPrdct,"nombre"=>$nombre));
            }

            $sentencia->close();
            mysqli_close($this->conexion);

            return json_encode($productos);
        }
        //metodo para autocomplete
        public function getNombreProductoBySucursal($sucursal,$sugerencia){
            $consulta = "SELECT p.codigo, p.nombre, p.stock, p.unidadMedida, p.precio, p.abreviatura
                        FROM producto AS p
                        WHERE p.idSucursal=$sucursal
                        AND p.nombre LIKE '%$sugerencia%'
                        LIMIT 10 ;";
 
            $result = $this->conexion->query($consulta);
             
            if($result->num_rows > 0){
                while($fila = $result->fetch_array()){
                    $matriculas[] = $fila['nombre'];
                }
                return json_encode($matriculas);
            }
        }
        //metodo para obtener el precio de un producto
        public function getPrecioProducto($sucursal,$sugerencia){
            $sentencia = $this->conexion->stmt_init();
            $sentencia->prepare("CALL paGetPrecioProductoBySucursal(?,?);");

            $idSucursal = $sucursal; 
            $nombreProducto = $sugerencia;
            $sentencia->bind_param("ss", $idSucursal, $nombreProducto);

            $sentencia->execute();
            $sentencia->bind_result($codigoPrdct, $nombre, $stock, $unidadMedida, $precio,$abreviatura);

            $producto = array(); 
            while($sentencia->fetch()){
                array_push($producto,array("codigo"=>$codigoPrdct, "nombre"=>$nombre, "stock"=>$stock, "unidadMedida"=>$unidadMedida, "precio"=>$precio,"abrev"=>$abreviatura));
            }
            $sentencia->close();
            mysqli_close($this->conexion);

            return json_encode($producto);
        }

    }
?>
