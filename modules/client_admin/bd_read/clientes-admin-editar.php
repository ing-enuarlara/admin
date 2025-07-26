<?php
include("../../sesion.php");

$idPagina = 16;

include(RUTA_PROYECTO."includes/verificar-paginas.php");
include(RUTA_PROYECTO."includes/head.php");

try{
  $consuluta= $conexionBdAdmin->query("SELECT * FROM clientes_admin WHERE cliAdmi_id='".$_GET["id"]."'");
} catch (Exception $e) {
  include(RUTA_PROYECTO."includes/error-catch-to-report.php");
}
$resultadoD = mysqli_fetch_array($consuluta, MYSQLI_BOTH);
?>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/fontawesome-free/css/all.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/dropzone/min/dropzone.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=REDIRECT_ROUTE?>dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    
    <?php include(RUTA_PROYECTO."includes/carga.php"); ?>

    <?php include(RUTA_PROYECTO."includes/encabezado.php"); ?>
    
    <?php include(RUTA_PROYECTO."includes/menu.php"); ?>
    
    <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-12">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="<?=REDIRECT_ROUTE?>modules/index.php">Dashboard</a></li>
                      <li class="breadcrumb-item"><a href="<?=REDIRECT_ROUTE?>modules/client_admin/bd_read/clientes-admin.php">Ver Clientes AdminZEFE</a></li>
                      <li class="breadcrumb-item active"><?=$paginaActual['pag_nombre']?></li>
                  </ol>
                  </div><!-- /.col -->
              </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h5 class="float-sm-right"><?=$paginaActual['pag_nombre']?></h5>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form class="form-horizontal" method="post" action="../bd_update/clientes-admin-actualizar.php">
                                <input type="hidden" name="id" id="idEmpresa" value="<?=$_GET["id"];?>">
                                <input type="hidden" name="ussPrincipal" value="<?=$resultadoD['cliAdmi_id_uss_principal']?>">
                                <div class="card-body">
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1">Empresa:</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Empresa" name="nombre" value="<?=$resultadoD['cliAdmi_nombre']?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Email:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="email" class="form-control" placeholder="Email" name="email" value="<?=$resultadoD['cliAdmi_email']?>">
                                        </div>
                                    </div>
                                    <!-- phone mask -->
                                    <div class="form-group col-md-6">
                                        <label>Telefono:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Telefono" name="telefono" value="<?=$resultadoD['cliAdmi_telefono']?>">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1">Contacto Principal:</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Contacto Principal" name="contacto" value="<?=$resultadoD['cliAdmi_contacto_principal']?>">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputEmail1">Nº Cedula o NIT:</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nº Cedula o NIT" name="cedula" value="<?=$resultadoD['cliAdmi_documento']?>">
                                    </div>
                                    <!-- /.form group -->
                                    <div class="form-group col-md-6">
                                        <label>Modulos:</label>
                                        <select class="select2" multiple="multiple" data-placeholder="Escoge los modulos" style="width: 100%;" name="modulo[]" id="modulo" onchange="traerSubModulos()">
                                            <option value=""></option>
                                                <?php
                                                try{
                                                  $conOp = $conexionBdSistema->query("SELECT * FROM sistema_modulos WHERE mod_id != 1 AND (mod_padre IS NULL OR mod_padre='')");
                                                } catch (Exception $e) {
                                                  include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                                }
                                                while($resOp = mysqli_fetch_array($conOp, MYSQLI_BOTH)){
                                                    try{
                                                      $consultaModulos=$conexionBdAdmin->query("SELECT * FROM modulos_clien_admin WHERE mxca_id_cliAdmin='".$resultadoD['cliAdmi_id']."' AND mxca_id_modulo='".$resOp['mod_id']."'");
                                                    } catch (Exception $e) {
                                                      include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                                    }
                                                    $numZ = $consultaModulos->num_rows;
                                                ?>
                                                    <option value="<?=$resOp['mod_id'];?>"<?php if($numZ>0){echo "selected";}?> ><?=$resOp['mod_nombre'];?></option>
                                                <?php
                                                }
                                                ?>
                                        </select>
                                        <span id="mensajeM" style="color: #6017dc; display:none;">Espere un momento por favor.</span>
                                    </div>

                                    <div class="form-group col-md-6" id="subModulos-container" style="display:none;">
                                      <label>Sub-Modulos:</label>
                                      <select class="select2" multiple="multiple" data-placeholder="Escoge los subModulos" style="width: 100%;" name="subModulos[]" id="subModulos" onchange="traerItemSubModulos()" disabled>
                                      </select>
                                      <script type="application/javascript">
                                        $(document).ready(traerSubModulos(document.getElementById('modulo')));

                                        function traerSubModulos(enviada) {
                                          var modulo = $('#modulo').val();
                                          var idEmpresa = $('#idEmpresa').val();
                                          document.getElementById('subModulos').removeAttribute('disabled');

                                          datos = "modulos=" + (modulo) + "&idEmpresa=" + (idEmpresa) + "&opcion=1";
                                          $('#mensajeM').show();
                                          $.ajax({
                                            type: "POST",
                                            url: "../../../ajax/ajax-traer-sub-modulos.php",
                                            data: datos,
                                            success: function(response) {
                                              $('#subModulos').empty();
                                              $('#subModulos').append(response);
                                              traerItemSubModulos(document.getElementById('subModulos'))
                                            }
                                          });
                                        }
                                      </script>
                                      <span id="mensajeSM" style="color: #6017dc; display:none;">Espere un momento por favor.</span>
                                    </div>

                                    <div class="form-group col-md-6" id="itemSubModulos-container" style="display:none;">
                                      <label>Items Sub-Modulos:</label>
                                      <select class="select2" multiple="multiple" data-placeholder="Escoge los Items de los subModulos" style="width: 100%;" name="itemSubModulos[]" id="itemSubModulos" disabled>
                                      </select>
                                      <script type="application/javascript">
                                        function traerItemSubModulos(enviada) {
                                          var subModulos = $('#subModulos').val();
                                          var idEmpresa = $('#idEmpresa').val();
                                          document.getElementById('itemSubModulos').removeAttribute('disabled');

                                          datos = "subModulos=" + (subModulos) + "&idEmpresa=" + (idEmpresa) + "&opcion=2";
                                          $('#mensajeSM').show();
                                          $.ajax({
                                            type: "POST",
                                            url: "../../../ajax/ajax-traer-sub-modulos.php",
                                            data: datos,
                                            success: function(response) {
                                              $('#itemSubModulos').empty();
                                              $('#itemSubModulos').append(response);
                                            }
                                          });
                                        }
                                      </script>
                                    </div>
                                    <!-- Date -->
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1">Fecha Inicio:</label>
                                        <input type="date" class="form-control" id="exampleInputEmail1" placeholder="Aviso Previo" name="fechaIni" value="<?=$resultadoD['cliAdmi_fecha_inicio']?>">
                                    </div>
                                    <!-- Date -->
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1">Fecha Final:</label>
                                        <input type="date" class="form-control" id="exampleInputEmail1" placeholder="Aviso Previo" name="fechaFin" value="<?=$resultadoD['cliAdmi_fecha_fin']?>">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputEmail1">Aviso Previo:</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Aviso Previo" name="aviPrev" value="<?=$resultadoD['cliAdmi_aviso_previo']?>">
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.column -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
    </div>
    <?php include(RUTA_PROYECTO."includes/footer.php"); ?>
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
  </div>
<!-- jQuery -->
<script src="<?=REDIRECT_ROUTE?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=REDIRECT_ROUTE?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="<?=REDIRECT_ROUTE?>plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="<?=REDIRECT_ROUTE?>plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="<?=REDIRECT_ROUTE?>plugins/moment/moment.min.js"></script>
<script src="<?=REDIRECT_ROUTE?>plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="<?=REDIRECT_ROUTE?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?=REDIRECT_ROUTE?>plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=REDIRECT_ROUTE?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="<?=REDIRECT_ROUTE?>plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="<?=REDIRECT_ROUTE?>plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="<?=REDIRECT_ROUTE?>plugins/dropzone/min/dropzone.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=REDIRECT_ROUTE?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=REDIRECT_ROUTE?>dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    /*Date picker
    $('#fechaIni').datetimepicker({
        format: 'L'
    });
    $('#fechaFin').datetimepicker({
        format: 'L'
    });*/
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

  })
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })

  // DropzoneJS Demo Code Start
  Dropzone.autoDiscover = false

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector("#template")
  previewNode.id = ""
  var previewTemplate = previewNode.parentNode.innerHTML
  previewNode.parentNode.removeChild(previewNode)

  var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "/target-url", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
  })

  myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
  })

  // Update the total progress bar
  myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
  })

  myDropzone.on("sending", function(file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1"
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
  })

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone.on("queuecomplete", function(progress) {
    document.querySelector("#total-progress").style.opacity = "0"
  })

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
  }
  document.querySelector("#actions .cancel").onclick = function() {
    myDropzone.removeAllFiles(true)
  }
  // DropzoneJS Demo Code End
</script>
  <?php include(RUTA_PROYECTO."includes/pie.php"); ?>
</body>
</html>