<?php 
session_start();
ob_start();
if (!isset($_SESSION["nombre"])){
  header("Location: login.html");
}else{
  require_once("./header.php");
  if ($_SESSION["compras"]==1){
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Ingreso <button id="btnagregar" class="btn btn-success" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive"  id="listadoregistros">
                        <table class="table table-striped table-bordered table-condensed table-hover">
                          <thead class="">
                            <tr>
                              <th>Opciones</th>
                              <th>Fecha</th>
                              <th>Proveedor</th>
                              <th>Usuario</th>
                              <th>Documento</th>
                              <th>Numero</th>
                              <th>Total Compra</th>
                              <th>Estado</th>
                            </tr>
                          </thead>
                          <tbody id="listarart"></tbody>
                          <tfoot>
                              <th>Opciones</th>
                              <th>Fecha</th>
                              <th>Proveedor</th>
                              <th>Usuario</th>
                              <th>Documento</th>
                              <th>Numero</th>
                              <th>Total Compra</th>
                              <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body table-responsive"  id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class=" form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <label >Proveedor:</label>
                            <input type="hidden" name="idingreso" id="idingreso" value="" >
                            <select name="idproveedor" id="idproveedor" class="selectpicker form-control " data-live-search="true"></select>
                          </div>
                          <div class=" form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label >Fecha(*):</label>
                            <input type="date" name="fecha_hora" id="fecha_hora" class="form-control" required>
                          </div>
                          <div class=" form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label >Tipo Comprobante(*):</label>
                           
                            <select name="tipo_comprobante" id="tipo_comprobante" class="form-control select-picker" required>
                                <option value="Boleta">Boleta</option>
                                <option value="Factura">Factura</option>
                                <option value="Ticket">Ticket</option>
                            </select>  
                          </div>
                          <div class=" form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label >Serie:</label>
                            <input type="text" name="serie_comprobante" id="serie_comprobante"
                            maxlength="7" placeholder="Serie" class="form-control" >
                          </div>
                          <div class=" form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label >Numero(*):</label>
                            <input type="text" name="num_comprobante" id="num_comprobante"
                            maxlength="10" placeholder="Numero" class="form-control" required>
                          </div>
                          <div class=" form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label >Impuesto(*):</label>
                            <input type="text" name="impuesto" id="impuesto"
                             class="form-control" required>
                          </div>
                          <div class=" form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a href="#myModal" data-toggle="modal">
                                <button id="btnAgregarArt" type="button" class="btn btn-primary">
                                    <span class="fa fa-plus"></span>Agregar Articulos</button>
                            </a>   
                          </div>
                          <div class=" form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                <thead style="background-color:#A9D0F5;">
                                    <th>Opciones</th>
                                    <th>Articulo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Compra</th>
                                    <th>Precio Venta</th>
                                    <th>Subtotal</th>
                                </thead>
                                <tfoot id="to">
                                    <th>Total</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">S/. .0.00</h4>
                                    <input type="hidden" name="total_compra" id="total_compra"></th>
                                </tfoot>
                                <tbody id="detalless"></tbody>
                            </table> 
                          </div>

                          <div class=" form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" >
                            <button class="btn btn-primary" id="btnGuardar" type="submit">
                              <i class="fa fa-save"></i>Guardar
                            </button>
                            <button class="btn btn-danger" onclick="cancelarform()" type="button" id="btnCancelar">
                              <i class="fa fa-arrow-circle-left"></i>Cancelar
                            </button>
                          </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

  <!--Inicio Modal-->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-tittle">Seleccione un Articulo</h4>           
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Opciones</th>
                        <th>Nombre</th>
                        <th>Categoria</th>
                        <th>Codigo</th>
                        <th>Stock</th>
                        <th>Imagen</th>
                    </thead>
                    <tbody id="listararticulos"></tbody>
                    <tfoot>
                    <thead>
                        <th>Opciones</th>
                        <th>Nombre</th>
                        <th>Categoria</th>
                        <th>Codigo</th>
                        <th>Stock</th>
                        <th>Imagen</th>
                    </thead>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
            </div>
        </div>
      </div>
    </div>
  <!--Fin-Modal-->

  
  <?php 
  }else{
    require_once("noacceso.php");
  }
require_once("./footer.php");
?>
<script src="./scripts/ingreso.js"></script>
<?php
}
ob_end_flush();