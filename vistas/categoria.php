<?php 
session_start();
ob_start();
if (!isset($_SESSION["nombre"])){
  header("Location: login.html");
}else{
  require_once("./header.php");
  if ($_SESSION["almacen"]==1){
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
                          <h1 class="box-title">Categoria <button id="btnagregar" class="btn btn-success" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
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
                              <th>nombre</th>
                              <th>descripcion</th>
                              <th>estado</th>
                            </tr>
                          </thead>
                          <tbody id="listarcat"></tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>nombre</th>
                            <th>descripcion</th>
                            <th>estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body table-responsive"  id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class=" form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label >Nombre:</label>
                            <input type="hidden" name="idcategoria" id="idcategoria" >
                            <input type="text" name="nombre" id="nombre" maxlength="50" placeholder="Nombre" class="form-control" required>
                          </div>
                          <div class=" form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label >Descripcion:</label>
                            <input type="text" name="descripcion" id="descripcion" maxlength="50" placeholder="Nombre" class="form-control">
                          </div>
                          <div class=" form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <button class="btn btn-primary" id="btnGuardar" type="submit">
                              <i class="fa fa-save"></i>Guardar
                            </button>
                            <button class="btn btn-danger" onclick="cancelarform()" type="button">
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

  
  <?php 
  }else{
    require_once("noacceso.php");
  }
require_once("./footer.php");
?>
<script src="./scripts/categoria.js"></script>
<?php
}
ob_end_flush();