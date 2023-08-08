
<?php
include("../../sesion.php");

$idPagina = 117;

include(RUTA_PROYECTO."includes/verificar-paginas.php");
include(RUTA_PROYECTO."includes/head.php");

try{
    $consulta = mysqli_query($conexionBdMicuenta, "SELECT * FROM micuenta_agenda WHERE age_id='".$_GET['id']."'");
} catch (Exception $e) {
    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
}
$resultadoD = mysqli_fetch_array($consulta, MYSQLI_BOTH);
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
<!-- DataTables -->
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- fullCalendar -->
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/fullcalendar/main.css">
<!-- Select2 -->
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<script>
    function escogerTodoDia() {
        var todoElDia = document.getElementById("todoDia");
        var inicio = document.getElementById("horaInicio");
        var fin = document.getElementById("horaFin");

        if (todoElDia.checked) {
            todoElDia.value = 1;
            inicio.disabled = true;
            fin.disabled = true;
            inicio.value = '';
            fin.value = '';
        } else {
            todoElDia.value = 0;
            inicio.disabled = false;
            fin.disabled = false;
        }
    }
</script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    
    <?php include(RUTA_PROYECTO."includes/carga.php"); ?>

    <?php include(RUTA_PROYECTO."includes/encabezado.php"); ?>
    
    <?php include(RUTA_PROYECTO."includes/menu.php"); ?>
    
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
                            <li class="breadcrumb-item"><a href="<?= REDIRECT_ROUTE ?>modules/mi_cuenta/bd_read/mi-calendario.php?id=<?=$_GET['idUss']?>">Calendario</a></li>
                            <li class="breadcrumb-item active"><?= $paginaActual['pag_nombre'] ?></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <?php include(RUTA_PROYECTO."includes/mensajes-informativos.php");?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="sticky-top mb-3">
                            <!-- general form elements -->
                            <div class="card card-success">
                                <div class="card-header">
                                    <h5 class="float-sm-right"><?= $paginaActual['pag_nombre'] ?></h5>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form class="form-horizontal" method="post" action="../bd_update/mi-calendario-actualizar.php" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <input type="hidden" name="id" id="id" value="<?=$_GET['id'];?>">

                                        <div class="form-group col-md-5">
                                            <label for="asunto">Asunto:</label>
                                            <input type="text" class="form-control" id="asunto" name="asunto" placeholder="Asunto del evento" value="<?= $resultadoD['age_evento'] ?>">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="fechaEvento">Fecha:</label>
                                            <input type="date" class="form-control" id="fechaEvento" name="fechaEvento" placeholder="Fecha del evento" value="<?= $resultadoD['age_fecha'] ?>">
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label class="switchToggle">
                                                <input type="checkbox" name="todoDia" id="todoDia" <?php if($resultadoD['age_todo_dia']==1){ echo 'checked value="1"';}else{ echo 'value="0"';} ?> onchange="escogerTodoDia()">
                                                <span class="slider red round"></span>
                                            </label>
                                            <label class="control-label">Todo el día?</label>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="horaInicio">Hora de inicio:</label>
                                            <input type="time" class="form-control" id="horaInicio" placeholder="Hora de inicio" value="<?= $resultadoD['age_inicio'] ?>" name="horaInicio">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="horaFin">Hora a finalizar:</label>
                                            <input type="time" class="form-control" id="horaFin" placeholder="Hora a finalizar" value="<?= $resultadoD['age_fin'] ?>" name="horaFin">
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="lugarEvento">Lugar del evento:</label>
                                            <input type="text" class="form-control" id="lugarEvento" placeholder="Lugar del evento" value="<?= $resultadoD['age_lugar'] ?>" name="lugarEvento">
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="enlaceEvento">Enlace del evento:</label>
                                            <input type="text" class="form-control" id="enlaceEvento" placeholder="Enlace del evento" value="<?= $resultadoD['age_enlace'] ?>" name="enlaceEvento">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="colorEvento">Color para el evento:</label>
                                            <input type="color" class="form-control" id="colorEvento" name="colorEvento" placeholder="Color para el evento" value="<?= $resultadoD['age_color'] ?>">
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label>Observación:</label>
                                            <div class="input-group">
                                                <textarea name="observacion" id="observacion" rows="3" style="width: 100%" placeholder="Observación..." ><?= $resultadoD['age_notas'] ?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label>Invitar otro usuario/cliente</label>
                                            <select data-placeholder="Escoja una opción" class="form-control select2" multiple="multiple" style="width: 100%;" id="usuarios" name="usuarios[]">
                                                <option value=""></option>
                                                <?php
                                                    try{
                                                        $consultaUsuario=mysqli_query($conexionBdAdministrativo, "SELECT * FROM administrativo_usuarios INNER JOIN administrativo_roles ON utipo_id=usr_tipo WHERE usr_id_empresa='".$datosUsuarioActual['usr_id_empresa']."' AND usr_id!='".$datosUsuarioActual['usr_id']."'");
                                                    } catch (Exception $e) {
                                                        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                                    }
                                                    while($usuario = mysqli_fetch_array($consultaUsuario, MYSQLI_BOTH)){

                                                        try{
                                                            $consultaUsuarioAgenda = mysqli_query($conexionBdMicuenta, "SELECT agus_id FROM micuenta_agenda_usuarios WHERE agus_id_usuario='".$usuario['usr_id']."' AND agus_id_agenda='".$_GET['id']."'");
                                                        } catch (Exception $e) {
                                                            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                                        }
                                                        $numUsuarioAgenda=mysqli_num_rows($consultaUsuarioAgenda);

                                                        $selected="";
                                                        if($numUsuarioAgenda>0){
                                                            $selected="selected";
                                                        }

                                                ?>
                                                <option value="<?=$usuario['usr_id'];?>" <?=$selected;?>><?=$usuario['usr_nombre'].' - '.$usuario['utipo_nombre'];?></option>
                                                <?php $n++;}?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer" id="btnEnviar">
                                        <button type="submit" class="btn btn-success">Agregar</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
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
    <!-- InputMask -->
    <script src="<?=REDIRECT_ROUTE?>plugins/moment/moment.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="<?=REDIRECT_ROUTE?>plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
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
    <!-- DataTables  & Plugins -->
    <script src="<?=REDIRECT_ROUTE?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/jszip/jszip.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- fullCalendar 2.2.5 -->
    <script src="<?=REDIRECT_ROUTE?>plugins/fullcalendar/main.js"></script>
    <!-- Select2 -->
    <script src="<?=REDIRECT_ROUTE?>plugins/select2/js/select2.full.min.js"></script>
    <!-- Page specific script -->
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
    <?php include(RUTA_PROYECTO."includes/pie.php"); ?>
</body>
</html>