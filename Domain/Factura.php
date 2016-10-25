<?php


  class Factura
  {
    private $codigoFactura;
    private $fecha;
    private $montoFinal;
    private $descuento; //double
    private $productos; //Este debe contener una lista de productos

    function __construct($codigoFactura, $fecha, $montoFinal, $descuento, $productos)
    {
      $this -> codigoFactura = $codigoFactura;
      $this -> fecha = $fecha;
      $this -> montoFinal = $montoFinal;
      $this -> descuento = $descuento;
      $this -> productos = $productos;
    }

    function __toString(){

      return "<table> <tr>".
          "<td>".$this -> codigoFactura."</td>".
          "<td>".$this -> fecha."</td>".
          "<td>".$this -> montoFinal."</td>".
          "<td>".$this -> descuento."</td>".
          "<td>".$this -> productos."</td>".
        "</tr> </table>";
    }

}

?>
