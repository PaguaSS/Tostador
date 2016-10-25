<?php

  class Categoria
  {
    private $codigo;
    private $nombre;
    
    function __construct($codigo, $nombre){
      $this->codigo = $codigo;
      $this->nombre = $nombre;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setCodigo($codigoCategoria) {
        $this->codigo= $codigoCategoria;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }


    function __toString(){

      return "<table> <tr>".
          "<td>".$this->codigo."</td>".
          "<td>".$this->nombre."</td>".
        "</tr> </table>";
    }
}

?>
