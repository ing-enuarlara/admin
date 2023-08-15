<?php
include("../../sesion.php");

$idPagina = 125;

include(RUTA_PROYECTO . "includes/verificar-paginas.php");
include(RUTA_PROYECTO . "includes/head.php");
try {
    $consultaMensajes = mysqli_query($conexionBdMicuenta, "SELECT * FROM micuenta_mensajes 
    INNER JOIN ".BDMODADMINISTRATIVO.".administrativo_usuarios ON (usr_id=men_para and men_para!='" . $_SESSION['id'] . "') OR (usr_id=men_de and men_de!='" . $_SESSION['id'] . "') WHERE men_id='" . $_GET['id'] . "'");
} catch (Exception $e) {
    include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
}
$resultado = mysqli_fetch_array($consultaMensajes, MYSQLI_BOTH);

if($resultado['men_visto']==0 && $resultado['men_de']!=$_SESSION['id']){
    try {
        mysqli_query($conexionBdMicuenta, "UPDATE micuenta_mensajes SET men_visto=1, men_fecha_visto=now() WHERE men_id ='" . $_GET['id'] . "'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
    }
}

$opc=0;
if($resultado['men_de']==$_SESSION['id'] && $resultado['men_eliminado_de']==0){
    $opc=1;
}
if($resultado['men_para']==$_SESSION['id'] && $resultado['men_eliminado_para']==0){
    $opc=2;
}
if(($resultado['men_para']==$_SESSION['id'] && $resultado['men_eliminado_para']==1) || ($resultado['men_de']==$_SESSION['id'] && $resultado['men_eliminado_de']==1)){
    $opc=3;
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
<!-- DataTables -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- fullCalendar -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/fullcalendar/main.css">
<!-- Select2 -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<script type="text/javascript">
    function eliminarMensaje(){
        location.href = "../bd_delete/mailbox-eliminar.php?id=<?=$_GET['id']?>&opc=<?=$opc?>&operacion=4";
    }
</script>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include(RUTA_PROYECTO . "includes/carga.php"); ?>

        <?php include(RUTA_PROYECTO . "includes/encabezado.php"); ?>

        <?php include(RUTA_PROYECTO . "includes/menu.php"); ?>

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h3><?= $paginaActual['pag_nombre'] ?></h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= REDIRECT_ROUTE ?>modules/index.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="<?= REDIRECT_ROUTE ?>modules/mi_cuenta/bd_read/mailbox.php">Mensajes</a></li>
                                <li class="breadcrumb-item active"><?= $paginaActual['pag_nombre'] ?></li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <?php include(RUTA_PROYECTO . "includes/mensajes-informativos.php"); ?>
                    <div class="row">
                        <div class="col-md-3">
                            <a href="<?= REDIRECT_ROUTE ?>modules/mi_cuenta/bd_read/mailbox-redactar.php" class="btn btn-primary btn-block mb-3">Redactar</a>
                            <?php include(RUTA_PROYECTO . "includes/menu-mailbox.php"); ?>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title"><?= $paginaActual['pag_nombre'] ?></h3>

                                    <div class="card-tools">
                                        <a href="#" class="btn btn-tool" title="Previous"><i class="fas fa-chevron-left"></i></a>
                                        <a href="#" class="btn btn-tool" title="Next"><i class="fas fa-chevron-right"></i></a>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <div class="mailbox-read-info">
                                        <h5><?= $resultado['men_asunto'] ?></h5>
                                        <h6>De/Para: <?= $resultado['usr_email'] ?>
                                            <span class="mailbox-read-time float-right"><?= str_replace(array_keys($enEspanol), array_values($enEspanol), date("d M. Y h:i A", strtotime($resultado['men_fecha']))) ?></span>
                                        </h6>
                                    </div>
                                    <!-- /.mailbox-read-info -->
                                    <div class="mailbox-controls with-border text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm" data-container="body" title="Delete" onclick="eliminarMensaje()">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                            <button type="button" class="btn btn-default btn-sm" data-container="body" title="Reply">
                                                <i class="fas fa-reply"></i>
                                            </button>
                                            <button type="button" class="btn btn-default btn-sm" data-container="body" title="Forward">
                                                <i class="fas fa-share"></i>
                                            </button>
                                        </div>
                                        <!-- /.btn-group -->
                                    </div>
                                    <!-- /.mailbox-controls -->
                                    <div class="mailbox-read-message">
                                        <?= $resultado['men_contenido'] ?>
                                    </div>
                                    <!-- /.mailbox-read-message -->
                                </div>
                                <!-- /.card-body -->
                                <?php if(!empty($resultado['men_adjunto'])){ ?>
                                    <div class="card-footer bg-white">
                                        <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                                            <li>
                                                <?php
                                                    $explode = explode (".", $resultado['men_adjunto']);
                                                    $extencion    = $explode[1];
                                                    if($extencion=="jpg" || $extencion=="png"){
                                                        echo '<span class="mailbox-attachment-icon has-img"><img src="'.REDIRECT_ROUTE.'files/mensajes/'.$resultado["men_adjunto"].'" alt="Attachment" width=100></span>';
                                                    }else{
                                                        echo '<span class="mailbox-attachment-icon"><i class="far fa-file"></i></span>';
                                                    }
                                                ?>

                                                <div class="mailbox-attachment-info">
                                                    <a href="<?=REDIRECT_ROUTE."files/mensajes/".$resultado['men_adjunto']; ?>" target="_target" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> <?= $resultado['men_adjunto'] ?></a>
                                                    <span class="mailbox-attachment-size clearfix mt-1">
                                                        <span><?=number_format(filesize(RUTA_PROYECTO."files/mensajes/".$resultado['men_adjunto'])) . ' bytes'; ?></span>
                                                        <a href="<?=REDIRECT_ROUTE."files/mensajes/".$resultado['men_adjunto']; ?>" target="_target" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                                                    </span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                <?php } ?>
                                <!-- /.card-footer -->
                                <div class="card-footer">
                                    <div class="float-right">
                                        <button type="button" class="btn btn-default"><i class="fas fa-reply"></i> Responder</button>
                                        <button type="button" class="btn btn-default"><i class="fas fa-share"></i> Reenviar</button>
                                    </div>
                                    <button type="button" class="btn btn-default" onclick="eliminarMensaje()"><i class="far fa-trash-alt"></i> Eliminar</button>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
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
    <!-- InputMask -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/moment/moment.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
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
    <!-- DataTables  & Plugins -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/jszip/jszip.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- fullCalendar 2.2.5 -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/fullcalendar/main.js"></script>
    <!-- Select2 -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/select2/js/select2.full.min.js"></script>
    <?php include(RUTA_PROYECTO . "includes/pie.php"); ?>
</body>

</html>