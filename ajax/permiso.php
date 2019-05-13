<?php
require_once("../config/conexion.php");
require_once("../modelos/Permisos.php");
$per = new Permisos();

//$idcategoria = isset($_POST["idcategoria"]);
//$nombre = isset($_POST["nombre"]);
//$descripcion = isset($_POST["descripcion"]);

switch ($_GET["op"]) {
    case 'listar':
        $datos = $per->mostrar();
        $resultado = $datos->fetchAll();
        echo json_encode($resultado);
        break;
   
}

