<?php

    class Venta{
    
    private $codigo;
    private $idSucursal;
    private $fechaHora;
    private $idEmpleado;
    private $impuestoVenta;
    private $subtotal;
    private $total;

    function __construct($codigo,$idSucursal,$fechaHora,$idEmpleado,$impuestoVenta, $subtotal, $total) {
        $this->codigo = $codigo; 
        $this->idSucursal = $idSucursal; 
        $this->fechaHora = $fechaHora; 
        $this->idEmpleado = $idEmpleado; 
        $this->impuestoVenta = $impuestoVenta;
        $this->subtotal = $subtotal;
        $this->total = $total;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getIdSucursal() {
        return $this->idSucursal;
    }

    public function getFechaHora() {
        return $this->fechaHora;
    }

    public function getIdEmpleado() {
        return $this->idEmpleado;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setIdSucursal($idSucursal) {
        $this->idSucursal = $idSucursal;
    }

    public function setFechaHora($fechaHora) {
        $this->fechaHora = $fechaHora;
    }

    public function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }

     public function setTotal($total) {
        $this->total = $total;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setSubtotal($total) {
        $this->subtotal = $subtotal;
    }

    public function getSubtotal() {
        return $this->subtotal;
    }

    public function setImpuestoVenta($impuestoVenta) {
        $this->impuestoVenta = $impuestoVenta;
    }

     public function getImpuestoVenta() {
        return $this->impuestoVenta;
    }
}

?>