<?php


class Personas extends Conectar{

    private $agregar = array();
    private $editar = array();
    private $deliminar = array();
    private $mostrar_por_id = array();
    private $mostrarp = array();
    private $mostrarc = array();
    private $select = array();

    //fuction para Agregar Persona
    public function agregar($tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email){
        $conectar = Conectar::conexion();
        $sql = "insert into persona value(null,?,?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1,$_POST["tipo_persona"]);
        $sql->bindValue(2,$_POST["nombre"]);
        $sql->bindValue(3,$_POST["tipo_documento"]);
        $sql->bindValue(4,$_POST["num_documento"]);
        $sql->bindValue(5,$_POST["direccion"]);
        $sql->bindValue(6,$_POST["telefono"]);
        $sql->bindValue(7,$_POST["email"]);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->agregar[]=$resultado;
        }
        return $this->agregar;
    }

    //Fuction para Editar Persona
    public function editar($idpersona,$tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email){
        $conectar = Conectar::conexion();
        $sql = "update persona set tipo_persona=?, nombre=?, tipo_documento=?, num_documento=?,
                direccion=?, telefono=?, email=?
                where idpersona =?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$_POST["tipo_persona"]);
        $sql->bindValue(2,$_POST["nombre"]);
        $sql->bindValue(3,$_POST["tipo_documento"]);
        $sql->bindValue(4,$_POST["num_documento"]);
        $sql->bindValue(5,$_POST["direccion"]);
        $sql->bindValue(6,$_POST["telefono"]);
        $sql->bindValue(7,$_POST["email"]);;
        $sql->bindValue(8,$_POST["idpersona"]);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->editar[]=$resultado;
        }
        return $this->editar;
    }

    //Fuction para Eliminar Persona
    public function eliminar($idpersona){
        $conectar = Conectar::conexion();
        $sql = "delete from persona where idpersona = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$_POST["idpersona"]);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->eliminar[]=$resultado;
        }
        return $this->eliminar;
    }



    //Funcion para mostrar por por su idpersona
    public function mostrar_por_id($idpersona){
        $conectar = Conectar::conexion();
        $sql = "select * from persona where idpersona = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$_POST["idpersona"]);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->mostrar_por_id[]=$resultado;
        }
        return $this->mostrar_por_id;
    }

       //Funcion para listar todos los proveedores
       public function mostrarp(){
        $conectar=Conectar::conexion();
        $sql="select * from persona where tipo_persona='Proveedor'";
        $sql=$conectar->prepare($sql);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->mostrarp[]=$resultado;
        }
        return $this->mostrarp;
    }

          //Funcion para listar todos los clientes
          public function mostrarc(){
            $conectar=Conectar::conexion();
            $sql="select * from persona where tipo_persona='Cliente'";
            $sql=$conectar->prepare($sql);
            $sql->execute();
    
            while ($resultado = $sql->fetch()) {
                $this->mostrarc[]=$resultado;
            }
            return $this->mostrarc;
        }

   
}

