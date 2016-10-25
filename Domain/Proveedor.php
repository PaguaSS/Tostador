<?php

class Proveedor {

    private $cedula;
    private $cedulaProveedor;
    private $nombre;
    private $telefono;
    private $productos; //Este debe contener una lista de productos

    function Proveeedor($cedulaProveedor, $nombre, $telefono, $productos) {
        $this->cedulaProveedor = $cedulaProveedor;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->productos = $productos;
    }

    function Proveedor() {
        
        
    }

    function __toString() {

        return "<table> <tr>" .
                "<td>" . $this->cedulaProveedor . "</td>" .
                "<td>" . $this->nombre . "</td>" .
                "<td>" . $this->telefono . "</td>" .
                "<td>" . $this->productos . "</td>" .
                "</tr> </table>";
    }
    
    function getCedulaProveedor() {
        return $this->cedulaProveedor;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getProductos() {
        return $this->productos;
    }

    function setCedulaProveedor($cedulaProveedor) {
        $this->cedulaProveedor = $cedulaProveedor;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setProductos($productos) {
        $this->productos = $productos;
    }



}

?>
