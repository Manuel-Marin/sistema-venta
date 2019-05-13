<?php 
session_start();
ob_start();
if (!isset($_SESSION["nombre"])){
  header("Location: login.html");
}else{
  require_once("./header.php");
  if ($_SESSION["acceso"]==1){
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
                          <h1 class="box-title">Permiso <button id="btnagregar" class="btn btn-success" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive"  id="listadoregistros">
                        <table class="table table-striped table-bordered table-condensed table-hover">
                          <thead class="">
                            <tr>
                              <th>nombre</th>
                            </tr>
                          </thead>
                          <tbody id="listar"></tbody>
                          <tfoot>
                            <th>nombre</th>                          
                          </tfoot>
                        </table>
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
<script src="./scripts/permiso.js"></script>
<?php
}
ob_end_flush();