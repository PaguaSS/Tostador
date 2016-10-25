
$(document).ready(function() {
    $(".012").click(function (e) {

      e.preventDefault();
      listaSucursales(this.getAttribute("href"));
    });
    $(".btnEditSucr").click(function (e) {
      e.preventDefault();
      formEditarSucursal(this.getAttribute("href"));
    });
    $(".editarSucursal").click(function (e) {
      e.preventDefault();
      editarSucursal(this.getAttribute("href"));
    });
});

function listaSucursales(accion){
  var capa = document.getElementById("contenedor");
  document.getElementById("contenedor").innerHTML = "Cargando...";
  $(capa).load("?clase=sucursalController&&accion="+accion);
}

function formEditarSucursal(accion){
  var capa = document.getElementById("contenedorLista");
  document.getElementById("contenedorLista").innerHTML = "Cargando...";
  $(capa).load("?clase=sucursalController&accion="+accion);

}

function editarSucursal(codigo){

    var capa = document.getElementById("contenedorLista");
    var nombre=document.getElementsByName("nombre")[0].value;
    var direccion=document.getElementsById("direccion").value;
    var telefono=document.getElementsByName("telefono")[0].value;
    alert("Dir: "+direccion);
    document.getElementById("contenedorLista").innerHTML = " Registro Editado Exitosamente!";
    $(capa).load("?clase=sucursalController&accion=editarSucursal&codigo="+codigo+"&nombre="+nombre+"&direccion="+direccion+"&telefono="+telefono);
}
