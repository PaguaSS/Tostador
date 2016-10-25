<?php
    session_start();
    if(!isset($_SESSION["cedula"])){
      header("location: ../../../../../index.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../../css/estiloBarraNavegacion.css">
        <script type="text/javascript" src="../../js/jquery-3.1.0.js"></script>
        <script type="text/javascript" src="../../js/sticky_nav_bar.js"></script>
        <link rel="stylesheet" href="../../js/alertify/css/alertify.css">
        <link rel="stylesheet" href="../../js/alertify/css/themes/default.css">
        <script type="text/javascript" src="../../js/alertify/alertify.js"></script>
        
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    </head>
    <body>
        <nav class="menu-static">
            <div class="logo-empresa">
                <input type="hidden" id="nomSucursal" value="<?php echo $_SESSION["nombreSucursal"];?>">
                <input type="hidden" id="nomEmpleado" value="<?php echo $_SESSION["nombre"];?>">
                <input type="hidden" id="cedulaEmpleado" value="<?php echo $_SESSION["cedula"];?>">
                <a href="#">Tostador <?php echo $_SESSION["nombreSucursal"];?></a>
            </div>
            <div class="opciones">
                <ul>
                    <li><a href="caja" class="opBarNav"><span class="icon-shopping-cart icono-flat"></span>Caja</a></li>
                    <li><a href="invent" class="opBarNav"><span class="icon-clipboard icono-flat"></span>Inventario</a></li>
                    <li><a href="pedido" class="opBarNav"><span class="icon-truck icono-flat"></span>Pedidos</a></li>
                    <li><a href="opUsuario" class="opBarNav"><span class="icon-address-book icono-flat"></span><?php echo $_SESSION["nombre"];?></a>
                        <ul>
                            <li><a href="#">Cambiar contraseña</a></li>
                            <li><a href="../../Business/logout.php">Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <script type="text/javascript" src="../../js/funciones_generales.js"></script>
    </body>

</html>