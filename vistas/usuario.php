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
                          <h1 class="box-title">Usuario <button id="btnagregar" class="btn btn-success" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
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
                              <th>Documento</th>
                              <th>Numero</th>
                              <th>Telefono</th>
                              <th>Email</th>
                              <th>Login</th>
                              <th>Foto</th>
                              <th>Estado</th>
                            </tr>
                          </thead>
                          <tbody id="listar"></tbody>
                          <tfoot>
                              <th>Opciones</th>
                              <th>nombre</th>
                              <th>Documento</th>
                              <th>Numero</th>
                              <th>Telefono</th>
                              <th>Email</th>
                              <th>Login</th>
                              <th>Foto</th>
                              <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body table-responsive"  id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class=" form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label >Nombre(*):</label>
                            <input type="hidden" name="idusuario" id="idusuario" >
                            <input type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" class="form-control" required>
                          </div>
                          <div class=" form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label >Tipo Documento(*):</label>
                            <select name="tipo_documento" id="tipo_documento" class="select-picker form-control" required>
                                <option value="DNI">DNI</option>
                                <option value="RUC">RUC</option>
                                <option value="CEDULA">CEDULA</option>
                            </select>
                          </div>
                          <div class=" form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label >Numero(*):</label>
                            <input type="text" name="num_documento" id="num_documento" maxlength="20" placeholder="Documento" class="form-control" required>
                          </div>
                          <div class=" form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label >Direccion:</label>
                            <input type="text" name="direccion" id="direccion" maxlength="70" placeholder="Direccion" class="form-control" >
                          </div>
                          <div class=" form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label >Telefono:</label>
                            <input type="text" name="telefono" id="telefono" maxlength="20" placeholder="Telefono" class="form-control" >
                          </div>
                          <div class=" form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label >Email:</label>
                            <input type="email" name="email" id="email" maxlength="50" placeholder="Email" class="form-control" >
                          </div>
                          <div class=" form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label >Cargo:</label>
                            <input type="text" name="cargo" id="cargo" maxlength="20" placeholder="Cargo" class="form-control" >
                          </div>
                          <div class=" form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label >Login(*):</label>
                            <input type="text" name="login" id="login" maxlength="20" placeholder="Login" class="form-control" required>
                          </div>
                          <div class=" form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label >Clave(*):</label>
                            <input type="password" name="clave" id="clave" maxlength="64" placeholder="Contraseña" class="form-control" required>
                          </div>
                          <div class=" form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label >Permisos(*):</label>
                           <ul style="list-style:none;" id="permisos"></ul>
                          </div>
                          <div class=" form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label >Imagen:</label>
                            <input type="file" name="imagen" id="imagen" class="form-control">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <img src="" width="150px" height="120px" id="imagenmuestra">
                          </div>
                          <div class=" form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
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

<script src="./scripts/usuario.js"></script>
<?php
}
ob_end_flush();