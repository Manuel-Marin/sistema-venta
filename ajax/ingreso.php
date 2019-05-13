<?php

require_once("../config/conexion.php");
require_once("../modelos/Ingresos.php");

$ingreso= new Ingresos();

//$idcategoria = isset($_POST["idcategoria"]);
$idingreso = isset($_POST["idingreso"]);
$idproveedor = isset($_POST["idproveedor"]);
$idusuario = $_SESSION["idusuario"];
$tipo_comprobante = isset($_POST["tipo_comprobante"]);
$serie_comprobante = isset($_POST["serie_comprobante"]);
$num_comprobante = isset($_POST["num_comprobante"]);
$fecha_hora = isset($_POST["fecha_hora"]);
$impuesto = isset($_POST["impuesto"]);
$total_compra = isset($_POST["total_compra"]);

switch ($_GET["op"]) {
    case 'guardaryeditar':
        if(empty($_POST["idingreso"])){
           $datos = $ingreso->agregar($_POST["idproveedor"],$_SESSION["idusuario"],$_POST["tipo_comprobante"],
           $_POST["serie_comprobante"],$_POST["num_comprobante"],$_POST["fecha_hora"],$_POST["impuesto"],
           $_POST["total_compra"],$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_compra"],
            $_POST["precio_venta"]);
            echo $datos ? "Ingreso Registrado": "No se pudieron registrar todos los datos del ingreso";
            //echo  json_encode($_POST["precio_venta"]);
           // echo "datos";
        }else{
            echo "datos no encontrados";
        }
        break;

    case 'anular':
            $datos = $ingreso->anular($_POST["idingreso"]);
            echo $datos ? "Ingreso Anulado": "Ingreso no se puede anular";

        break;

    case 'mostrar':
        $datos = $ingreso->mostrar_por_id($_POST["idingreso"]);
        echo json_encode($datos);
        break;

    case 'listarDetalle':
        $id = $_GET["id"];
        $datos = $ingreso->listarDetalle($id);
        echo json_encode($datos);
        break;

    case 'listar':
        $datos = $ingreso->mostrar();
        echo json_encode($datos);
        break;

    case 'selectProveedor':
    require_once("../modelos/Personas.php");
        $persona = new Personas();
        $datos = $persona-> mostrarp();
        //while ($datos) {
          //  echo "option value=".$datos[0]["idpersona"].">".$datos[0]["nombre"]."</option>";
       // }
        echo json_encode($datos);
        break;

    case 'listarArticulos':
    require_once("../modelos/Articulos.php");
        $articulos = new Articulos();
        $datos = $articulos->mostraractivos();
        echo json_encode($datos);
        break;
    
  
}