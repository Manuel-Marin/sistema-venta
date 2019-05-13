<?php 

class Ventas extends Conectar{

    private $agregar = array();
    private $editar = array();
    private $desactivar = array();
    private $activar = array();
    private $mostrar_por_id = array();
    private $mostrar = array();
    private $listarDetalle = array();
    private $anular = array();

 
    //Implementamos un método para insertar registros
    public function agregar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$idarticulo,$cantidad,$precio_venta,$descuento)
    {
        $conectar = Conectar::conexion();
        $sql="INSERT INTO venta (idcliente,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_venta,estado)
        VALUES ('$idcliente','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_venta','Aceptado')";
        //return ejecutarConsulta($sql);
        $sql = $conectar->prepare($sql);
        $sql->execute();
        
        $idventanew=$conectar->lastInsertId();
        $num_elementos=0;
        $sw=true;
 
        while ($num_elementos < count($idarticulo))
        {
            $sql_detalle = "INSERT INTO detalle_venta(idventa, idarticulo,cantidad,precio_venta,descuento) VALUES ('$idventanew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]')";
            $sql_detalle = $conectar->prepare($sql_detalle);
            $sql_detalle->execute() or $sw = false;
            
            $num_elementos=$num_elementos + 1;
        }
 
        return $sw;
    }
 
     
    //Implementamos un método para anular la venta
    public function anular($idventa)
    {
        $conectar = Conectar::conexion();
        $sql="UPDATE venta SET estado='Anulado' WHERE idventa='$idventa'";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->anular[]=$resultado;
        }
        return $this->anular;
    }
 
 
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar_por_id($idventa)
    {
        $conectar = Conectar::conexion();
        $sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->mostrar_por_id[]=$resultado;
        }
        return $this->mostrar_por_id;
    }
 
    public function listarDetalle($idventa)
    {
        $conectar = Conectar::conexion();
        $sql="SELECT dv.idventa,dv.idarticulo,a.nombre,dv.cantidad,dv.precio_venta,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal FROM detalle_venta dv inner join articulo a on dv.idarticulo=a.idarticulo where dv.idventa='$idventa'";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        while ($resultado = $sql->fetch()) {
            $this->listarDetalle[]=$resultado;
        }
        return $this->listarDetalle;
    }
 
    //Implementar un método para listar los registros
    public function mostrar()
    {
        $conectar = Conectar::conexion();
        $sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario ORDER by v.idventa desc";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        
        while ($resultado = $sql->fetch()) {
            $this->mostrar[]=$resultado;
        }
        return $this->mostrar;     
    }
     
}
?>