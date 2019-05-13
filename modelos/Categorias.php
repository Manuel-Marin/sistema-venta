<?php


class Categorias extends Conectar{

    private $agregarcat = array();
    private $editarcat = array();
    private $desactivarcat = array();
    private $activarcat = array();
    private $mostrarcat = array();
    private $mostrar = array();
    private $select = array();

    //fuction para Agregar Categoria
    public function agregarcat($nombre,$descripcion){
        $conectar = Conectar::conexion();
        $sql = "insert into categoria value(null,?,?,1)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1,$_POST["nombre"]);
        $sql->bindValue(2,$_POST["descripcion"]);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->agregarcat[]=$resultado;
        }
        return $this->agregarcat;
    }

    //Fuction para Editar Categoria
    public function editarcat($idcategoria,$nombre,$descripcion){
        $conectar = Conectar::conexion();
        $sql = "update categoria set nombre=?, descripcion=? where idcategoria =?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$_POST["nombre"]);
        $sql->bindValue(2,$_POST["descripcion"]);
        $sql->bindValue(3,$_POST["idcategoria"]);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->editarcat[]=$resultado;
        }
        return $this->editarcat;
    }

    //Fuction para Dsactivar Categoria
    public function desactivarcat($idcategoria){
        $conectar = Conectar::conexion();
        $sql = "update categoria set condicion = 0 where idcategoria = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$_POST["idcategoria"]);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->desactivarcat[]=$resultado;
        }
        return $this->desactivarcat;
    }

    //Fuction para Activar Categoria
    public function activarcat($idcategoria){
        $conectar = Conectar::conexion();
        $sql = "update categoria set condicion = 1 where idcategoria = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$_POST["idcategoria"]);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->activarcat[]=$resultado;
        }
        return $this->activarcat;
    }

    //Funcion para mostrar categoria por si idcategoria
    public function mostrarcat($idcategoria){
        $conectar = Conectar::conexion();
        $sql = "select * from categoria where idcategoria = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$_POST["idcategoria"]);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->mostrarcat[]=$resultado;
        }
        return $this->mostrarcat;
    }

       //Funcion para listar todas las categorias
       public function mostrar(){
        $conectar=Conectar::conexion();
        $sql="select * from categoria";
        $sql=$conectar->prepare($sql);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->mostrar[]=$resultado;
        }
        return $this->mostrar;
    }

      //Funcion para listar todas las categorias activas
      public function select(){
        $conectar=Conectar::conexion();
        $sql="select * from categoria where condicion=1";
        $sql=$conectar->prepare($sql);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->select[]=$resultado;
        }
        return $this->select;
    }
}

