<?php
require_once("../config/conexion.php");
require_once("../modelos/Personas.php");
$per = new Personas();

$idpersona = isset($_POST["idpersona"]);
$tipo_persona = isset($_POST["tipo_persona"]);
$nombre = isset($_POST["nombre"]);
$tipo_documento = isset($_POST["tipo_documento"]);
$num_documento = isset($_POST["num_documento"]);
$direccion = isset($_POST["direccion"]);
$telefono = isset($_POST["telefono"]);
$email = isset($_POST["email"]);

switch ($_GET["op"]) {
    case 'listarp':
        $datos = $per->mostrarp();
        echo json_encode($datos);
        break;

    case 'listarc':
        $datos = $per->mostrarc();
        echo json_encode($datos);
        break;

    case 'guardaryeditar':
       if(empty($_POST["idpersona"])){
            $per->agregar($tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email);
            //$mensaje["exito_agregar"] = "<script >alert('Categoria agregada')</script>";
            echo "se agrego  correctamente";
        }
        else{
            $per->editar($idpersona,$tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email);
            echo "se actualizo los datos de la persona correctamente";
        }
        break;

    case 'mostrar':
            $datos = $per->mostrar_por_id($_POST["idpersona"]);
            echo json_encode($datos);
            //echo "se agrego correctamente";
        break;

    case 'eliminar':
            $per->eliminar($_POST["idpersona"]);
            echo "se elimino correctamente";
        break;

  
    
}

