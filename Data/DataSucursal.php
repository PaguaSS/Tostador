<?php

include_once 'Data.php';

class DataSucursal{

    var $conexion;
        
    function __construct(){
        $mysqli = new Data();
        $this->conexion = $mysqli->getConexion();
    }

    public function insertarSucursal($arrayDatos) {
        $sucursal = json_decode($arrayDatos);

        $sentencia = $this->conexion->stmt_init();
        $sentencia->prepare("CALL paAgregarSucursal(?,?,?,?,?)");

        $nombre = $sucursal->nombre;
        $direccion = htmlentities($sucursal->direccion, ENT_QUOTES, 'UTF-8');
        $telf = $sucursal->telf;
        $disponible = $sucursal->disponible;
        $idAdmin = 1;

        $sentencia->bind_param("sssss", $nombre, $direccion, $telf, $disponible, $idAdmin);
        $sentencia->execute();

        /* Obtiene la sucursal agregada */
        $query = "SELECT id FROM sucursal ORDER BY id DESC LIMIT 1;";
        $result = $this->conexion->query($query);

        $idSucursal = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $idSucursal = $row['id'];
            }
        }

        foreach (json_decode($sucursal->empleados) as $obj) {
            
            $stmt = $this->conexion->stmt_init();

            $stmt->prepare("CALL paActualizarSucursalEmpleado(?,?)");
            $cedula = $obj->cedula;

            $stmt->bind_param("ss", $cedula, $idSucursal);
            $stmt->execute();
        }

        mysqli_close($this->conexion);
    }
    
    public function getSucursales(){

        $query = "CALL ucrgrupo4.paMostrarSucursales;"; 
        $result = $this->conexion->query($query);

        if ($result->num_rows > 0) {
            $index = 0;
            while ($row = $result->fetch_assoc()) {
                $data[$index]["id"] = $row['id'];
                $data[$index]["nombre"] = $row['nombre'];
                $data[$index]["disponible"] = $row['disponible'];
                $index ++;
            }
            return json_encode($data);
        }
        mysqli_close($this->conexion);
    }

    public function eliminarSucursal($id){
        $sentencia = $this->conexion->stmt_init();
        $sentencia->prepare("CALL paEliminarSucursal(?)");

        $idSucursal = $id;
        $sentencia->bind_param("s", $idSucursal);

        $sentencia->execute();
        $afectados =  mysqli_affected_rows($conexion);
        mysqli_close($this->conexion);

        return $afectados;
    }

}

?>