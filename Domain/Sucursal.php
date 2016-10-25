<?php

  class Sucursal
  {
    private $cedulaJuridica;
    private $direccion;
    private $telefono;
    private $nombre;
    private $disponible;
    
    
    function getNombre() {
        return $this->nombre;
    }

    function getDisponible() {
        return $this->disponible;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDisponible($disponible) {
        $this->disponible = $disponible;
    }

                
    function __construct() {
        
    }

    
    function getCedulaJuridica() {
        return $this->cedulaJuridica;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function setCedulaJuridica($cedulaJuridica) {
        $this->cedulaJuridica = $cedulaJuridica;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

        

    function __constructLleno($cedulaJuridica, $direccion, $telefono)
    {
      $this -> cedulaJuridica = $cedulaJuridica;
      $this -> direccion = $direccion;
      $this -> telefono = $telefono;
    }

    function Delete() {
        $this->id = intval($_POST['id']);
        $query = "DELETE FROM foros WHERE id='$this->id';";
        $query .= "DELETE FROM temas WHERE id_foro='$this->id';";
        $this->db->multi_query($query);
        header('location: ?view=configforos&success=true');
    }

    function __toString(){

      return "<table> <tr>".
          "<td>".$this -> cedulaJuridica."</td>".
          "<td>".$this -> direccion."</td>".
          "<td>".$this -> telefono."</td>".
        "</tr> </table>";
    }

}

?>
