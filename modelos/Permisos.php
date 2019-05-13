<?php


class Permisos extends Conectar{

  
    private $mostrar = array();

       //Funcion para listar todas las categorias
       public function mostrar(){
        $conectar=Conectar::conexion();
        $sql="select * from permiso";
        $sql=$conectar->prepare($sql);
        $sql->execute();
       // $resultado = $sql->fetchAll();
        //while ($resultado = $sql->fetch()) {
          //  $this->mostrar[]=$resultado;
        //}
        return $sql;
    }

    
      
}

