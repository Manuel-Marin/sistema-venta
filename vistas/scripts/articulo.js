
function init(){
 
    mostrarform(false);
    listar();
  
    //boton guardar
    $("#formulario").submit(function(e){
      $("#btnGuardar").prop("disabled",true);
    
      var formData = new FormData($("#formulario")[0]);
 
      $.ajax({
        url:'http://localhost/sistemav/ajax/articulo.php?op=guardaryeditar',
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

    //cargar los items del select categorias
    $.post('http://localhost/sistemav/ajax/articulo.php?op=selectCategorias', function (response){
      var resultado = JSON.parse(response);
      selectCategoria(resultado);
    })
    
    $("#imagenmuestra").hide();
  
  }//fin del init
  
  //funcion listar Articulos
  function listar(){
    $.ajax({
      url: 'http://localhost/sistemav/ajax/articulo.php?op=listar',
      type: 'GET',
      success: function(response){
          
        var resultado = JSON.parse(response);
          mostrar_datos(resultado);
      }
  });//fin ajax mostrar
  }//fin de listar Articulos
  
  //mostrar datos en la tabla
  mostrar_datos = function(resultado){
    var tabla = $("#listarart");
    $("#listarart").empty();
    for (let i = 0; i < resultado.length; i++) {
        var tr = $("<tr></tr>");
        //var idcategoria = $("<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idcategoria"] +")'><i class='fa fa-pencil'></i></button></td>");
        var idarticulo = resultado[i]["condicion"] == 1 ? 
        $(
          "<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idarticulo"] +")'><i class='fa fa-pencil'></i></button>"+
          " <button class='btn btn-danger' onclick='desactivar("+ resultado[i]["idarticulo"] +")' ><i class='fa fa-close'></i></button></td>"
          ) 
        : 
        $(
          "<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idarticulo"] +")'><i class='fa fa-pencil'></i></button>"+
          " <button class='btn btn-primary' onclick='activar("+ resultado[i]["idarticulo"] +")' ><i class='fa fa-check'></i></button></td>"
          ) 
        ;
        
        var nombre = $("<td>" + resultado[i]["nombre"] + "</td>");
        var categoria = $("<td>" + resultado[i]["categoria"] + "</td>");
        var codigo = $("<td>" + resultado[i]["codigo"] + "</td>");
        var stock = $("<td>" + resultado[i]["stock"] + "</td>");
       // var imagen = $("<td>" + resultado[i]["stock"] + "</td>");
        var imagen = $("<td> <img src='../file/articulos/" + 
        resultado[i]["imagen"] + "' height='50px' width='50px'> </td>");
        var condicion = resultado[i]["condicion"] == 1 ? 
        $("<td><span class='label bg-green'>Activado</span></td>")
        : 
        $("<td><span class='label bg-red'>Desactivado</span></td>");
        ;
        
        tr.append(idarticulo);
        tr.append(nombre);
        tr.append(categoria);
        tr.append(codigo);
        tr.append(stock);
        tr.append(imagen);
        tr.append(condicion);
        tabla.append(tr);
    }
  };
  
  // funcion limpiar datos
  function limpiar(){
    $("#codigo").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
    $("#stock").val("");
    $("#imagenmuestra").attr("src","");
    $("#imagenactual").val("");
    $("#print").hide();
    $("#idarticulo").val("");
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
  
  function mostrar(idarticulo){
    //alert(idarticulo);
    $.post('http://localhost/sistemav/ajax/articulo.php?op=mostrar',{idarticulo : idarticulo}, function (response){
      var resultado = JSON.parse(response);
      console.log(resultado);
      //alert(response);
      mostrarform(true);
      $("#idcategoria").val(resultado[0]["idcategoria"]);
     $("#idcategoria").selectpicker('refresh');
      $("#codigo").val(resultado[0]["codigo"]);
      $("#nombre").val(resultado[0]["nombre"]);
      $("#stock").val(resultado[0]["stock"]);
      $("#descripcion").val(resultado[0]["descripcion"]);
      $("#imagenmuestra").show();
      $("#imagenmuestra").attr("src","../file/articulos/" + resultado[0]["imagen"]);
      $("#imagenactual").val(resultado[0]["imagen"]);
      $("#idarticulo").val(resultado[0]["idarticulo"]);
      generarbarcode()
      
  })    
  }
  
  //funcion desactivar
  function desactivar(idarticulo){
    bootbox.confirm("¿Estas seguro de desactivar el Articulo?",function(resultado){
      if(resultado){
        $.post('http://localhost/sistemav/ajax/articulo.php?op=desactivar',{idarticulo : idarticulo}, function (response){
          bootbox.alert(response);
          listar()
        });
      }
    })
  }
  
  //funcion activar
  function activar(idarticulo){
    bootbox.confirm("¿Estas seguro de activar el Articulo?",function(resultado){
      if(resultado){
        $.post('http://localhost/sistemav/ajax/articulo.php?op=activar',{idarticulo : idarticulo}, function (response){
          bootbox.alert(response);
          listar()
        });
      }
    })
  }

//select categorias activas
  selectCategoria = function(resultado){
    var tabla = $("#idcategoria");
    $("#idcategoria").empty();
    for (let i = 0; i < resultado.length; i++) {
        //var idcategoria = $("<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idcategoria"] +")'><i class='fa fa-pencil'></i></button></td>");
        var categoria = $("<option value='" + resultado[i]["idcategoria"] + "'>" + resultado[i]["nombre"] +"</option>");      
        tabla.append(categoria);
        
    }
  };
  
  //funcion para generar codigo de barras
  function generarbarcode(){
    codigo = $("#codigo").val();
    JsBarcode("#barcode", codigo);
    $("#print").show();
  }

  //funcion para imprimir el codigo de barra
  function imprimir(){
    $("#print").PrintArea();
  }
  
  
  init();