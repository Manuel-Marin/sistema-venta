<?php

require_once("../config/conexion.php");
require_once("../modelos/Articulos.php");
$art = new Articulos();

//idarticulo = isset($_POST["idarticulo"]);
//$idcategoria = $_POST["idcategoria"];
$codigo = isset($_POST["codigo"]);
$nombre = isset($_POST["nombre"]);
$stock = isset($_POST["stock"]);
$descripcion = isset($_POST["descripcion"]);
$imagen = isset($_POST["imagen"]);

switch ($_GET["op"]) {
    case 'listar':
        $datos = $art->mostrar();
        echo json_encode($datos);
        break;

    case 'guardaryeditar':

if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])){
        $imagen=$_POST["imagenactual"];

       }else{
           $e = "hola";
           $ext = explode(".",$_FILES['imagen']['name']);
           if($_FILES['imagen']['type'] == "image/png"  or $_FILES['imagen']['type'] == "image/jpeg" or $_FILES['imagen']['type'] == "image/jpg"){
                //or $_FILES['imagen']['type'] == "image/jpeg" or $_FILES['imagen']['type'] == "image/png"
                $imagen= round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES['imagen']['tmp_name'], "../file/articulos/".$imagen);
                
            }
       }
       if(empty($_POST["idarticulo"])){
          
          $idcategoria = $_POST["idcategoria"];
           $datos = $art->agregar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen);
            echo "se agrego el Articulo correctamente";
       }
        else{
            $art->editar($_POST["idarticulo"],$_POST["idcategoria"],$codigo,$nombre,$stock,$descripcion,$imagen);
            echo "se actualizo el  correctamente";
        }
        break;

    case 'mostrar':
            $datos = $art->mostrar_por_id($_POST["idarticulo"]);
            echo json_encode($datos);
        break;

    case 'desactivar':
            $art->desactivar($_POST["idarticulo"]);
            echo "se desactivo correctamente";
        break;

    case 'activar':
            $art->activar($_POST["idarticulo"]);
            echo "se activo correctamente";
        break;

    case 'selectCategorias':
            require_once("../modelos/Categorias.php");
            $cat= new Categorias();
            $datos = $cat->select();
            echo json_encode($datos);
        break;
    
}

