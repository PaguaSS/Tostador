<?php

  include("core/Domain/Empleado.php");
  $conexion = new Data();
  $registro = mysqli_query($conexion,"SELECT * FROM empleado");

  include("view/modules/empleado.php");
  mysqli_close($conexion);
  
 ?>
