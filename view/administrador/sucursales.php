<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Sucursales</title>
    <link rel="stylesheet" href="view/css/tables.css" media="screen" title="no title">
  </head>
  <body>
    <table id="tablaListaSucursal">
      <tbody>
        <th>Cédula Jurídica</th>
        <th>Nombre</th>
        <th>Dirección</th>
        <th>Teléfono</th>
        <th>Disponible</th>
        <?php
          while ($reg=mysqli_fetch_array($registros))
          {
            echo "<tr>";
            echo "<td>".$reg['nombre']."</td>";
            echo "<td>".$reg['direccion']."</td>";
            echo "<td>".$reg['telefono']."</td>";
            echo "<td>".$reg['disponible']."</td>";
            echo "</tr>";

          }
        ?>
      </tbody>
    </table>
  </body>
</html>
