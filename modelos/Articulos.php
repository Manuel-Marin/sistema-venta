<?php


class Articulos extends Conectar{

    private $agregar = array();
    private $editar = array();
    private $desactivar = array();
    private $activar = array();
    private $mostrar_por_id = array();
    private $mostrar = array();
    private $mostraractivos = array();
    private $listarActivosVentas = array();

    //fuction para Agregar Artticulo
    public function agregar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen){

        $conectar = Conectar::conexion();
        //$sql = "INSERT INTO articulo (idcategoria,codigo,nombre,stock,descripcion,imagen,condicion) VALUES (3,12345,'articulo3',1,'ssss','imagen',1)";
        $sql = "INSERT INTO articulo VALUES(null,?,?,?,?,?,?,1)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1,$_POST["idcategoria"]);
        $sql->bindValue(2,$_POST["codigo"]);
        $sql->bindValue(3,$_POST["nombre"]);
        $sql->bindValue(4,$_POST["stock"]);
        $sql->bindValue(5,$_POST["descripcion"]);
        $sql->bindValue(6,$imagen); 
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->agregar[]=$resultado;
        }
        return $this->agregar;
    }

    //Fuction para Editar Articulo
    public function editar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen){
        $conectar = Conectar::conexion();
        $sql = "update articulo set idcategoria=?, codigo=?, nombre=?, stock=?, descripcion=?, imagen=? 
        where idarticulo =?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$_POST["idcategoria"]);
        $sql->bindValue(2,$_POST["codigo"]);
        $sql->bindValue(3,$_POST["nombre"]);
        $sql->bindValue(4,$_POST["stock"]);
        $sql->bindValue(5,$_POST["descripcion"]);
        $sql->bindValue(6,$imagen);
        $sql->bindValue(7,$_POST["idarticulo"]);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->editar[]=$resultado;
        }
        return $this->editar;
    }

    //Fuction para Dsactivar Articulo
    public function desactivar($idarticulo){
        $conectar = Conectar::conexion();
        $sql = "update articulo set condicion = 0 where idarticulo = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$_POST["idarticulo"]);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->desactivar[]=$resultado;
        }
        return $this->desactivar;
    }

    //Fuction para Activar Articulo
    public function activar($idarticulo){
        $conectar = Conectar::conexion();
        $sql = "update articulo set condicion = 1 where idarticulo = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$_POST["idarticulo"]);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->activar[]=$resultado;
        }
        return $this->activar;
    }

    //Funcion para mostrar categoria por si idcategoria
    public function mostrar_por_id($idarticulo){
        $conectar = Conectar::conexion();
        $sql = "select * from articulo where idarticulo = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$_POST["idarticulo"]);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->mostrar_por_id[]=$resultado;
        }
        return $this->mostrar_por_id;
    }

       //Funcion para listar todas los Articulos
       public function mostrar(){
        $conectar=Conectar::conexion();
        $sql="select a.idarticulo, a.idcategoria, c.nombre as categoria, a.codigo, 
        a.nombre, a.stock, a.descripcion, a.imagen, a.condicion
        from articulo a INNER JOIN categoria c ON a.idcategoria = c.idcategoria";
        $sql=$conectar->prepare($sql);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->mostrar[]=$resultado;
        }
        return $this->mostrar;
    }

     //Funcion para listar todas los Articulos Activos
     public function mostraractivos(){
        $conectar=Conectar::conexion();
        $sql="select a.idarticulo, a.idcategoria, c.nombre as categoria, a.codigo, 
        a.nombre, a.stock, a.descripcion, a.imagen, a.condicion
        from articulo a INNER JOIN categoria c ON a.idcategoria = c.idcategoria
        where a.condicion=1";
        $sql=$conectar->prepare($sql);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->mostraractivos[]=$resultado;
        }
        return $this->mostraractivos;
    }

     //Funcion para implementar un metodo para listar los registro activos, su ultimo precio
     //su stock
     public function listarActivosVenta(){
        $conectar=Conectar::conexion();
        $sql="SELECT a.idarticulo, a.idcategoria, c.nombre as categoria, a.codigo, 
        a.nombre, a.stock,(SELECT precio_venta FROM detalle_ingreso 
        WHERE idarticulo = a.idarticulo ORDER BY iddetalle_ingreso desc limit 0,1) as precio_venta,
        a.descripcion, a.imagen, a.condicion
        from articulo a INNER JOIN categoria c ON a.idcategoria = c.idcategoria
        where a.condicion=1";
        $sql=$conectar->prepare($sql);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->listarActivosVentas[]=$resultado;
        }
        return $this->listarActivosVentas;
    }
}
