
function init(){
 
    mostrarform(false);
    listar();
  
    
//boton guardar
$("#formulario").submit(function(e){
    $("#btnGuardar").prop("disabled",true);
  
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
      url:'http://localhost/sistemav/ajax/persona.php?op=guardaryeditar',
      type: 'POST',
      data: formData,
      contentType:false,
      processData:false,

      success: function(response){
       // console.log(response);
        bootbox.alert(response);
        mostrarform(false);
        listar()
      }
    });
    e.preventDefault();
  });
  
  }//fin del init
  
  //funcion listar categorias
  function listar(){
    $.ajax({
      url: 'http://localhost/sistemav/ajax/persona.php?op=listarc',
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
        var opcion =  
        $(
          "<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idpersona"] +")'><i class='fa fa-pencil'></i></button>"+
          " <button class='btn btn-danger' onclick='eliminar("+ resultado[i]["idpersona"] +")' ><i class='fa fa-trash'></i></button></td>"
          );
        
        var nombre = $("<td>" + resultado[i]["nombre"] + "</td>");
        var tipo_documento = $("<td>" + resultado[i]["tipo_documento"] + "</td>");
        var num_documento = $("<td>" + resultado[i]["num_documento"] + "</td>");
        var telefono = $("<td>" + resultado[i]["telefono"] + "</td>");
        var email = $("<td>" + resultado[i]["email"] + "</td>");
      
        
        tr.append(opcion);
        tr.append(nombre);
        tr.append(tipo_documento);
        tr.append(num_documento);
        tr.append(telefono);
        tr.append(email);
        tabla.append(tr);
    }
  };
  
  // funcion limpiar datos
  function limpiar(){
    $("#idpersona").val("");
    $("#nombre").val("");
    $("#num_documento").val("");
    $("#direccion").val("");
    $("#telefono").val("");
    $("#email").val("");
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
  
  function mostrar(idpersona){
    //console.log(idcategoria);
    $.post('http://localhost/sistemav/ajax/persona.php?op=mostrar',{idpersona : idpersona}, function (response){
      var resultado = JSON.parse(response);
      //console.log(resultado);
      mostrarform(true);
      $("#nombre").val(resultado[0]["nombre"]);
      $("#tipo_documento").val(resultado[0]["tipo_documento"]);
      $("#tipo_documento").selectpicker('refresh');
      $("#num_documento").val(resultado[0]["num_documento"]);
      $("#direccion").val(resultado[0]["direccion"]);
      $("#telefono").val(resultado[0]["telefono"]);
      $("#email").val(resultado[0]["email"]);
      $("#idpersona").val(resultado[0]["idpersona"]);
      
    })    
  }
  
  //funcion desactivar
  function eliminar(idpersona){
    bootbox.confirm("¿Estas seguro de eliminar el Cliente?",function(resultado){
      if(resultado){
        $.post('http://localhost/sistemav/ajax/persona.php?op=eliminar',{idpersona : idpersona}, function (response){
          bootbox.alert(response);
          listar()
        });
      }
    })
  }
  

  
  
  
  
  init();