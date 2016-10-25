
<?php
  include_once "Data/Data.php";
  session_start();
  $mensaje = "";

  if(isset($_SESSION["cedula"])){
      if($_SESSION["tipoEmpleado"] == "e"){
          header("location: view/empleados/pagina_principal.php");
      }else{
          header("location: view/administracion/pagina_inicio.php");
      }
  }

  if(!empty($_POST)){
    $data = new Data();
    $conexion = $data->getConexion();
    if ($conexion->connect_error) {
      die("La conexion falló: " . $conexion->connect_error);
    }else{
      $user = $_POST["username"];
      $pass = $_POST["password"];
      $sql = "SELECT e.cedula as cedula, e.nombre as nombre, e.tipoEmpleado as tipoEmpleado, s.id as idSucursal, s.nombre as      nombreSucursal
              FROM empleado e
              LEFT JOIN sucursal s ON e.idSucursal = s.id
              WHERE e.nombre='$user' AND contrasenia = MD5('$pass');";

      $result = $conexion->query($sql);

      if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  $_SESSION["cedula"] = $row["cedula"];
                  $_SESSION["nombre"]= $row["nombre"];
                  $_SESSION["tipoEmpleado"] = $row["tipoEmpleado"];
                  $_SESSION["idSucursal"] = $row["idSucursal"];
                  $_SESSION["nombreSucursal"] = $row["nombreSucursal"];
                  if( $row["tipoEmpleado"] == "e"){
                    header("location: view/empleados/pagina_principal.php");
                  }else{
                    header("location: view/administracion/pagina_inicio.php");
                  }
              }
        $result->close();
        $conexion ->close();
      }else{
          $mensaje = "Usuario incorrecto";
      }
    }
  }
   
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Inicio</title>
  <link rel="stylesheet" type="text/css" href="css/Roboto/WebFont/roboto_regular_macroman/stylesheet.css">
  <link rel="stylesheet" href="css/estiloBarraNavegacion.css">
  <link rel="stylesheet" type="text/css" href="css/estilo_principal.css">
  <script type="text/javascript" src="js/jquery-1.12.3.js"></script>
  <script type="text/javascript" src="js/alertify/alertify.js"></script>
</head>
<body>
  <nav>
      <div class="logo-empresa">
       <img src="imagenes/coffee-icon.png">
       <a href="#">El Tostador</a>
    </div>
    <div class="mensaje-bienvenida">
      Bienvenido, debe de iniciar sesión.<p></p>
    </div>
  </nav>
  <div class="form-login">
    <form action="index.php" method="POST" name="frmLoginAdm" accept-charset="utf-8">
      <p>Formulario de acceso</p>
      <p class="mensajes"><?php echo $mensaje;?></p>
      <input type="text" class="inputShadow" name="username" placeholder="Usuario">
      <input type="password" class="inputShadow" name="password" minlength=4 placeholder="Contraseña">
      <input type="hidden" name="modo" value="login">
      <div class="layout-btns">
        <a href="#" id="bSubmitFrmLoginAdm" class="btn-submit">Ingresar</a>
        <a href="recuperarContraAdministrador.php" id="">Recuperar usuario</a>
      <div>
    </form>
  </div>
  <script type="text/javascript" src="js/funciones_generales.js"></script>
</body>
</html>