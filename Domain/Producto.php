<?php

  class Producto
  {
    private $codigo;
    private $nombre;
    private $stock;
    private $precio;
    private $unidadMedida;
    private $proveedor;
    private $tamanio;
    private $idSucursal;
    private $idCategoria;
    private $abreviatura;
    
    function __construct($codigo,$nombre,$stock,$precio,$unidadMedida,$proveedor,$tamanio,$idSucursal,$idCategoria, $abreviatura){
        $this->codigo=$codigo;
        $this->nombre=$nombre;
        $this->stock=$stock;
        $this->precio=$precio;
        $this->unidadMedida=$unidadMedida;
        $this->proveedor=$proveedor;
        $this->idSucursal=$idSucursal;
        $this->idCategoria=$idCategoria;
        $this->abreviatura=$abreviatura;
        $this->tamanio = $tamanio;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getUnidadMedida() {
        return $this->unidadMedida;
    }

    public function getProveedor() {
        return $this->proveedor;
    }

    public function getIdSucursal() {
        return $this->idSucursal;
    }

    public function getIdCategoria() {
        return $this->idCategoria;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

   public function setUnidadMedida($unidadMedida) {
        $this->unidadMedida = $unidadMedida;
    }

    public function setProveedor($proveedor) {
        $this->proveedor = $proveedor;
    }

    public function setIdSucursal($idSucursal) {
        $this->idSucursal = $idSucursal;
    }

    public function setIdCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
    }

        
    public function getCodigoProducto() {
        return $this->codigo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getStock() {
        return $this->stock;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setCodigoProducto($codigo) {
        $this->codigo = $codigo;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setStock($stock) {
        $this->stock = $stock;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }
    public function setAbreviatura($abreviatura){
        $this->abreviatura=$abreviatura;
    }
    public function getAbreviatura(){
        return $this->abreviatura;
    }

    public function setTamanio($tamanio){
        $this->tamanio = $tamanio;
    }

    public function getTamanio(){
        return $this->tamanio;
    }

    function __toString(){

      return "<table> <tr>".
          "<td>".$this ->codigo."</td>".
          "<td>".$this ->nombre."</td>".
          "<td>".$this ->stock."</td>".
          "<td>".$this ->precio."</td>".
        "</tr> </table>";
    }

}

?>
