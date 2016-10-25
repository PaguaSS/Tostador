<?php 
    include_once 'Data.php';

    class DataVenta{
        var $conexion;
        
        function __construct(){
            $mysqli = new Data();
            $this->conexion = $mysqli->getConexion();
        }

        public function insertarVenta($venta, $listaDetalle){
            $sentencia = $this->conexion->stmt_init();
            $sentencia->prepare("CALL paInsertarVenta(?,?,?,?,?,?);");

            $idSucursal= $venta->getIdSucursal();
            $fechaHora= $venta->getFechaHora(); 
            $idEmpleado= $venta->getIdEmpleado();
            $impuestoVenta= $venta->getImpuestoVenta();
            $subtotal= $venta->getSubtotal(); 
            $total= $venta->getTotal();
            $sentencia->bind_param("ssssss",$idSucursal, $fechaHora, $idEmpleado, $impuestoVenta, $subtotal, $total);

            $sentencia->execute();
            $afectados =  mysqli_affected_rows($this->conexion);
            $sentencia->close();

            if(!empty($listaDetalle)){

                $query = "SELECT codigo FROM venta ORDER BY codigo DESC LIMIT 1;";
                $result = $this->conexion->query($query);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $this->insertarDetalle($row['codigo'], $listaDetalle);
                }
            }else{
                mysqli_close($this->conexion);
            }
        }

        public function insertarDetalle($codVenta, $listaDetalle){
            $array = json_decode($listaDetalle);
            foreach ($array as $lineaVenta) {
                $sentencia = $this->conexion->stmt_init();
                $sentencia->prepare("CALL paInsertarDetalleVenta(?,?,?,?,?);");

                $codigoVenta = $codVenta;
                $codigoProducto = $lineaVenta->codigoProducto;
                $precio = $lineaVenta->precio;
                $cantidad = $lineaVenta->cantidad;
                $totalLinea = $lineaVenta->totalLinea;
                $sentencia->bind_param("sssss",$codigoVenta, $codigoProducto, $precio, $cantidad, $totalLinea);

                $sentencia->execute();
            }
        }

        public function mostrar($idSucursal, $cedulaEmpleado){
            
        }

    }
?>