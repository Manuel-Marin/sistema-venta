
function init(){
 
    mostrarform(false);
    listar();
    //permisos();
  
    //boton guardar
    $("#formulario").submit(function(e){
      $("#btnGuardar").prop("disabled",true);
      //limpiar();
      var formData = new FormData($("#formulario")[0]);
 
      $.ajax({
        url:'http://localhost/sistemav/ajax/usuario.php?op=guardaryeditar',
        type: 'POST',
        data: formData,
        contentType:false,
        processData:false,

        success: function(response){
         console.log(response);
          bootbox.alert(response);
          mostrarform(false);
          listar()
        }
      });
      e.preventDefault();
    });


    
    $("#imagenmuestra").hide();

    $.post('http://localhost/sistemav/ajax/usuario.php?op=permiso&id=', function (response){
     // var resultado = JSON.parse(response);
         // mostrar_permisos(resultado);
         $("#permisos").html(response);
    });
  
  }//fin del init
  
  //funcion listar Articulos
  function listar(){
    $.ajax({
      url: 'http://localhost/sistemav/ajax/usuario.php?op=listar',
      type: 'GET',
      success: function(response){
          
        var resultado = JSON.parse(response);
          mostrar_datos(resultado);
      }
  });//fin ajax mostrar
  }//fin de listar Articulos
  
  //mostrar datos en la tabla
  mostrar_datos = function(resultado){
    var tabla = $("#listar");
    $("#listar").empty();
    for (let i = 0; i < resultado.length; i++) {
        var tr = $("<tr></tr>");
        //var idcategoria = $("<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idcategoria"] +")'><i class='fa fa-pencil'></i></button></td>");
        var idusuario = resultado[i]["condicion"] == 1 ? 
        $(
          "<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idusuario"] +")'><i class='fa fa-pencil'></i></button>"+
          " <button class='btn btn-danger' onclick='desactivar("+ resultado[i]["idusuario"] +")' ><i class='fa fa-close'></i></button></td>"
          ) 
        : 
        $(
          "<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idusuario"] +")'><i class='fa fa-pencil'></i></button>"+
          " <button class='btn btn-primary' onclick='activar("+ resultado[i]["idusuario"] +")' ><i class='fa fa-check'></i></button></td>"
          ) 
        ;
        
        var nombre = $("<td>" + resultado[i]["nombre"] + "</td>");
        var tipo_documento = $("<td>" + resultado[i]["tipo_documento"] + "</td>");
        var num_documento = $("<td>" + resultado[i]["num_documento"] + "</td>");
        var telefono = $("<td>" + resultado[i]["telefono"] + "</td>");
        var email = $("<td>" + resultado[i]["email"] + "</td>");
        var login = $("<td>" + resultado[i]["login"] + "</td>");
       // var imagen = $("<td>" + resultado[i]["stock"] + "</td>");
        var imagen = $("<td> <img src='../file/usuarios/" + 
        resultado[i]["imagen"] + "' height='50px' width='50px'> </td>");
        var condicion = resultado[i]["condicion"] == 1 ? 
        $("<td><span class='label bg-green'>Activado</span></td>")
        : 
        $("<td><span class='label bg-red'>Desactivado</span></td>");
        ;
        
        tr.append(idusuario);
        tr.append(nombre);
        tr.append(tipo_documento);
        tr.append(num_documento);
        tr.append(telefono);
        tr.append(email);
        tr.append(login);
        tr.append(imagen);
        tr.append(condicion);
        tabla.append(tr);
    }
  };
  
  // funcion limpiar datos
  function limpiar(){
    
    $("#nombre").val("");
    $("#num_documento").val("");
    $("#direccion").val(""); 
    $("#telefono").val("");
    $("#email").val();
    $("#cargo").val("");
    $("#login").val("");
    $("#clave").val("");
    $("#imagenmuestra").attr("src","");
    $("#imagenactual").val("");
    $("#idusuario").val("");
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
  
  function mostrar(idusuario){
    //alert(idarticulo);
    $.post('http://localhost/sistemav/ajax/usuario.php?op=mostrar',{idusuario : idusuario}, function (response){
      var resultado = JSON.parse(response);
      console.log(resultado);
      //alert(response);
      mostrarform(true);
     
      $("#nombre").val(resultado[0]["nombre"]);
      $("#tipo_documento").val(resultado[0]["tipo_documento"]);
      $("#tipo_documento").selectpicker('refresh');
      $("#num_documento").val(resultado[0]["num_documento"]);
      $("#direccion").val(resultado[0]["direccion"]);
      $("#telefono").val(resultado[0]["telefono"]);
      $("#email").val(resultado[0]["email"]);
      $("#cargo").val(resultado[0]["cargo"]);
      $("#login").val(resultado[0]["login"]);
      $("#clave").val(resultado[0]["clave"]);
      $("#imagenmuestra").show();
      $("#imagenmuestra").attr("src","../file/usuarios/" + resultado[0]["imagen"]);
      $("#imagenactual").val(resultado[0]["imagen"]);
      $("#idusuario").val(resultado[0]["idusuario"]);
      
  });
  
  $.post('http://localhost/sistemav/ajax/usuario.php?op=permiso&id='+idusuario, function (response){
    $("#permisos").html(response);
          //mostrar_permisos(resultado);
    });  
  }
  
  //funcion desactivar
  function desactivar(idusuario){
    bootbox.confirm("¿Estas seguro de desactivar al Uusario?",function(resultado){
      if(resultado){
        $.post('http://localhost/sistemav/ajax/usuario.php?op=desactivar',{idusuario : idusuario}, function (response){
          bootbox.alert(response);
          listar()
        });
      }
    })
  }
  
  //funcion activar
  function activar(idusuario){
    bootbox.confirm("¿Estas seguro de activar al Usuario?",function(resultado){
      if(resultado){
        $.post('http://localhost/sistemav/ajax/usuario.php?op=activar',{idusuario : idusuario}, function (response){
          bootbox.alert(response);
          listar()
        });
      }
    })
  }

  //Funcion Permisos
  function permisos(){
    //mostrar permisos
    $.post('http://localhost/sistemav/ajax/usuario.php?op=permiso2&id=', function (response){
      var resultado = JSON.parse(response);
          mostrar_permisos(resultado,);
    });
  }
 
  mostrar_permisos = function(resultado,marcados){
    var tabla = $("#permisos");
    $("#permisos").empty();
    for (let i = 0; i < resultado.length; i++) {
        //var idcategoria = $("<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idcategoria"] +")'><i class='fa fa-pencil'></i></button></td>");
        $sw = in_array(resultado[i]["idpermiso"],marcados[i]["idpermiso"])?"checked":"";
        var permisos = $("<li><input type='checkbox'"+ $sw+ " name='permiso[]' value='" + resultado[i]["idpermiso"] + "'>" + resultado[i]["nombre"]+"</li>");
        tabla.append(permisos);
    }
  };


  
  
  init();