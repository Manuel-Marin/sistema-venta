
function init(){
 
    mostrarform(false);
    listar();
  
  }//fin del init
  
  //funcion listar categorias
  function listar(){
    $.ajax({
      url: 'http://localhost/sistemav/ajax/permiso.php?op=listar',
      type: 'GET',
      success: function(response){
          
        var resultado = JSON.parse(response);
       // console.log(resultado);
          mostrar_datos(resultado);
      }
  });//fin ajax mostrar
  }//fin de listar categorias
  
  mostrar_datos = function(resultado){
    var tabla = $("#listar");
    $("#listar").empty();
    for (let i = 0; i < resultado.length; i++) {
        var tr = $("<tr></tr>");
        //var idcategoria = $("<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idcategoria"] +")'><i class='fa fa-pencil'></i></button></td>");

        
        var nombre = $("<td>" + resultado[i]["nombre"] + "</td>");
        tr.append(nombre);
        tabla.append(tr);
    }
  };
  

  
  //funcion mostrar formulario
  function mostrarform(flag){
  //limpiar();
  if(flag){
      $("#listadoregistros").hide();
      $("#formularioregistros").show();
      $("#btnGuardar").prop("disabled",false);
      $("#btnagregar").hide();
  }else{
      $("#listadoregistros").show();
      $("#formularioregistros").hide();
      $("#btnagregar").hide();
  }
  }
  
  
  init();