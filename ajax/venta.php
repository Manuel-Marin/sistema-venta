<?php

require_once("../config/conexion.php");
require_once("../modelos/Ventas.php");

$venta= new Ventas();

//$idcategoria = isset($_POST["idcategoria"]);
$idventa=isset($_POST["idventa"]);
$idcliente=isset($_POST["idcliente"]);
$idusuario=$_SESSION["idusuario"];
$tipo_comprobante=isset($_POST["tipo_comprobante"]);
$serie_comprobante=isset($_POST["serie_comprobante"]);
$num_comprobante=isset($_POST["num_comprobante"]);
$fecha_hora=isset($_POST["fecha_hora"]);
$impuesto=isset($_POST["impuesto"]);
$total_venta=isset($_POST["total_venta"]);

switch ($_GET["op"]) {
    case 'guardaryeditar':
        if(empty($_POST["idventa"])){
            //if (empty($idventa)){
              // $rspta=$venta->insertar($_POST["idcliente"],$_SESSION["idusuario"],$_POST["tipo_comprobante"],$_POST["serie_comprobante"],$_POST["num_comprobante"],$_POST["fecha_hora"],$_POST["impuesto"],$_POST["total_venta"],$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_venta"],$_POST["descuento"]);
                
            //}
            
           $datos = $venta->agregar($_POST["idcliente"],$_SESSION["idusuario"],$_POST["tipo_comprobante"],$_POST["serie_comprobante"],$_POST["num_comprobante"],$_POST["fecha_hora"],$_POST["impuesto"],$_POST["total_venta"],$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_venta"],$_POST["descuento"]);
            echo $datos ? "Venta registrada" : "No se pudieron registrar todos los datos de la venta";
            
            //echo $_POST["tipo_comprobante"];
           // echo "datos";
        }else{
            echo "datos no encontrados";
        }
        break;

    case 'anular':
            $datos = $venta->anular($_POST["idventa"]);
            echo $datos ? "Ingreso Anulado": "Ingreso no se puede anular";

        break;

    case 'mostrar':
        $datos = $venta->mostrar_por_id($_POST["idventa"]);
        echo json_encode($datos);
        break;

    case 'listarDetalle':
        $id = $_GET["id"];
        $datos = $venta->listarDetalle($id);
        echo json_encode($datos);
        break;

    case 'listar':
        $datos = $venta->mostrar();
        echo json_encode($datos);
        break;

    case 'selectCliente':
    require_once("../modelos/Personas.php");
        $persona = new Personas();
        $datos = $persona-> mostrarc();
        //while ($datos) {
          //  echo "option value=".$datos[0]["idpersona"].">".$datos[0]["nombre"]."</option>";
       // }
        echo json_encode($datos);
        break;

    case 'listarArticulosVenta':
    require_once("../modelos/Articulos.php");
        $articulos = new Articulos();
        $datos = $articulos->listarActivosVenta();
        echo json_encode($datos);
        break;
    
  
}