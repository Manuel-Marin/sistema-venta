<?php

require_once("../config/conexion.php");
require_once("../modelos/Usuarios.php");
$usu = new Usuarios();

//idarticulo = isset($_POST["idarticulo"]);
//$idcategoria = $_POST["idcategoria"];
//$idusuario = isset($_POST["idusuario"]);
$nombre = isset($_POST["nombre"]);
$tipo_documento = isset($_POST["tipo_documento"]);
$num_documento = isset($_POST["num_documento"]);
$direccion = isset($_POST["direccion"]);
$telefono = isset($_POST["telefono"]);
$email = isset($_POST["email"]);
$cargo = isset($_POST["cargo"]);
$login = isset($_POST["login"]);
$clave = isset($_POST["clave"]);
$imagen = isset($_POST["imagen"]);

switch ($_GET["op"]) {
    case 'listar':
        $datos = $usu->mostrar();
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
                move_uploaded_file($_FILES['imagen']['tmp_name'], "../file/usuarios/".$imagen);
                
            }
       }
       //Hash SHA256 en la clave
       //$clavehash = hash("SHA256",$clave);
       if(empty($_POST["idusuario"])){  
          //$idcategoria = $_POST["idcategoria"];
           $datos = $usu->agregar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$_POST["permiso"]);
            echo "se agrego el correctamente";
       }
        else{
            $usu->editar($_POST["idusuario"],$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$_POST["permiso"]);
            //echo "se actualizo el Usuario correctamente";
           echo $_POST["idusuario"];
        }
        break;

    case 'mostrar':
            $datos = $usu->mostrar_por_id($_POST["idusuario"]);
            echo json_encode($datos);
        break;

    case 'desactivar':
            $usu->desactivar($_POST["idusuario"]);
            echo "se desactivo correctamente";
        break;

    case 'activar':
            $usu->activar($_POST["idusuario"]);
            echo "se activo correctamente";
        break;

    case 'permiso':
    require_once("../modelos/Permisos.php");
        $permiso = new Permisos();
        $datos = $permiso->mostrar();

        $id=$_GET["id"];
        $marcados = $usu->listarmarcados($id);

        $valores= array();
        while ($per = $marcados->fetch()) {
           array_push($valores, $per["idpermiso"]);
        }
        
        
        while ($resultado = $datos->fetch()) {
            $sw = in_array($resultado["idpermiso"],$valores)?'checked':'';
            echo "<li><input type='checkbox' ".$sw." name='permiso[]' value='". $resultado["idpermiso"]."'>". $resultado["nombre"]."</li>";
        }
        //$permisos = $("<li><input type='checkbox'"+ $sw+ " name='permiso[]' value='" + resultado[i]["idpermiso"] + "'>" + resultado[i]["nombre"]+"</li>");
        //echo json_encode($datos,$marcados);

        break;

    case 'verificar':
        $logina=$_POST["logina"];
        $clavea=$_POST["clavea"];
        //$clavehash = hash("SHA256",$clavea);
        $datos = $usu->verificar($logina,$clavea);
        //$fetch = $datos->fetch();
        
        if(is_array($datos)== true and count($datos)>0){
            $_SESSION["idusuario"] = $datos[0]["idusuario"];
            $_SESSION["nombre"] = $datos[0]["nombre"];
            $_SESSION["imagen"] = $datos[0]["imagen"];
            $_SESSION["login"] = $datos[0]["login"];
            
            //obtenemos los permisos del usuario
            $marcados = $usu->listarmarcados($datos[0]["idusuario"]);
            //declaramos el array para almacenar todos los permisos del usuario
            $valores= array();
            //almacenamos los permisos marcados en el array
            while ($per = $marcados->fetch()) {
               array_push($valores, $per["idpermiso"]);
            }

            

            //determinamos los accesos del usuario
            in_array(1,$valores)?$_SESSION["escritorio"]=1:$_SESSION["escritorio"]=0;
            in_array(2,$valores)?$_SESSION["almacen"]=1:$_SESSION["almacen"]=0;
            in_array(3,$valores)?$_SESSION["compras"]=1:$_SESSION["compras"]=0;
            in_array(4,$valores)?$_SESSION["ventas"]=1:$_SESSION["ventas"]=0;
            in_array(5,$valores)?$_SESSION["acceso"]=1:$_SESSION["acceso"]=0;
            in_array(6,$valores)?$_SESSION["consultac"]=1:$_SESSION["consultac"]=0;
            in_array(7,$valores)?$_SESSION["consultav"]=1:$_SESSION["consultav"]=0;

            $mensaje["exito_insertar"] = "Bienvenido";
        }else{
            $mensaje["error"]= "incorrecto";
        }
        echo json_encode($mensaje);
        
       
        break;

    case 'salir':
        //limpiamos las variables de sesion
        session_unset();
        //destruimos la ssesion
        session_destroy();

        header("Location: ../index.php");
        break;


    
}

