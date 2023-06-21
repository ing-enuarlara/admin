<?php
include("../../sesion.php");

$idPagina = 40;

include(RUTA_PROYECTO."includes/verificar-paginas.php");
include(RUTA_PROYECTO."includes/head.php");
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
                      <li class="breadcrumb-item"><a href="<?=REDIRECT_ROUTE?>modules/pagina-web/bd_read/configuracion.php">Ver Configuracion</a></li>
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
                        <div class="card card-success">
                            <div class="card-header">
                                <h5 class="float-sm-right"><?=$paginaActual['pag_nombre']?></h5>
                            </div>
                            <!-- /.card-header -->
                            <?php

                            $consultaConfigColor = $conexionBdGeneral->query("SELECT * FROM general_color_store WHERE gcs_id_empresa='".$configuracion['conf_id_empresa']."'");
                            $configuracionColor = mysqli_fetch_array($consultaConfigColor, MYSQLI_BOTH);

                            ?>
                            <!-- form start -->
                            <form class="form-horizontal" method="post" action="../bd_update/configuracion-color-actualizar.php" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?=$configuracion['conf_id_empresa']?>">

                                <div class="card-body">

                                    <!-- Color Picker -->
                                    <div class="form-group col-md-3">
                                        <label>Encabezado Primario:</label>
                                        <div class="input-group my-colorpicker2">
                                            <input type="color" class="form-control" name="encaPrimario" value="<?=$configuracionColor['gcs_encaPrimario'];?>">
                                            <div class="input-group-append">
                                              <span class="input-group-text"></span>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->

                                    <!-- Color Picker -->
                                    <div class="form-group col-md-3">
                                        <label>Encabezado Secundario:</label>
                                        <div class="input-group my-colorpicker2">
                                            <input type="color" class="form-control" name="encaSecundario" value="<?=$configuracionColor['gcs_encaSecundario'];?>">
                                            <div class="input-group-append">
                                              <span class="input-group-text"></span>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->

                                    <!-- Color Picker -->
                                    <div class="form-group col-md-3">
                                        <label>Letras Encabezado:</label>
                                        <div class="input-group my-colorpicker2">
                                            <input type="color" class="form-control" name="encaLetras" value="<?=$configuracionColor['gcs_encaLetras'];?>">
                                            <div class="input-group-append">
                                              <span class="input-group-text"></span>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->

                                    <!-- Color Picker -->
                                    <div class="form-group col-md-3">
                                        <label>Bordes Encabezado:</label>
                                        <div class="input-group my-colorpicker2">
                                            <input type="color" class="form-control" name="encaBorder" value="<?=$configuracionColor['gcs_encaBorder'];?>">
                                            <div class="input-group-append">
                                              <span class="input-group-text"></span>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->

                                    <!-- Color Picker -->
                                    <div class="form-group col-md-3">
                                        <label>Fondo Navegación:</label>
                                        <div class="input-group my-colorpicker2">
                                            <input type="color" class="form-control" name="paginaFondo" value="<?=$configuracionColor['gcs_paginaFondo'];?>">
                                            <div class="input-group-append">
                                              <span class="input-group-text"></span>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->

                                    <!-- Color Picker -->
                                    <div class="form-group col-md-3">
                                        <label>Letras Navegación:</label>
                                        <div class="input-group my-colorpicker2">
                                            <input type="color" class="form-control" name="paginaLetras" value="<?=$configuracionColor['gcs_paginaLetras'];?>">
                                            <div class="input-group-append">
                                              <span class="input-group-text"></span>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->

                                    <!-- Color Picker -->
                                    <div class="form-group col-md-3">
                                        <label>Fondo Body:</label>
                                        <div class="input-group my-colorpicker2">
                                            <input type="color" class="form-control" name="bodyFondo" value="<?=$configuracionColor['gcs_bodyFondo'];?>">
                                            <div class="input-group-append">
                                              <span class="input-group-text"></span>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->

                                    <!-- Color Picker -->
                                    <div class="form-group col-md-3">
                                        <label>Letras Body:</label>
                                        <div class="input-group my-colorpicker2">
                                            <input type="color" class="form-control" name="bodyLetras" value="<?=$configuracionColor['gcs_bodyLetras'];?>">
                                            <div class="input-group-append">
                                              <span class="input-group-text"></span>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->

                                    <!-- Color Picker -->
                                    <div class="form-group col-md-3">
                                        <label>Lineas:</label>
                                        <div class="input-group my-colorpicker2">
                                            <input type="color" class="form-control" name="bodyLineas" value="<?=$configuracionColor['gcs_bodyLineas'];?>">
                                            <div class="input-group-append">
                                              <span class="input-group-text"></span>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->

                                    <!-- Color Picker -->
                                    <div class="form-group col-md-3">
                                        <label>Boton Primario:</label>
                                        <div class="input-group my-colorpicker2">
                                            <input type="color" class="form-control" name="bottonPrimario" value="<?=$configuracionColor['gcs_bottonPrimario'];?>">
                                            <div class="input-group-append">
                                              <span class="input-group-text"></span>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->

                                    <!-- Color Picker -->
                                    <div class="form-group col-md-3">
                                        <label>Boton Secundario:</label>
                                        <div class="input-group my-colorpicker2">
                                            <input type="color" class="form-control" name="bottonSecundario" value="<?=$configuracionColor['gcs_bottonSecundario'];?>">
                                            <div class="input-group-append">
                                              <span class="input-group-text"></span>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->

                                    <!-- Color Picker -->
                                    <div class="form-group col-md-3">
                                        <label>Iconos:</label>
                                        <div class="input-group my-colorpicker2">
                                            <input type="color" class="form-control" name="bodyIconos" value="<?=$configuracionColor['gcs_bodyIconos'];?>">
                                            <div class="input-group-append">
                                              <span class="input-group-text"></span>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->

                                    <!-- Color Picker -->
                                    <div class="form-group col-md-3">
                                        <label>Fondo Suscripcion:</label>
                                        <div class="input-group my-colorpicker2">
                                            <input type="color" class="form-control" name="suscripcionFondo" value="<?=$configuracionColor['gcs_suscripcionFondo'];?>">
                                            <div class="input-group-append">
                                              <span class="input-group-text"></span>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->

                                    <!-- Color Picker -->
                                    <div class="form-group col-md-3">
                                        <label>Letras Suscripcion:</label>
                                        <div class="input-group my-colorpicker2">
                                            <input type="color" class="form-control" name="suscripcionLetras" value="<?=$configuracionColor['gcs_suscripcionLetras'];?>">
                                            <div class="input-group-append">
                                              <span class="input-group-text"></span>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->

                                    <!-- Color Picker -->
                                    <div class="form-group col-md-3">
                                        <label>Footer Primario:</label>
                                        <div class="input-group my-colorpicker2">
                                            <input type="color" class="form-control" name="footerPrimario" value="<?=$configuracionColor['gcs_footerPrimario'];?>">
                                            <div class="input-group-append">
                                              <span class="input-group-text"></span>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->

                                    <!-- Color Picker -->
                                    <div class="form-group col-md-3">
                                        <label>Footer Secundario:</label>
                                        <div class="input-group my-colorpicker2">
                                            <input type="color" class="form-control" name="footerSecundario" value="<?=$configuracionColor['gcs_footerSecundario'];?>">
                                            <div class="input-group-append">
                                              <span class="input-group-text"></span>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->

                                    <!-- Color Picker -->
                                    <div class="form-group col-md-3">
                                        <label>Letras Footer:</label>
                                        <div class="input-group my-colorpicker2">
                                            <input type="color" class="form-control" name="footerLetras" value="<?=$configuracionColor['gcs_footerLetras'];?>">
                                            <div class="input-group-append">
                                              <span class="input-group-text"></span>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->

                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Cambiar Color</button>
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
<!-- bs-custom-file-input -->
<script src="<?=REDIRECT_ROUTE?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
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
  bsCustomFileInput.init();
});
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#fechaIni').datetimepicker({
        format: 'L'
    });
    $('#fechaFin').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
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

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

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