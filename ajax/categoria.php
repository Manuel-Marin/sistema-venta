<?php

require_once("../config/conexion.php");
require_once("../modelos/Categorias.php");

$categoria= new Categorias();

//$idcategoria = isset($_POST["idcategoria"]);
//$nombre = isset($_POST["nombre"]);
//$descripcion = isset($_POST["descripcion"]);

switch ($_GET["op"]) {
    case 'guardaryeditar':
        if(empty($idcategoria)){
            $categoria->agregarcat($_POST["nombre"],$_POST["descripcion"]);
            $mensaje["exito_agregar"] = "<script >alert('Categoria agregada')</script>";

        }else{
            $categoria->editarcat($_POST["idcategoria"],$_POST["nombre"],$_POST["descripcion"]);
            $mensaje["exito_editar"] = "<script >alert('Categoria Actualizada')</script>";
        }
        echo json_encode($mensaje);
        break;

    case 'desactivar':
            $categoria->desactivarcat($_POST["idcategoria"]);
            $mensaje["exito_desactivar"] = "<script >alert('Categoria Desactivada')</script>";
        break;
    case 'activar':
            $categoria->activarcat($_POST["idcategoria"]);
            $mensaje["exito_activar"] = "<script >alert('Categoria Activada')</script>";
        break;

    case 'mostrar':
    $datos = $categoria->mostrarcat($_POST["idcategoria"]);
    echo json_encode($datos);
        break;

    case 'listar':
    $datos = $categoria->listarcat();
    echo json_encode($datos);
        break;
    
  
}