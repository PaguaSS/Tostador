<?php
include_once ("Data.php");
    class DataCategoria{

        var $conexion;
        
        public function DataCategoria(){
            $mysqli = new Data();
            $this->conexion = $mysqli->getConexion();
        }

        public function agregarActualizarCategoria($categoria){
            
            $sentencia = $this->conexion->stmt_init();
            $sentencia->prepare("CALL paInsertarActualizarCategoria(?,?)");

            $nombre = $categoria->getNombre();
            $codigo = $categoria->getCodigo(); 
            $sentencia->bind_param("ss", $nombre, $codigo);

            $sentencia->execute();
            
            $sentencia->close();
            mysqli_close($this->conexion);
        }

        public function eliminarCategoria($codigoCategoria){
            $sentencia = $this->conexion->stmt_init();
            $sentencia->prepare("CALL paEliminarCategoria(?)");
            $codigo = $codigoCategoria;
            $sentencia->bind_param("s", $codigo);

            $sentencia->execute();
            $afectados =  mysqli_affected_rows($this->conexion);
            mysqli_close($this->conexion);

        return $afectados;
        }

        public function getCategoria($codigoCategoria){

            $sentencia = $this->conexion->stmt_init();
            $sentencia->prepare("CALL paObtenerCategoria(?);");

            $codigo = $codigoCategoria;
            $sentencia->bind_param("s", $codigo); 

            $sentencia->execute();
            $sentencia->bind_result($id,$nombre);

            $array = array();

            while($sentencia->fetch()){

                array_push($array, array("id"=>$id,"nombre"=>$nombre));
            }
            
            $sentencia->close();
            return json_encode($array);
            
            mysqli_close($this->conexion);
        }
    }
?>
