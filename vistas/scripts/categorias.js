$(function(){
    //listar()
    alert("hola");
    //funcion listar 
function listar(){
    $.ajax({
      url: 'http://localhost/sistemav/ajax/ca.php',
      type: 'GET',
      success: function(response){
          alert(response);
        //var resultado = JSON.parse(response);
         // mostrar_datos(resultado);
      }
  });//fin ajax mostrar
  }//fin de mostrar tareas
});

//limpiar formulario
function limpiar(){
    $("#idcategoria").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
}

//mostrar formulario
function mostrarform(flag){
    limpiar();
    if(flag){
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnguardar").prop("disabled",false);
    }else{
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnguardar").prop("disabled",true);
    }
}

//funcion cancelar formulario
function cancelarform(){
    limpiar();
    mostrarform(false);
}

//funcion mostrar datos
mostrar_datos = function(resultado){
    var tabla = $("#listarcat");
    for (let i = 0; i < resultado.length; i++) {
        var tr = $("<tr></tr>");
        var idcategoria = $("<td>" + resultado[i]["idcategoria"] + "</td>");
        var nombre = $("<td>" + resultado[i]["nombre"] + "</td>");
        var descripcion = $("<td>" + resultado[i]["descripcion"] + "</td>");
        var condicion = $("<td>" + resultado[i]["condicion"] + "</td>");
        
        tr.append(idcategoria);
        tr.append(nombre);
        tr.append(descripcion);
        tr.append(condicion);
        tabla.append(tr);
    }
};



