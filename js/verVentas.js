/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



function borrar(e){
    var tr = e.parentNode.parentNode;
    var papa = document.getElementById(tr.getAttribute('id'));
    papa.remove();
}


function getValueComboToInput(e) {

    var eId = e.id;
    var vector = eId.split("");
    var numero = vector[vector.length - 1];

    var combo = document.getElementById("comboProductos" + numero);
    var value = combo.options[combo.selectedIndex].value;
    var text = combo.options[combo.selectedIndex].innerHTML;
    var hidden = document.getElementById("hidden" + numero);
    var input = document.getElementById("codigoProducto" + numero);
    input.value = value;
    hidden.value = text;

}

function sumaTotal() {
    //window.alert('entro');
    var divPops = document.getElementById("detalle"); //Obtiene le padre del div
    hijos = divPops.childNodes;
    var cantidadLineas = hijos.length - 2;
    var suma = 0;
    suma = parseInt(suma);
    for (j = 1; j < cantidadLineas; j++) {
        var numero = parseInt(document.getElementById("total" + j).value);
        suma = suma + numero;
        //window.alert(document.getElementById("precio"+j).value);
    }

    document.getElementById("sumatotal").value = suma;
}