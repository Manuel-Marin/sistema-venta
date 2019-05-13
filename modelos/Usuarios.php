<?php


class Usuarios extends Conectar{

    private $agregar = array();
    private $editar = array();
    private $desactivar = array();
    private $activar = array();
    private $mostrar_por_id = array();
    private $mostrar = array();
    private $arcados = array();
    private $verificar = array();

    //fuction para Agregar Persona
    public function agregar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$permiso){
        $conectar = Conectar::conexion();
        $sql = "insert into usuario value(null,?,?,?,?,?,?,?,?,?,?,1)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1,$_POST["nombre"]);
        $sql->bindValue(2,$_POST["tipo_documento"]);
        $sql->bindValue(3,$_POST["num_documento"]);
        $sql->bindValue(4,$_POST["direccion"]);
        $sql->bindValue(5,$_POST["telefono"]);
        $sql->bindValue(6,$_POST["email"]);
        $sql->bindValue(7,$_POST["cargo"]);
        $sql->bindValue(8,$_POST["login"]);
        $sql->bindValue(9,$clave);
        $sql->bindValue(10,$imagen);
        $sql->execute();

        //$resultado = $sql->fetch();
        //return $resultado;

        $idusuarionew = $conectar->lastInsertId();
        $num_elementos= 0;
        $sw=true;

        while ($num_elementos < count($permiso)) {

            $sql_detalle = "insert into usuario_permiso(idusuario,idpermiso)
            values('$idusuarionew','$permiso[$num_elementos]')";
            $sql_detalle = $conectar->prepare($sql_detalle);
            $sql_detalle->execute() or $sw=false;
            $num_elementos = $num_elementos + 1;
        }
        return $sw;
    }

    //Fuction para Editar Persona
    public function editar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$permiso){
        $conectar = Conectar::conexion();
        $sql = "update usuario set nombre=?, tipo_documento=?, num_documento=?,
                direccion=?, telefono=?, email=?, cargo=?, login=?, clave=?, imagen=?
                where idusuario =?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$_POST["nombre"]);
        $sql->bindValue(2,$_POST["tipo_documento"]);
        $sql->bindValue(3,$_POST["num_documento"]);
        $sql->bindValue(4,$_POST["direccion"]);
        $sql->bindValue(5,$_POST["telefono"]);
        $sql->bindValue(6,$_POST["email"]);
        $sql->bindValue(7,$_POST["cargo"]);
        $sql->bindValue(8,$_POST["login"]);
        $sql->bindValue(9,$_POST["clave"]);
        $sql->bindValue(10,$imagen);
        $sql->bindValue(11,$_POST["idusuario"]);
        $sql->execute();

        //Eliminamos todos los permisos asignados
        $sql_eliminar ="delete from usuario_permiso where idusuario=?";
        $sql_eliminar = $conectar->prepare($sql_eliminar);
        $sql_eliminar->bindValue(1,$_POST["idusuario"]);
        $sql_eliminar->execute();
        
        $num_elementos= 0;
        $sw=true;

        while ($num_elementos < count($permiso)) {

            $sql_detalle = "insert into usuario_permiso(idusuario,idpermiso)
            values('$idusuario','$permiso[$num_elementos]')";
            $sql_detalle = $conectar->prepare($sql_detalle);
            $sql_detalle->execute() or $sw=false;
            $num_elementos = $num_elementos + 1;
        }
        return $sw;
    }

    //desactivar usuario
    public function desactivar($idusuario){
        $conectar = Conectar::conexion();
        $sql = "update usuario set condicion = 0 where idusuario = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$_POST["idusuario"]);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->desactivar[]=$resultado;
        }
        return $this->desactivar;
    }

    //Fuction para Activar Usuario
    public function activar($idusuario){
        $conectar = Conectar::conexion();
        $sql = "update usuario set condicion = 1 where idusuario = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$_POST["idusuario"]);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->activar[]=$resultado;
        }
        return $this->activar;
    }



    //Funcion para mostrar por por su idpersona
    public function mostrar_por_id($idusuario){
        $conectar = Conectar::conexion();
        $sql = "select * from usuario where idusuario = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$_POST["idusuario"]);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->mostrar_por_id[]=$resultado;
        }
        return $this->mostrar_por_id;
    }

       //Funcion para listar todos los proveedores
       public function mostrar(){
        $conectar=Conectar::conexion();
        $sql="select * from usuario ";
        $sql=$conectar->prepare($sql);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->mostrar[]=$resultado;
        }
        return $this->mostrar;
    }

         //Funcion para listar marcados permisos
         public function listarmarcados($id){
            $conectar=Conectar::conexion();
            $sql="select * from usuario_permiso where idusuario=? ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$id);
            $sql->execute();
    
            //while ($resultado = $sql->fetch()) {
              //  $this->marcados[]=$resultado;
            //}
            return $sql;
        }

   //Funcion para verificar el acceso al sistema
   public function verificar($login,$clave){
    $conectar=Conectar::conexion();
    $sql="select idusuario,nombre,tipo_documento,num_documento,telefono,email,cargo,imagen,login 
    from usuario where login=? and clave=? and condicion=1";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1,$login);
    $sql->bindValue(2,$clave);
    $sql->execute();
    //6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b

     while ($resultado = $sql->fetch()) {
         $this->verificar[]=$resultado;
        }
        return $this->verificar;
   }

   
}

