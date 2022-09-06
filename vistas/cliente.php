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
if ($_SESSION['clientes']==1)
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
                          <h1 class="box-title">Cliente <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> <a href="../reportes/rptclientes.php" target="_blank"><button class="btn btn-info"><i class="fa fa-clipboard"></i> Reporte</button></a></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Número</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Ubicación</th>
                            <th>zona</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Número</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Ubicación</th>
                            <th>zona</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 100%;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="col-md-8">
                          <div class="form-group col-lg-4 col-md-6 col-sm-4 col-xs-12">
                            <label>Nombre:</label>
                            <input type="hidden" name="idpersona" id="idpersona">
                            <input type="hidden" name="tipo_persona" id="tipo_persona" value="Cliente">
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre del Cliente" required>
                          </div>

                          <div class="form-group col-lg-4 col-md-6 col-sm-4 col-xs-12">
                            <label>Tipo Documento:</label>
                            <select class="form-control select-picker" name="tipo_documento" id="tipo_documento" required>
                              <option value="DNI">DNI</option>
                              <option value="RUC">RUC</option>
                              <option value="CEDULA">CEDULA</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-4 col-md-6 col-sm-4 col-xs-12">
                            <label>Número Documento:</label>
                            <input type="text" class="form-control" name="num_documento" id="num_documento" maxlength="20" placeholder="Documento">
                          </div>

                          <div class="form-group col-lg-4 col-md-6 col-sm-4 col-xs-12">
                            <label>Dirección:</label>
                            <input type="text" class="form-control" name="direccion" id="direccion" maxlength="70" placeholder="Dirección">
                          </div>
                          <div class="form-group col-lg-4 col-md-6 col-sm-4 col-xs-12">
                            <label>Teléfono:</label>
                            <input type="text" class="form-control" name="telefono" id="telefono" maxlength="20" placeholder="Teléfono">
                          </div>
                          <div class="form-group col-lg-4 col-md-6 col-sm-4 col-xs-12">
                            <label>Email:</label>
                            <input type="email" class="form-control" name="email" id="email" maxlength="50" placeholder="Email">
                          </div>

                          <div class="form-group col-lg-4 col-md-6 col-sm-4 col-xs-12">
                            <label>Ubicación:</label>
                            <input type="text" class="form-control" name="ubicacion" id="ubicacion" maxlength="200" placeholder="Ubicación">
                          </div>

                          <div class="form-group col-lg-4 col-md-6 col-sm-4 col-xs-12">
                            <label>Deuda Pendiente:</label>
                            <input type="number" class="form-control" name="deuda_pendiente" id="deuda_pendiente">
                          </div>

                          <div class="form-group col-lg-4 col-md-6 col-sm-4 col-xs-12">
                            <label>Anticipos:</label>
                            <input type="number" class="form-control" name="anticipos" id="anticipos">
                          </div>

                            <div class="form-group col-lg-4 col-md-6 col-sm-4 col-xs-12">
                              <label>Zona:</label>
                              <select id="idzona" name="idzona" class="form-control selectpicker" data-live-search="true">
                                
                              </select>
                            </div>
                          </div>

                          <div class="form-group col-lg-2 col-md-6 col-sm-2 col-xs-12">
                            <h1 type="text"><span class="label label-warning" id="deuda-label"></span></h1>
                            <h1 type="text"><span class="label label-success" id="anticipo-label"></span></h1>
                            <h1 type="text"><span class="label label-danger" id="deuda_actual-label"></span></h1>
                            
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
<script type="text/javascript" src="scripts/cliente.js"></script>
<?php 
}
ob_end_flush();
?>