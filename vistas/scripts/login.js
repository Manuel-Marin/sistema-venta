$("#frmAcceso").on("submit",function(e){
    e.preventDefault();
    logina =$("#logina").val();
    clavea =$("#clavea").val();
    var formData = new FormData($("#frmAcceso")[0]);

    $.ajax({
        url: "http://localhost/sistemav/ajax/usuario.php?op=verificar",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                       /*importante poner el json para que devuelva el valor*/
                dataType:'json',

                success: function(datos){
                    if(datos.exito_insertar){
                        //bootbox.alert("correcto"); 
                        var url = "../vistas/categoria.php"; 
                        $(location).attr('href',url);
                    }else{
                        bootbox.alert("error"); 
                    }
                }
    })
    
    //$.post('http://localhost/sistemav/ajax/usuario.php?op=verificar',
    //{"logina":logina,"clavea":clavea},
    //function(datos){
        //var resultado = JSON.parse(datos);
        //if(resultado!="null"){
          //  var url = "http://localhost/sistemav/vistas/categoria.php"; 
         //   $(location).attr('href',url);
            //$(location).attr("href","../categoria.php");
            //bootbox.alert(response);
        //}
       // else{
         //   bootbox.alert(datos.error);
        //}
    //});
})