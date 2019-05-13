
function init(){
 
    mostrarform(false);
    listar();
  
    //boton guardar
    $("#formulario").submit(function(e){
     //$("#btnGuardar").prop("disabled",true);

      var formData = new FormData($("#formulario")[0]);
        
     $.ajax({
        url:'http://localhost/sistemav/ajax/ingreso.php?op=guardaryeditar',
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

   //cargamos los items al select proveedor
   $.post('http://localhost/sistemav/ajax/ingreso.php?op=selectProveedor', function (response){
    //var resultado = JSON.parse(response);
    //$("#idproveedor").html(response);
   // $("#idproveedor").selectpicker("refresh");
    var resultado = JSON.parse(response);
      selectCategoria(resultado);
   });
  
  }//fin del init
  
  //funcion listar Articulos
  function listar(){
    $.ajax({
      url: 'http://localhost/sistemav/ajax/ingreso.php?op=listar',
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
        var ingreso = resultado[i]["estado"] == "Aceptado" ? 
        $(
          "<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idingreso"] +")'><i class='fa fa-eye'></i></button>"+
          " <button class='btn btn-danger' onclick='anular("+ resultado[i]["idingreso"] +")' ><i class='fa fa-close'></i></button></td>"
          ) 
        : 
        $(
          "<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idingreso"] +")'><i class='fa fa-eye'></i></button>"
         
          ) 
        ;
        
        var fecha = $("<td>" + resultado[i]["fecha"] + "</td>");
        var proveedor = $("<td>" + resultado[i]["proveedor"] + "</td>");
        var usuario = $("<td>" + resultado[i]["usuario"] + "</td>");
        var tipo_comprobante = $("<td>" + resultado[i]["tipo_comprobante"] + "</td>");
        var serie_comprobante = $("<td>" + resultado[i]["serie_comprobante"] + " - " + resultado[i]["num_comprobante"] +"</td>");
        var total_compra = $("<td>" + resultado[i]["total_compra"] + "</td>");
        var estado = resultado[i]["estado"] == "Aceptado" ? 
        $("<td><span class='label bg-green'>Aceptado</span></td>")
        : 
        $("<td><span class='label bg-red'>Anulado</span></td>");
        ;
        
        tr.append(ingreso);
        tr.append(fecha);
        tr.append(proveedor);
        tr.append(usuario);
        tr.append(tipo_comprobante);
        tr.append(serie_comprobante);
        tr.append(total_compra);
        tr.append(estado);
        tabla.append(tr);
        $("#tipo_comprobante").selectpicker('refresh');
    }
  };
  
  // funcion limpiar datos
  function limpiar(){
    $("#idproveedor").val("");
    $("#proveedor").val("");
    $("#serie_comprobante").val("");
    $("#num_comprobante").val("");
    $("#impuesto").val("0");

    //obtenemos la fecha actual
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day);
    $("#fecha_hora").val(today);

    //
    $("#tipo_comprobante").val("Boleta");
      $("#tipo_comprobante").selectpicker('refresh');

    $("#total_compra").val("");
    $(".filas").remove();
    $("#total").html("0");
  }
  
  //funcion mostrar formulario
  function mostrarform(flag){
  limpiar();
  if(flag){
      $("#listadoregistros").hide();
      $("#formularioregistros").show();
      //$("#btnGuardar").prop("disabled",false);
      $("#btnagregar").hide();
      listaractivos();

      
      $("#btnGuardar").hide();
      $("#btnCancelar").show();
      detalle=0;
      $("#btnAgregarArt").show();
      
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
  
  function mostrar(idingreso){
    //alert(idarticulo);
    $.post('http://localhost/sistemav/ajax/ingreso.php?op=mostrar',{idingreso : idingreso}, function (response,state){
      var resultado = JSON.parse(response);
      console.log(resultado);
      
     // ms = Date.parse(resultado[0]["fecha_hora"]);
//fecha = new Date(ms);
//alert(resultado.fecha_hora);
      mostrarform(true);
      $("#idproveedor").val(resultado[0]["idproveedor"]);
      $("#idproveedor").selectpicker('refresh');
      $("#tipo_comprobante").val(resultado[0]["tipo_comprobante"]);
      $("#tipo_comprobante").selectpicker('refresh');
      $("#serie_comprobante").val(resultado[0]["serie_comprobante"]);
      $("#num_comprobante").val(resultado[0]["num_comprobante"]);
      $("#fecha_hora").val(resultado[0]["fecha"]);
      $("#impuesto").val(resultado[0]["impuesto"]);
      $("#idingreso").val(resultado[0]["idingreso"]);

      //ocultar y mostrar los botones
      
      $("#btnGuardar").hide();
      $("#btnCancelar").show();
      $("#btnAgregarArt").hide();
      
      
  });
  ingresoDetalle(idingreso);    
  }
  
  //funcion desactivar
  function anular(idingreso){
    bootbox.confirm("¿Estas seguro de anular el ingreso?",function(resultado){
      if(resultado){
        $.post('http://localhost/sistemav/ajax/ingreso.php?op=anular',{idingreso : idingreso}, function (response){
          bootbox.alert(response);
          listar()
        });
      }
    })
  }
  
 //select categorias activas
 selectCategoria = function(resultado){
  var tabla = $("#idproveedor");
  $("#idproveedor").empty();
  for (let i = 0; i < resultado.length; i++) {
      //var idcategoria = $("<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idcategoria"] +")'><i class='fa fa-pencil'></i></button></td>");
      var categoria = $("<option value='" + resultado[i]["idpersona"] + "'>" + resultado[i]["nombre"] +"</option>");      
      tabla.append(categoria);
      
  }
};

//funcion listar Articulos Activos
function listaractivos(){
  $.ajax({
    url: 'http://localhost/sistemav/ajax/ingreso.php?op=listarArticulos',
    type: 'GET',
    success: function(response){
        
      var resultado = JSON.parse(response);
        mostrar_articulos(resultado);
    }
});//fin ajax mostrar
}//fin de listar Articulos

//mostrar datos de articulos Activos
mostrar_articulos = function(resultado){
  var tabla = $("#listararticulos");
  $("#listararticulos").empty();
  for (let i = 0; i < resultado.length; i++) {
    var parametros = [
       //id =resultado[i]["idarticulo"],
       // n=resultado[i]["nombre"]
    ]
    //n=resultado[i]["nombre"];
    //var art = n.toString();
     
      var tr = $("<tr></tr>");
      //var idcategoria = $("<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idcategoria"] +")'><i class='fa fa-pencil'></i></button></td>");
      var articulo =  $("<td><button class='btn btn-warning' onclick='agregardetalle("+resultado[i]["idarticulo"]+',"'+resultado[i]["nombre"]+'"'+")'><span class='fa fa-plus'></span></button>");
      //var articulo =  $( '<td><button class="btn btn-warning" onclick="agregardetalle("'+ resultado[i]["nombre"]+'")"><span class="fa fa-plus"></span></button></td>');
      var nombre = $("<td>" + resultado[i]["nombre"] + "</td>");
      var categoria = $("<td>" + resultado[i]["categoria"] + "</td>");
      var codigo = $("<td>" + resultado[i]["codigo"] + "</td>");
      var stock = $("<td>" + resultado[i]["stock"] + "</td>");
      var imagen = $("<td> <img src='../file/articulos/" + 
        resultado[i]["imagen"] + "' height='50px' width='50px'> </td>");
      
      
      tr.append(articulo);
      tr.append(nombre);
      tr.append(categoria);
      tr.append(codigo);
      tr.append(stock);
      tr.append(imagen);
      tabla.append(tr);
  }
};

//declaracion de variables necesarias para trabajar con las compras y sus detalles 
var impuesto = 18;
var cont = 0;
var detalles = 0;
//$("#guardar").hide();
$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);

function marcarImpuesto(){
  var tipo_comprobante = $("#tipo_comprobante option:selected").text();

    if(tipo_comprobante =="Factura"){
      $("#impuesto").val(impuesto);
    }else{
      $("#impuesto").val("0");
    }
}

function agregardetalle(idarticulo,articulo){
  var cantidad=1;
  var precio_compra=1;
  var precio_venta=1;
  //var art = articulo.toString();
  //alert(idarticulo);
  //alert(articulo);

  if(idarticulo !=""){
    //console.log(para.id);
     var subtotal = cantidad * precio_compra;
      var fila = '<tr class="filas" id="fila'+cont+'">'+
      '<td><button class="btn btn-danger" type="button" onclick="eliminardetalle('+cont+')">X</button></td>'+
      '<td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td>'+
      '<td><input type="number" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
      '<td><input type="number" name="precio_compra[]" id="precio_compra[]" value="'+precio_compra+'"></td>'+
      '<td><input type="number" name="precio_venta[]" id="precio_venta[]" value="'+precio_venta+'"></td>'+
      '<td><span name="subtotal" id="subtotal'+cont+'">'+subtotal+'</span></td>'+
      '<td><button class="btn btn-info" type="button" onclick="modificarSubtotales()"><i class="fa fa-refresh"></i></button></td>'+
      '</tr>';

      cont++;
      detalles=detalles+1;
      $("#detalles").append(fila);
      modificarSubtotales();

  }else{
    alert("Error al ingresar el tedalle, revise los datos del articulo");
  }
}

//funcion modificar subtotales
function modificarSubtotales(){
    var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precio_compra[]");
    var sub = document.getElementsByName("subtotal");
   // console.log(document.getElementsByName("cantidad[]"));
    
     for (var i = 0; i < cant.length; i++) {
     var inpC = cant[i];
      var inpP = prec[i];
      var inpS = sub[i];

      inpS.value = (inpC.value * inpP.value);
      //alert(inpP.value);
      document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
      
    }
    calcularTotales();
}
  
  function calcularTotales(){
    var sub = document.getElementsByName("subtotal");
    var total = 0.0;

    for ( i = 0; i < sub.length; i++){
      total += document.getElementsByName("subtotal")[i].value;
    }
    $("#total").html("S/. " + total);
    $("#total_compra").val(total);

    evaluar();
  }

  function evaluar(){
    if(detalles>0){
      $("#btnGuardar").show();
    }else{
      $("#btnGuardar").hide();
      cont=0;
    }
  }

  function eliminardetalle(indice){
    $("#fila" + indice).remove();
    calcularTotales();
    detalles=detalles-1;
    evaluar();
  }



  //funcion mostrar detalle ingreso
  function ingresoDetalle(idingreso){
    $.ajax({
      url: 'http://localhost/sistemav/ajax/ingreso.php?op=listarDetalle&id='+idingreso,
      type: 'GET',
      success: function(response){
          
        var resultado = JSON.parse(response);
          mostrar_ingresoDetalle(resultado);
      }
  });//fin ajax mostrar
  }//fin de listar Articulos
  
  //mostrar datos de articulos Activos
  mostrar_ingresoDetalle = function(resultado){
    var tabla = $("#detalless");
    var foot = $("#to");
    $("#detalless").empty();
    $total=0;
    for (let i = 0; i < resultado.length; i++) {
       
        var tr = $("<tr class='filas'></tr>");
        var opcion = $("<td></td>");
        //var idcategoria = $("<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idcategoria"] +")'><i class='fa fa-pencil'></i></button></td>");
        //var articulo =  $("<td><button class='btn btn-warning' onclick='agregardetalle("+resultado[i]["idarticulo"]+',"'+resultado[i]["nombre"]+'"'+")'><span class='fa fa-plus'></span></button>");
        //var articulo =  $( '<td><button class="btn btn-warning" onclick="agregardetalle("'+ resultado[i]["nombre"]+'")"><span class="fa fa-plus"></span></button></td>');
        var nombre = $("<td>" + resultado[i]["nombre"] + "</td>");
        var cantidad = $("<td>" + resultado[i]["cantidad"] + "</td>");
        var prec = $("<td>" + resultado[i]["precio_compra"] + "</td>");
        var prev = $("<td>" + resultado[i]["precio_venta"] + "</td>");
        var subtotal = resultado[i]["cantidad"] * resultado[i]["precio_compra"];
        var sub = $("<td>" + subtotal + "</td>");
        var total= (total + subtotal);
        alert(""+total+"");

        //var ci = $("<th><h4 id='total'>"+total+"</h4><input type='hidden' name='total_compra' id='total_compra'></th>");

        
        //$("#total").val(total);
        tr.append(opcion);
        tr.append(nombre);
        tr.append(cantidad);
        tr.append(prec);
        tr.append(prev);
        tr.append(sub);
        tabla.append(tr);
       // foot.append(ci);
        
    };
    
    /*  var foot = $("#to");
     $("#to").empty();
    var tota = $("<th>Total</th>");
    var u = $("<th></th>");
    var d = $("<th></th>");
    var t = $("<th></th>");
    var c = $("<th></th>");
    var ci = $("<th><h4 id='total'>"+total+"</h4><input type='hidden' name='total_compra' id='total_compra'></th>");
    
    tr.append(tota);
    tr.append(u);
    tr.append(d);
    tr.append(t);
    tr.append(c);
    tr.append(ci);
    foot.append(tr);
   
          */                         
    
    
  };

  init();