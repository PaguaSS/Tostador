/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function(){
    $('.run').click(function(event){
        var alert = alertify.alert('Alerta en espanol!');
        alert.set('label','ok');
        alert.show();
    });
});

$(function(){
   $('.run3').click(function(event){
       
        alertify.confirm('Confirm Title', 'Desea confirmar la venta?', function () {
            alertify.success('Se ha realizado la venta correctamente')
            $("#formVenta").submit();
        }
        , function () {
            alertify.error('Se ha cancelado la venta')
        });
       
       
       
       alert.show();
       $(this.form).submit();
       
   }) 
});

$(function(){
   $('.run2').click(function(event){
       var alert = alertify.alert('Desea confirmar la venta');
       alert.set({labels: {
                ok: "Yes",
                cancel: "No"
            }});
       alert.set('onok',function(){
          alertify.success('Se ha realizado la venta correctamente.'); 
       });
       alert.set('oncancel',function(){
           alertify.error('Se cancelo la venta');
       });
       alert.show();
   });
});

$(function(){
   $('.alerta1').click(function(event){
       
        alertify.confirm('Confirm Title', 'Desea insertar el producto', function () {
            alertify.success('Se ha realizado la inserción del procucto exitosamente');
            $("#fproductos").submit();
        }
        , function () {
            alertify.error('Se ha cancelado la inserción')
        });
       
       
       
       alert.show();
       
   }) 
});