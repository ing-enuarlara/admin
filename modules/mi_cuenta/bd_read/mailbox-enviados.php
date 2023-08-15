<?php
include("../../sesion.php");

$idPagina = 123;

include(RUTA_PROYECTO . "includes/verificar-paginas.php");
include(RUTA_PROYECTO . "includes/head.php");
try {
    $consultaMensajes = mysqli_query($conexionBdMicuenta, "SELECT * FROM micuenta_mensajes 
    INNER JOIN ".BDMODADMINISTRATIVO.".administrativo_usuarios ON usr_id=men_para 
    WHERE men_de='" . $_SESSION['id'] . "' AND men_eliminado_de!=1");
} catch (Exception $e) {
    include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
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
                    <span id="respuesta"></span>
                    <div class="row">
                        <div class="col-md-3">
                            <a href="<?= REDIRECT_ROUTE ?>modules/mi_cuenta/bd_read/mailbox-redactar.php" class="btn btn-primary btn-block mb-3">Redactar</a>
                            <?php include(RUTA_PROYECTO . "includes/menu-mailbox.php"); ?>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Enviados</h3>

                                    <div class="card-tools">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" placeholder="Search Mail">
                                            <div class="input-group-append">
                                                <div class="btn btn-primary">
                                                    <i class="fas fa-search"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <div class="mailbox-controls">
                                        <!-- Check all button -->
                                        <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                                        </button>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm" id="eliminarBtn">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </div>
                                        <!-- /.btn-group -->
                                        <div class="float-right">
                                            1-50/200
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm">
                                                    <i class="fas fa-chevron-left"></i>
                                                </button>
                                                <button type="button" class="btn btn-default btn-sm">
                                                    <i class="fas fa-chevron-right"></i>
                                                </button>
                                            </div>
                                            <!-- /.btn-group -->
                                        </div>
                                        <!-- /.float-right -->
                                    </div>
                                    <div class="table-responsive mailbox-messages">
                                        <table id="example1" class="table table-hover table-striped">
                                            <tbody>
                                                <script type="text/javascript">
                                                    const mensajeDestacado = {};

                                                    function cambiarDestacado(data) {
                                                        var idHref = 'destacado'+data.id_mensaje;
                                                        var href   = document.getElementById(idHref);
                                                        
                                                        if (!mensajeDestacado.hasOwnProperty(data.id_mensaje)) {
                                                            mensajeDestacado[data.id_mensaje] = data.destacado_mensaje;
                                                        }

                                                        if(mensajeDestacado[data.id_mensaje] == 1) {
                                                            href.innerHTML = `<i class="fa-regular fa-star" style="color: #999;"></i>`;
                                                            mensajeDestacado[data.id_mensaje] = 0;
                                                        } else {
                                                            href.innerHTML = `<i class="fa-solid fa-star text-warning"></i>`;
                                                            mensajeDestacado[data.id_mensaje] = 1;
                                                        }

                                                        var datos = "destacado="+mensajeDestacado[data.id_mensaje]+
                                                                    "&idMensaje="+data.id_mensaje;

                                                        $.ajax({
                                                            type: "POST",
                                                            url: "../../../ajax/ajax-cambiar-destacado.php",
                                                            data: datos,

                                                        });
                                                    }
                                                    document.getElementById("eliminarBtn").addEventListener("click", function() {
                                                        var checkboxes = document.querySelectorAll(".mailbox-messages input[type=checkbox]:checked");
                                                        var values = [];
                                                        
                                                        checkboxes.forEach(function(checkbox) {
                                                            if(checkbox.checked==true){
                                                                values.push(checkbox.value);
                                                            }
                                                        });
                                                        
                                                        if (values.length > 0) {
                                                            // Realizar la solicitud AJAX
                                                            var xhr = new XMLHttpRequest();
                                                            xhr.open("POST", "../bd_delete/mailbox-eliminar.php", true);
                                                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                                            xhr.onreadystatechange = function() {
                                                                if (xhr.readyState === 4) {
                                                                    if (xhr.status === 200) {
                                                                        var response = xhr.responseText;
                                                                        // También puedes mostrar la respuesta en un elemento HTML
                                                                        document.getElementById("respuesta").innerHTML = response;
                                                                        setTimeout(function() {
                                                                            location.reload();
                                                                        }, 1000);
                                                                    } else {
                                                                        alert("Hubo un problema al realizar la solicitud.");
                                                                    }
                                                                }
                                                            };
                                                            var data = "values=" + JSON.stringify(values)+"& operacion=2";
                                                            xhr.send(data);
                                                        } else {
                                                            alert("No se ha seleccionado ningún checkbox para eliminar.");
                                                        }
                                                    });
                                                </script>
                                                <?php
                                                    while($mensajes = mysqli_fetch_array($consultaMensajes, MYSQLI_BOTH)){
                                                        $destacado="fa-regular";
                                                        $styleDestacado="style='color: #999;'";
                                                        if($mensajes['men_destacado']==1){
                                                            $styleDestacado="";
                                                            $destacado="fa-solid text-warning";
                                                        }

														$miArray = [
															'id_mensaje'        => $mensajes['men_id'], 
															'destacado_mensaje' => $mensajes['men_destacado']
														];
														$dataParaJavascript = json_encode($miArray);

                                                        $fechaDF=$mensajes['men_fecha'];
                                                        include(RUTA_PROYECTO."includes/datos-fechas.php");
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <div class="icheck-primary">
                                                                <input type="checkbox" value="<?= $mensajes['men_id'] ?>" id="check<?= $mensajes['men_id'] ?>">
                                                                <label for="check<?= $mensajes['men_id'] ?>"></label>
                                                            </div>
                                                        </td>
                                                        <td class="mailbox-star">
                                                            <a href="#" id="destacado<?=$mensajes['men_id'];?>" onclick='cambiarDestacado(<?=$dataParaJavascript;?>)'>
                                                                <i class="<?= $destacado ?> fa-star" <?= $styleDestacado ?>></i>
                                                            </a>
                                                        </td>
                                                        <td class="mailbox-name"><a href="mailbox-leer.php?id=<?= $mensajes['men_id'] ?>"><?= $mensajes['usr_nombre'] ?></a></td>
                                                        <td class="mailbox-subject"><?= $mensajes['men_asunto'] ?></td>
                                                        <td class="mailbox-attachment">
                                                            <?php if(!empty($mensajes['men_adjunto'])){ ?>
                                                                <i class="fas fa-paperclip"></i>
                                                            <?php } ?>
                                                        </td>
                                                        <td class="mailbox-date" style="color: #999;" title="<?=$timaLineAlt?>"><?=$timaLine?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <!-- /.table -->
                                    </div>
                                    <!-- /.mail-box-messages -->
                                </div>
                                <!-- /.card-body -->
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
    $(function () {
        //Enable check and uncheck all functionality
        $('.checkbox-toggle').click(function () {
            var clicks = $(this).data('clicks')
            if (clicks) {
                //Uncheck all checkboxes
                $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
                $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
            } else {
                //Check all checkboxes
                $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
                $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
            }
            $(this).data('clicks', !clicks)
        })
    })
    </script>
    <?php include(RUTA_PROYECTO . "includes/pie.php"); ?>
</body>

</html>