<?php
include("sesion.php");
$idPagina = 121;
include(RUTA_PROYECTO . "includes/verificar-paginas.php");
include(RUTA_PROYECTO . "includes/head.php");
$busqueda='';
$filtro='';
if (!empty($_GET['search'])) {
    $busqueda = $_GET['search'];
    $filtro = "AND (
    ccat_id LIKE '%".$busqueda."%' 
    OR ccat_nombre LIKE '%".$busqueda."%' 
    OR cliAdmi_nombre LIKE '%".$busqueda."%' 
    )";
}
?>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- JQVMap -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/jqvmap/jqvmap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>dist/css/adminlte.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/daterangepicker/daterangepicker.css">
<!-- summernote -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/summernote/summernote-bs4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <?php include(RUTA_PROYECTO . "includes/carga.php"); ?>

    <?php include(RUTA_PROYECTO . "includes/encabezado.php"); ?>

    <?php include(RUTA_PROYECTO . "includes/menu.php"); ?>

    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?= REDIRECT_ROUTE ?>modules/index.php">Dashboard</a></li>
                <li class="breadcrumb-item active"><?= $paginaActual['pag_nombre'] ?></li>
              </ol>
            </div>
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <section class="content-header">
        <div class="container-fluid">
          <h2 class="text-center display-4"><?= $paginaActual['pag_nombre'] ?></h2>
        </div>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-8 offset-md-2">
              <form action="buscador.php">
                <div class="input-group input-group-lg">
                  <input type="search" name="search" class="form-control form-control-lg" placeholder="Puede buscar lo que necesite desde aquí" value="<?= $busqueda ?>">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-lg btn-default">
                      <i class="fa fa-search"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-10 offset-md-1">
              <div class="list-group">
                <div class="list-group-item">
                  <div class="row">
                    <div class="col-auto">
                      <img class="img-fluid" src="<?= REDIRECT_ROUTE ?>files/default.png" alt="Photo" style="max-height: 160px;">
                    </div>
                    <div class="col px-4">
                      <div>
                        <div class="float-right"><?= date("Y-m-d h:i A") ?></div>
                        <h3>Lorem ipsum dolor sit amet</h3>
                        <p class="mb-0">consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include(RUTA_PROYECTO . "includes/footer.php"); ?>
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
  </div>
  <!-- jQuery -->
  <script src="<?= REDIRECT_ROUTE ?>plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?= REDIRECT_ROUTE ?>plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="<?= REDIRECT_ROUTE ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="<?= REDIRECT_ROUTE ?>plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="<?= REDIRECT_ROUTE ?>plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="<?= REDIRECT_ROUTE ?>plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="<?= REDIRECT_ROUTE ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="<?= REDIRECT_ROUTE ?>plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="<?= REDIRECT_ROUTE ?>plugins/moment/moment.min.js"></script>
  <script src="<?= REDIRECT_ROUTE ?>plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="<?= REDIRECT_ROUTE ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="<?= REDIRECT_ROUTE ?>plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="<?= REDIRECT_ROUTE ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= REDIRECT_ROUTE ?>dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?= REDIRECT_ROUTE ?>dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="<?= REDIRECT_ROUTE ?>dist/js/pages/dashboard.js"></script>
  <?php include(RUTA_PROYECTO . "includes/pie.php"); ?>
</body>

</html>