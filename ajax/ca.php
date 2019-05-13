<?php
require_once("../config/conexion.php");
require_once("../modelos/Categorias.php");
$cat = new Categorias();

//$idcategoria = isset($_POST["idcategoria"]);
//$nombre = isset($_POST["nombre"]);
//$descripcion = isset($_POST["descripcion"]);

switch ($_GET["op"]) {
    case 'listar':
        $datos = $cat->mostrar();
        echo json_encode($datos);
        break;

    case 'guardaryeditar':
       if(empty($_POST["idcategoria"])){
            $cat->agregarcat($_POST["nombre"],$_POST["descripcion"]);
            //$mensaje["exito_agregar"] = "<script >alert('Categoria agregada')</script>";
            echo "se agrego correctamente";
        }
        else{
            $cat->editarcat($_POST["idcategoria"],$_POST["nombre"],$_POST["descripcion"]);
            echo "se actualizo correctamente";
        }
        break;

    case 'mostrar':
            $datos = $cat->mostrarcat($_POST["idcategoria"]);
            echo json_encode($datos);
            //echo "se agrego correctamente";
        break;

    case 'desactivar':
            $cat->desactivarcat($_POST["idcategoria"]);
            echo "se desactivo correctamente";
        break;

    case 'activar':
            $cat->activarcat($_POST["idcategoria"]);
            echo "se activo correctamente";
        break;
    
}

