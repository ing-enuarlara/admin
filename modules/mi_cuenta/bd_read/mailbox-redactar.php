<?php
include("../../sesion.php");

$idPagina = 124;

include(RUTA_PROYECTO . "includes/verificar-paginas.php");
include(RUTA_PROYECTO . "includes/head.php");
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
<script>
    function escogerCorreo() {
        var correo = document.getElementById("correo");

        if (correo.checked) {
            correo.value = 1;
        } else {
            correo.value = 0;
        }
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
                                <li class="breadcrumb-item"><a href="<?=REDIRECT_ROUTE?>modules/mi_cuenta/bd_read/mailbox.php">Mensajes</a></li>
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
                                    <h3 class="card-title">Redactar un nuevo mensaje</h3>
                                </div>
                                <!-- form start -->
                                <form class="form-horizontal" method="post" action="../bd_create/mailbox-guardar.php" enctype="multipart/form-data">
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <!-- <div class="form-group">
                                            <input class="form-control" placeholder="Para:">
                                        </div> -->
                                        <div class="form-group">
                                            <select data-placeholder="Para:" class="form-control select2" style="width: 100%;" name="para[]" required multiple="multiple">
                                                <option value=""></option>
                                                <?php
                                                    $where="";
                                                    if($_SESSION["datosUsuarioActual"]['usr_tipo']!=DEV){
                                                        $where="AND usr_id_empresa='".$_SESSION["idEmpresa"]."'";
                                                    }
                                                    try{
                                                        $consulta = $conexionBdAdministrativo->query("SELECT * FROM administrativo_usuarios 
                                                        INNER JOIN ".BDADMIN.".clientes_admin ON cliAdmi_id=usr_id_empresa WHERE usr_id!='".$_SESSION['id']."' AND usr_bloqueado!=1 $where ORDER BY usr_nombre");
                                                    } catch (Exception $e) {
                                                        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                                    }
                                                    while($result = mysqli_fetch_array($consulta, MYSQLI_BOTH)){
                                                        $empresa='';
                                                        if($_SESSION["datosUsuarioActual"]['usr_tipo']==DEV){
                                                            $empresa=' ['.$result['cliAdmi_nombre'].']';
                                                        }
                                                        $selected='';
                                                        if(!empty($vende) and $vende==$result[0]){
                                                            $selected = 'selected';
                                                        }
                                                ?>
                                                    <option value="<?=$result[0];?>" <?=$selected?>><?=strtoupper($result['usr_nombre'])." (".$result['usr_email'].")".$empresa;?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Asunto:" name="asunto">
                                        </div>
                                        <div class="form-group">
                                            <textarea id="compose-textarea" class="form-control" style="height: 300px" name="contenido">
                                            </textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="btn btn-default btn-file">
                                                <i class="fas fa-paperclip"></i> Adjunto
                                                <input type="file" name="adjunto">
                                            </div>
                                            <p class="help-block">Max. 32MB</p>
                                            <p class="help-block">
                                                <div class="icheck-primary">
                                                    <input type="checkbox" value="" id="correo" name="correo" onchange="escogerCorreo()">
                                                    <label for="correo">Enviar por correo?</label>
                                                </div>
                                            </p>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <div class="float-right">
                                            <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Enviar</button>
                                        </div>
                                    </div>
                                    <!-- /.card-footer -->
                                </form>
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
    <!-- Page specific script -->
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()
            //Add text editor
            $('#compose-textarea').summernote()
        })
    </script>
    <?php include(RUTA_PROYECTO . "includes/pie.php"); ?>
</body>

</html>