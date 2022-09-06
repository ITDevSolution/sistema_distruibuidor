<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';
if ($_SESSION['zonas']==1)
{

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
                          <h1 class="box-title">Zona <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> <a href="../reportes/rptzonas.php" target="_blank"><button class="btn btn-info"><i class="fa fa-clipboard"></i> Reporte</button></a></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Zona ID</th>
                            <th>Nombre Zona</th>
                            <th>Distrito</th>
                            <th>referencia</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Zona ID</th>
                            <th>Nombre Zona</th>
                            <th>Distrito</th>
                            <th>referencia</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 100%;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="col-md-12">
                          <div class="form-group col-lg-4 col-md-6 col-sm-4 col-xs-12">
                            <label>Nombre:</label>
                            <input type="hidden" name="idzona" id="idzona">
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre de Zona" required>
                          </div>

                          <div class="form-group col-lg-2 col-md-6 col-sm-4 col-xs-12">
                            <label>Distrito</label>
                            <input type="text" class="form-control" name="distrito" id="distrito" maxlength="150" placeholder="Distrito">
                          </div>

                          <div class="form-group col-lg-12 col-md-6 col-sm-6 col-xs-12">
                            <label>Días de la semana:</label>
                            <ul style="list-style: none;" id="frecuencias">
                              
                            </ul>
                          </div>
                          

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Referencia:</label>
                            <textarea class="form-control" name="referencia" id="referencia" rows="5" cols="20"></textarea>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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
}
else
{
  require 'noacceso.php';
}
require 'footer.php';
?>
<script type="text/javascript" src="scripts/zona.js"></script>
<?php 
}
ob_end_flush();
?>