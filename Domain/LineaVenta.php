<?php

    class LineaVenta{
        
        private $idDetalle;
        private $codigoVenta;
        private $codigoProducto;
        private $cantidad;
        private $totalLinea;
        
        function __construct($idDetalle, $codigoVenta, $codigoProducto, $cantidad, $totalLinea) {
            $this->$idDetalle = $idDetalle;
            $this->$codigoVenta = $codigoVenta;
            $this->$codigoProducto = $codigoProducto;
            $this->$cantidad = $cantidad;
            $this->$totalLinea = $totalLinea;
        }

        public function getIdDetalle() {
            return $this->idDetalle;
        }

        public function getCodigoVenta() {
            return $this->codigoVenta;
        }

        public function getCodigoProducto() {
            return $this->codigoProducto;
        }

        public function getCantidad() {
            return $this->cantidad;
        }

        public function getTotalLinea() {
            return $this->totalLinea;
        }

        public function setIdDetalle($idDetalle) {
            $this->idDetalle = $idDetalle;
        }

        public function setCodigoVenta($codigoVenta) {
            $this->codigoVenta = $codigoVenta;
        }

        public function setCodigoProducto($codigoProducto) {
            $this->codigoProducto = $codigoProducto;
        }

        public function setCantidad($cantidad) {
            $this->cantidad = $cantidad;
        }

        public function setTotalLinea($totalLinea) {
            $this->totalLinea = $totalLinea;
        }
    }
?>