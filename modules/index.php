<?php
  include("sesion.php"); 
  if(!empty($_GET['search'])){
    $urlRed = REDIRECT_ROUTE;
    header("Location:".$urlRed."modules/buscador.php?search=".$_GET['search']);
    exit();
  }
  $idPagina = 1;
  include(RUTA_PROYECTO."includes/verificar-paginas.php");
  include(RUTA_PROYECTO."includes/head.php");
?>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- JQVMap -->
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/jqvmap/jqvmap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>dist/css/adminlte.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/daterangepicker/daterangepicker.css">
<!-- summernote -->
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/summernote/summernote-bs4.min.css">
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
                  <div class="col-sm-6">
                      <h2 class="breadcrumb-item active"><?=$paginaActual['pag_nombre']?></h2>
                  </div><!-- /.col -->
              </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              
              <?php
              $where="";
              if($datosUsuarioActual['usr_tipo']!=1){
                  $where= "WHERE factura_id_empresa='".$configuracion['conf_id_empresa']."'";
              }
              try{
                $facturas= $conexionBdComercial->query("SELECT * FROM comercial_facturas $where");
              } catch (Exception $e) {
                include(RUTA_PROYECTO."includes/error-catch-to-report.php");
              }
              $numFact = $facturas->num_rows;
              ?>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?=$numFact;?></h3>
                    <p>Facturas</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="<?=REDIRECT_ROUTE?>modules/comercial/bd_read/facturacion.php" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <?php
              $where="";
              if($datosUsuarioActual['usr_tipo']!=1){
                  $where= "WHERE cotiz_id_empresa='".$configuracion['conf_id_empresa']."'";
              }
              try{
                $cotizaciones= $conexionBdComercial->query("SELECT * FROM comercial_cotizaciones $where");
              } catch (Exception $e) {
                include(RUTA_PROYECTO."includes/error-catch-to-report.php");
              }
              $numCotiz = $cotizaciones->num_rows;
              ?>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3><?=$numCotiz;?></h3>
                    <p>Cotizaciones</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="<?=REDIRECT_ROUTE?>modules/comercial/bd_read/cotizaciones.php" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <?php
              $where="";
              if($datosUsuarioActual['usr_tipo']!=1){
                  $where= "WHERE pedid_id_empresa='".$configuracion['conf_id_empresa']."'";
              }
              try{
                $pedidos= $conexionBdComercial->query("SELECT * FROM comercial_pedidos $where");
              } catch (Exception $e) {
                include(RUTA_PROYECTO."includes/error-catch-to-report.php");
              }
              $numPedid = $pedidos->num_rows;
              ?>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3><?=$numPedid;?></h3>
                    <p>Pedidos</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="<?=REDIRECT_ROUTE?>modules/comercial/bd_read/pedidos.php" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <?php
              $where="";
              if($datosUsuarioActual['usr_tipo']!=1){
                  $where= "WHERE remi_id_empresa='".$configuracion['conf_id_empresa']."'";
              }
              try{
                $remisiones= $conexionBdComercial->query("SELECT * FROM comercial_remisiones $where");
              } catch (Exception $e) {
                include(RUTA_PROYECTO."includes/error-catch-to-report.php");
              }
              $numRemi = $remisiones->num_rows;
              ?>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3><?=$numRemi;?></h3>
                    <p>Remisiones</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="<?=REDIRECT_ROUTE?>modules/comercial/bd_read/remisiones.php" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              
              <?php
              $where="";
              if($datosUsuarioActual['usr_tipo']!=1){
                  $where= "WHERE cli_id_empresa='".$configuracion['conf_id_empresa']."'";
              }
              try{
                $clientes= $conexionBdComercial->query("SELECT * FROM comercial_clientes $where");
              } catch (Exception $e) {
                include(RUTA_PROYECTO."includes/error-catch-to-report.php");
              }
              $numCli = $clientes->num_rows;
              ?>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3><?=$numCli;?></h3>
                    <p>Clientes Registrados</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-briefcase"></i>
                  </div>
                  <a href="<?=REDIRECT_ROUTE?>modules/comercial/bd_read/clientes.php" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <?php
              $where="";
              if($datosUsuarioActual['usr_tipo']!=1){
                  $where= "WHERE usr_id_empresa='".$configuracion['conf_id_empresa']."'";
              }
              try{
                $usuarios= $conexionBdAdministrativo->query("SELECT * FROM administrativo_usuarios $where");
              } catch (Exception $e) {
                include(RUTA_PROYECTO."includes/error-catch-to-report.php");
              }
              $numUser = $usuarios->num_rows;
              ?>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3><?=$numUser;?></h3>
                    <p>Usuarios Registrados</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="<?=REDIRECT_ROUTE?>modules/administrativo/bd_read/usuarios.php" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <?php
              //CONSULTA PARA VISITAS A LA PAGINA
              ?>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>10</h3>
                    <p>Visitas a la pagina</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-earth"></i>
                  </div>
                  <a href="<?=REDIRECT_ROUTE?>modules/" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              
              <?php
              if($datosUsuarioActual['usr_tipo']==1){
                try{
                  $clientesAdmin= $conexionBdAdmin->query("SELECT * FROM clientes_admin");
                } catch (Exception $e) {
                  include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                }
                $cliAdmin = $clientesAdmin->num_rows;
              ?>
                <div class="col-lg-3 col-6">
                  <div class="small-box bg-info">
                    <div class="inner">
                      <h3><?=$cliAdmin;?></h3>
                      <p>Clientes adminZEFE</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-person-stalker"></i>
                    </div>
                    <a href="<?=REDIRECT_ROUTE?>modules/client_admin/bd_read/clientes-admin.php" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
              <?php
                }
              ?>
            </div>

            <div class="row">
              <section class="col-lg-7 connectedSortable">
              </section>

              <section class="col-lg-5 connectedSortable">
              </section>
            </div>
          </div>
        </section>
      </div>
      <?php include(RUTA_PROYECTO."includes/footer.php"); ?>
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
    </div>
    <!-- jQuery -->
    <script src="<?=REDIRECT_ROUTE?>plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?=REDIRECT_ROUTE?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?=REDIRECT_ROUTE?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="<?=REDIRECT_ROUTE?>plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="<?=REDIRECT_ROUTE?>plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="<?=REDIRECT_ROUTE?>plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?=REDIRECT_ROUTE?>plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="<?=REDIRECT_ROUTE?>plugins/moment/moment.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?=REDIRECT_ROUTE?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="<?=REDIRECT_ROUTE?>plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?=REDIRECT_ROUTE?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?=REDIRECT_ROUTE?>dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?=REDIRECT_ROUTE?>dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?=REDIRECT_ROUTE?>dist/js/pages/dashboard.js"></script>
    <?php include(RUTA_PROYECTO."includes/pie.php"); ?>
  </body>
</html>