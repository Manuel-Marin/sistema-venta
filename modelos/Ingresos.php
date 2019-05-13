<?php


class Ingresos extends Conectar{

    private $agregar = array();
    private $desactivar = array();
    private $mostrar_por_id = array();
    private $mostrar = array();
    private $listarDetalle = array();
 

    //fuction para Agregar Ingreso
    public function agregar($idproveedor,$idusuario,$tipo_comprobante,
                    $serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,
                    $total_compra,$idarticulo,$cantidad,$precio_compra,$precio_venta){
        $conectar = Conectar::conexion();
        $sql = "insert into ingreso values(null,?,?,?,?,?,?,?,?,'Aceptado')";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1,$_POST["idproveedor"]);
        $sql->bindValue(2,$_SESSION["idusuario"]);
        $sql->bindValue(3,$_POST["tipo_comprobante"]);
        $sql->bindValue(4,$_POST["serie_comprobante"]);
        $sql->bindValue(5,$_POST["num_comprobante"]);
        $sql->bindValue(6,$_POST["fecha_hora"]);
        $sql->bindValue(7,$_POST["impuesto"]);
        $sql->bindValue(8,$_POST["total_compra"]);
        $sql->execute();

        //$resultado = $sql->fetch();
        //return $resultado;

        $idingresonew = $conectar->lastInsertId();
        $num_elementos= 0;
        $sw=true;
        $id=$_POST["idarticulo"];
        $cant=$_POST["cantidad"];
        $prec=$_POST["precio_compra"];
        $prev=$_POST["precio_venta"];

        while ($num_elementos < count($_POST["idarticulo"])) {

            $sql_detalle = "insert into detalle_ingreso(idingreso,idarticulo,cantidad,precio_compra,precio_venta)
            values('$idingresonew','$id[$num_elementos]','$cant[$num_elementos]','$prec[$num_elementos]','$prev[$num_elementos]')";
            $sql_detalle = $conectar->prepare($sql_detalle);
            $sql_detalle->execute() or $sw=false;
            $num_elementos = $num_elementos + 1;
        }
        return $sw;
    }

   

    //anular ingreso
    public function anular($idingreso){
        $conectar = Conectar::conexion();
        $sql = "update ingreso set estado = 'Anulado' where idingreso = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$_POST["idingreso"]);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->desactivar[]=$resultado;
        }
        return $this->desactivar;
    }



    //Funcion para mostrar por por su idingreso
    public function mostrar_por_id($idingreso){
        $conectar = Conectar::conexion();
        $sql = "SELECT i.idingreso, DATE(i.fecha_hora) as fecha, i.idproveedor,
        p.nombre as proveedor, u.idusuario, u.nombre as usuario, i.tipo_comprobante,
        i.serie_comprobante, i.num_comprobante,i.total_compra,i.impuesto,i.estado
        FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona
        INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE i.idingreso = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$_POST["idingreso"]);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->mostrar_por_id[]=$resultado;
        }
        return $this->mostrar_por_id;
    }

    //funcion listar detalle
    public function listarDetalle($id){
        $conectar = Conectar::conexion();
        $sql = "SELECT di.idingreso, di.idarticulo, a.nombre, di.cantidad, di.precio_compra, di.precio_venta
        FROM detalle_ingreso di INNER JOIN articulo a ON di.idarticulo = a.idarticulo
        WHERE di.idingreso = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$id);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->listarDetalle[]=$resultado;
        }
        return $this->listarDetalle;
    }

       //Funcion para listar todos los Ingresos
       public function mostrar(){
        $conectar=Conectar::conexion();
        $sql="SELECT i.idingreso, DATE(i.fecha_hora) as fecha, i.idproveedor,
        p.nombre as proveedor, u.idusuario, u.nombre as usuario, i.tipo_comprobante,
        i.serie_comprobante, i.num_comprobante,i.total_compra,i.impuesto,i.estado
        FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona
        INNER JOIN usuario u ON i.idusuario=u.idusuario
        ORDER BY i.idingreso desc";
        $sql=$conectar->prepare($sql);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->mostrar[]=$resultado;
        }
        return $this->mostrar;
    }

        

  

   
}

