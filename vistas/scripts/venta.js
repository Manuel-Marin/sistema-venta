function init(){
 
    mostrarform(false);
    listar();
  
    
//boton guardar
$("#formulario").submit(function(e){
    $("#btnGuardar").prop("disabled",true);
  
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
      url:'http://localhost/sistemav/ajax/venta.php?op=guardaryeditar',
      type: 'POST',
      data: formData,
      contentType:false,
      processData:false,

      success: function(response){
       // console.log(response);
        bootbox.alert(response);
        //mostrarform(false);
        //listar()
      }
    });
    e.preventDefault();
  });

    //cargamos los items al select proveedor
    $.post('http://localhost/sistemav/ajax/venta.php?op=selectCliente', function (response){
        var resultado = JSON.parse(response);
          selectCategoria(resultado);
       });

  }//fin del init

  //funcion listar categorias
  function listar(){
    $.ajax({
      url: 'http://localhost/sistemav/ajax/venta.php?op=listar',
      type: 'GET',
      success: function(response){
          
        var resultado = JSON.parse(response);
       // console.log(resultado);
          mostrar_dato(resultado);
      }
  });//fin ajax mostrar
  }//fin de listar categorias
  
  mostrar_dato = function(resultado){
    var tabla = $("#listarart");
    $("#listarart").empty();
    for (let i = 0; i < resultado.length; i++) {
        var tr = $("<tr></tr>");
        //var idcategoria = $("<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idcategoria"] +")'><i class='fa fa-pencil'></i></button></td>");
        var ingreso = resultado[i]["estado"] == "Aceptado" ? 
        $(
          "<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idventa"] +")'><i class='fa fa-eye'></i></button>"+
          " <button class='btn btn-danger' onclick='anular("+ resultado[i]["idventa"] +")' ><i class='fa fa-close'></i></button></td>"
          ) 
        : 
        $(
          "<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idventa"] +")'><i class='fa fa-eye'></i></button>"
         
          ) 
        ;
        
        var fecha = $("<td>" + resultado[i]["fecha"] + "</td>");
        var proveedor = $("<td>" + resultado[i]["proveedor"] + "</td>");
        var usuario = $("<td>" + resultado[i]["usuario"] + "</td>");
        var tipo_comprobante = $("<td>" + resultado[i]["tipo_comprobante"] + "</td>");
        var serie_comprobante = $("<td>" + resultado[i]["serie_comprobante"] + " - " + resultado[i]["num_comprobante"] +"</td>");
        var total_compra = $("<td>" + resultado[i]["total_venta"] + "</td>");
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
    }
  };

    // funcion limpiar datos
    function limpiar(){
    $("#idcliente").val("");
    $("#cliente").val("");
    $("#serie_comprobante").val("");
    $("#num_comprobante").val("");
    $("#impuesto").val("0");
 
    $("#total_venta").val("");
    $(".filas").remove();
    $("#total").html("0");
 
    //Obtenemos la fecha actual
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_hora').val(today);
 
    //Marcamos el primer tipo_documento
    $("#tipo_comprobante").val("Boleta");
    $("#tipo_comprobante").selectpicker('refresh');
      }


      //Función mostrar formulario
function mostrarform(flag)
{
    limpiar();
    if (flag)
    {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        //$("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
        listarArticulos();
        //alert("hola");
 
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").show();
        detalles=0;
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

//Función cancelarform
function cancelarform()
{
    limpiar();
    mostrarform(false);
}

//funcion listar Articulos Activos
function listarArticulos(){
  
    $.ajax({
      url: 'http://localhost/sistemav/ajax/venta.php?op=listarArticulosVenta',
      type: 'GET',
      success: function(response){
          
        var resultado = JSON.parse(response);
          mostrar_articulo(resultado);
      }
  });//fin ajax mostrar
  }//fin de listar Articulos
  
  //mostrar datos de articulos Activos
  mostrar_articulo = function(resultado){
    
    var tabla = $("#listararticulos");
    $("#listararticulos").empty();
    //console.log(resultado[1]["nombre"]);
    for (let i = 0; i < resultado.length; i++) {
        alert("hola");
      
        var tr = $("<tr></tr>");
        //var idcategoria = $("<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idcategoria"] +")'><i class='fa fa-pencil'></i></button></td>");
        var articulo =  $("<td><button class='btn btn-warning' onclick='agregardetalle("+resultado[i]["idarticulo"]+',"'+resultado[i]["nombre"]+'",'+resultado[i]["precio_venta"]+")'><span class='fa fa-plus'></span></button>");
        //var articulo =  $( '<td><button class="btn btn-warning" onclick="agregardetalle("'+ resultado[i]["nombre"]+'")"><span class="fa fa-plus"></span></button></td>');
        var nombre = $("<td>" + resultado[i]["nombre"] + "</td>");
        var categoria = $("<td>" + resultado[i]["categoria"] + "</td>");
        var codigo = $("<td>" + resultado[i]["codigo"] + "</td>");
        var stock = $("<td>" + resultado[i]["stock"] + "</td>");
        var prev = $("<td>" + resultado[i]["precio_venta"] + "</td>");
        var imagen = $("<td> <img src='../file/articulos/" + 
          resultado[i]["imagen"] + "' height='50px' width='50px'> </td>");
        
        
        tr.append(articulo);
        tr.append(nombre);
        tr.append(categoria);
        tr.append(codigo);
        tr.append(stock);
        tr.append(prev);
        tr.append(imagen);
        tabla.append(tr);
    }
  };

  //funcion mostrar
  
  function mostrar(idventa){
    //alert(idarticulo);
    $.post('http://localhost/sistemav/ajax/venta.php?op=mostrar',{idventa : idventa}, function (response,state){
      var resultado = JSON.parse(response);
      console.log(resultado);
      
      mostrarform(true);
      $("#idcliente").val(resultado[0]["idcliente"]);
      $("#idcliente").selectpicker('refresh');
      $("#tipo_comprobante").val(resultado[0]["tipo_comprobante"]);
      $("#tipo_comprobante").selectpicker('refresh');
      $("#serie_comprobante").val(resultado[0]["serie_comprobante"]);
      $("#num_comprobante").val(resultado[0]["num_comprobante"]);
      $("#fecha_hora").val(resultado[0]["fecha"]);
      $("#impuesto").val(resultado[0]["impuesto"]);
      $("#idingreso").val(resultado[0]["idventa"]);

      //Ocultar y mostrar los botones
      $("#btnGuardar").hide();
      $("#btnCancelar").show();
      $("#btnAgregarArt").hide();
      
      
  });
  ingresoDetalle(idventa);    
  }

   //funcion mostrar detalle ingreso
   function ingresoDetalle(idventa){
    $.ajax({
      url: 'http://localhost/sistemav/ajax/venta.php?op=listarDetalle&id='+idventa,
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
   // var foot = $("#to");
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
        var prev = $("<td>" + resultado[i]["precio_venta"] + "</td>");
        var subtotal = resultado[i]["cantidad"] * resultado[i]["precio_compra"] - resultado[i]["descuento"];
        var total = total + subtotal;
        var sub = $("<td>" + total + "</td>");
        //var total= (total + subtotal);
        //alert(""+total+"");

        //var ci = $("<th><h4 id='total'>"+total+"</h4><input type='hidden' name='total_compra' id='total_compra'></th>");

        
        //$("#total").val(total);
        tr.append(opcion);
        tr.append(nombre);
        tr.append(cantidad);
        tr.append(prev);
        tr.append(sub);
        tabla.append(tr);
       // foot.append(ci);
        
    };
          
  };

    //funcion anular
    function anular(idventa){
        bootbox.confirm("¿Estas seguro de anular la venta?",function(resultado){
          if(resultado){
            $.post('http://localhost/sistemav/ajax/venta.php?op=anular',{idventa : idventa}, function (response){
              bootbox.alert(response);
              listar()
            });
          }
        })
      }

      //Declaración de variables necesarias para trabajar con las compras y
//sus detalles
var impuesto=18;
var cont=0;
var detalles=0;
//$("#guardar").hide();
$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);

function marcarImpuesto()
  {
    var tipo_comprobante=$("#tipo_comprobante option:selected").text();
    if (tipo_comprobante=='Factura')
    {
        $("#impuesto").val(impuesto); 
    }
    else
    {
        $("#impuesto").val("0"); 
    }
  }

  function agregardetalle(idarticulo,articulo,precio_venta)
  {
    var cantidad=1;
    var descuento=0;
 
    if (idarticulo!="")
    {
        var subtotal=cantidad*precio_venta;
        var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><button type="button" class="btn btn-danger" onclick="eliminardetalle('+cont+')">X</button></td>'+
        '<td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td>'+
        '<td><input type="number" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
        '<td><input type="number" name="precio_venta[]" id="precio_venta[]" value="'+precio_venta+'"></td>'+
        '<td><input type="number" name="descuento[]" value="'+descuento+'"></td>'+
        '<td><span name="subtotal" id="subtotal'+cont+'">'+subtotal+'</span></td>'+
        '<td><button type="button" onclick="modificarSubototales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'+
        '</tr>';
        cont++;
        detalles=detalles+1;
        $('#detalles').append(fila);
        modificarSubototales();
    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del artículo");
    }
  }

  function modificarSubototales()
  {
    var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precio_venta[]");
    var desc = document.getElementsByName("descuento[]");
    var sub = document.getElementsByName("subtotal");
 
    for (var i = 0; i <cant.length; i++) {
        var inpC=cant[i];
        var inpP=prec[i];
        var inpD=desc[i];
        var inpS=sub[i];
 
        inpS.value=(inpC.value * inpP.value)-inpD.value;
        document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
    }
    calcularTotales();
 
  }

  function calcularTotales(){
    var sub = document.getElementsByName("subtotal");
    var total = 0.0;
 
    for (var i = 0; i <sub.length; i++) {
        total += document.getElementsByName("subtotal")[i].value;
    }
    $("#total").html("S/. " + total);
    $("#total_venta").val(total);
    evaluar();
  }

  function evaluar(){
    if (detalles>0)
    {
      $("#btnGuardar").show();
    }
    else
    {
      $("#btnGuardar").hide(); 
      cont=0;
    }
  }

  function eliminarDetalle(indice){
    $("#fila" + indice).remove();
    calcularTotales();
    detalles=detalles-1;
    evaluar()
  }

   //select proveedor
 selectCategoria = function(resultado){
    var tabla = $("#idcliente");
    $("#idcliente").empty();
    for (let i = 0; i < resultado.length; i++) {
        //var idcategoria = $("<td><button class='btn btn-warning' onclick='mostrar("+ resultado[i]["idcategoria"] +")'><i class='fa fa-pencil'></i></button></td>");
        var categoria = $("<option value='" + resultado[i]["idpersona"] + "'>" + resultado[i]["nombre"] +"</option>");      
        tabla.append(categoria);
        
    }
  };
 
init();
