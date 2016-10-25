<?php
	include_once ("Data.php");
	
	class DataEmpleado {

		var $conexion;
        
        function __construct(){
            $mysqli = new Data();
            $this->conexion = $mysqli->getConexion();
        }

		public function getEmpleadosBySucursal(){
	        $query = "CALL ucrgrupo4.paGetEmpleadosBySucursal;"; 
	        $result = $this->conexion->query($query);

	        if ($result->num_rows > 0) {
	            $index = 0;
	            while ($row = $result->fetch_assoc()) {
	                $data[$index]["idSucursal"] = $row["idSucursal"];
	                $data[$index]["nombreSucursal"] = $row["nombreSucursal"];
	                $data[$index]["cedula"] = $row["cedula"];
	                $data[$index]["nombre"] = $row["nombre"];
	                $index ++;
	            }
	            return json_encode($data);
	        }
	        mysqli_close($this->conexion);
		}
		public function insertarEmpleado($arrayDatos){
			$empleado = json_decode($arrayDatos);

			$sentencia = $this->conexion->stmt_init();
			$sentencia->prepare("CALL paInsertarEmpleado(?,?,?,?,?,?,?,?)");

			$cedula = $empleado->cedula; 
	        $nombre = $empleado->nombre; 
	        $telefono = $empleado->telf; 
	        $contrasenia = md5($empleado->contrasenia); 
	        $fechaIngreso = date("Y")."-".date("m")."-".date("d"); 
	        $habilitado = $empleado->disponible; 
	        $tipoEmpleado = "e"; 
	        $idSucursal = $empleado->idSucursal;
	        $sentencia->bind_param("ssssssss", $cedula, $nombre, $telefono, $contrasenia, $fechaIngreso, $habilitado,$tipoEmpleado, $idSucursal);

	        $sentencia->execute();
	        $sentencia->close();
	        mysqli_close($this->conexion);
		}

		public function getEmpleados(){
			$query = "CALL ucrgrupo4.paObtenerEmpleados();"; 
			$result = $this->conexion->query($query);

			if ($result) {
			   $index = 0;
			   while ($row = $result->fetch_assoc()) {
				   	$data[$index]["cedula"] = $row['cedula'];
				   	$data[$index]["nombre"] = $row['nombre'];

				   	$index ++;
		    	}
		    return json_encode($data);
			}
		}

		public function getEmpleadoById($cedula){
			$sentencia = $this->conexion->stmt_init();
        	$sentencia->prepare("CALL ucrgrupo4.paGetEmpleadosByCedula(?);"); 

        	$cedulaEmpleado = $cedula;
        	$sentencia->bind_param("s", $cedulaEmpleado);

        	$sentencia->execute();
        	$sentencia->bind_result($cedula,$nombre,$telefono,$fechaIngreso, $habilitado,$idSucursal, $nombreSucursal);
        	$empleados = array();
        	
            while ($sentencia->fetch()) {
	                array_push($empleados,"cedula"=>$cedula,"nombre"=>$nombre,"telefono"=>$telefono,"fechaIngreso"=>$fechaIngreso, "habilitado"=>$habilitado,"idSucursal"=>$idSucursal, "nombreSucursal"=>$nombreSucursal);
        	}
        	$sentencia->close();
            return json_encode($empleados);
        	mysqli_close($this->conexion);
		}

		public function eliminarEmpleado($cedula){
			$sentencia = $this->conexion->stmt_init();
	        $sentencia->prepare("CALL paEliminarEmpleado(?)");

	        $cedulaEmpleado = $cedula;
	        $sentencia->bind_param("s", $cedulaEmpleado);

	        $sentencia->execute();
	        $afectados =  mysqli_affected_rows($this->conexion);
	        mysqli_close($this->conexion);

        return $afectados;
		}

	}

?>