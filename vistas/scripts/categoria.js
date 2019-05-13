
function init(){
 
  mostrarform(false);
  listar();

  //boton guardar
  $("#formulario").submit(function(e){
    $("#btnGuardar").prop("disabled",true);
    console.log($("#idcategoria").val());
    
    const postData = {
      idcategoria: $("#idcategoria").val(),
      nombre: $("#nombre").val(),
      descripcion: $("#descripcion").val()  
    }
    
    $.post('http://localhost/sistemav/ajax/ca.php?op=guardaryeditar', postData, function (response){
      //console.log(response);
      bootbox.alert(response);
      mostrarform(false);
      listar()
    });// fin post
    e.preventDefault();
  });

}//fin del init

//funcion listar categorias
function listar(){
  $.ajax({
    url: 'http://localhost/sistemav/ajax/ca.php?op=listar',
    type: 'GET',
    success: function(response){
        
      var resultado = JSON.parse(response);
     // console.log(resultado);
        mostrar_datos(resultado);
    }
});//fin ajax mostrar
}//fin de listar categorias

mostrar_datos = function(resultado){
  var tabla = $("#listarcat");
  $("#listarcat").empty();
  for (let i = 0; i < resultado.length; i++) {
      var tr = $("<tr></tr>");
      //var idcategoria = $("<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idcategoria"] +")'><i class='fa fa-pencil'></i></button></td>");
      var idcategoria = resultado[i]["condicion"] == 1 ? 
      $(
        "<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idcategoria"] +")'><i class='fa fa-pencil'></i></button>"+
        " <button class='btn btn-danger' onclick='desactivar("+ resultado[i]["idcategoria"] +")' ><i class='fa fa-close'></i></button></td>"
        ) 
      : 
      $(
        "<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idcategoria"] +")'><i class='fa fa-pencil'></i></button>"+
        " <button class='btn btn-primary' onclick='activar("+ resultado[i]["idcategoria"] +")' ><i class='fa fa-check'></i></button></td>"
        ) 
      ;
      
      var nombre = $("<td>" + resultado[i]["nombre"] + "</td>");
      var descripcion = $("<td>" + resultado[i]["descripcion"] + "</td>");
      var condicion = resultado[i]["condicion"] == 1 ? 
      $("<td><span class='label bg-green'>Activado</span></td>")
      : 
      $("<td><span class='label bg-red'>Desactivado</span></td>");
      ;
      
      tr.append(idcategoria);
      tr.append(nombre);
      tr.append(descripcion);
      tr.append(condicion);
      tabla.append(tr);
  }
};

// funcion limpiar datos
function limpiar(){
  $("#idcategoria").val("");
  $("#nombre").val("");
  $("#descripcion").val("");
}

//funcion mostrar formulario
function mostrarform(flag){
limpiar();
if(flag){
    $("#listadoregistros").hide();
    $("#formularioregistros").show();
    $("#btnGuardar").prop("disabled",false);
    $("#btnagregar").hide();
}else{
    $("#listadoregistros").show();
    $("#formularioregistros").hide();
    $("#btnagregar").show();
}
}

//funcion cancelar formulario
function cancelarform(){
limpiar();
mostrarform(false);
}

//funcion mostrar

function mostrar(idcategoria){
  //console.log(idcategoria);
  $.post('http://localhost/sistemav/ajax/ca.php?op=mostrar',{idcategoria : idcategoria}, function (response){
    var resultado = JSON.parse(response);
    //console.log(resultado);
    mostrarform(true);
    $("#nombre").val(resultado[0]["nombre"]);
    $("#descripcion").val(resultado[0]["descripcion"]);
    $("#idcategoria").val(resultado[0]["idcategoria"]);
    
  })    
}

//funcion desactivar
function desactivar(idcategoria){
  bootbox.confirm("¿Estas seguro de desactivar la categoria?",function(resultado){
    if(resultado){
      $.post('http://localhost/sistemav/ajax/ca.php?op=desactivar',{idcategoria : idcategoria}, function (response){
        bootbox.alert(response);
        listar()
      });
    }
  })
}

//funcion activar
function activar(idcategoria){
  bootbox.confirm("¿Estas seguro de activar la categoria?",function(resultado){
    if(resultado){
      $.post('http://localhost/sistemav/ajax/ca.php?op=activar',{idcategoria : idcategoria}, function (response){
        bootbox.alert(response);
        listar()
      });
    }
  })
}




init();