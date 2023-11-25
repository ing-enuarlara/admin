
<?php
include("../../sesion.php");

$idPagina = 115;

include(RUTA_PROYECTO."includes/verificar-paginas.php");
include(RUTA_PROYECTO."includes/head.php");

if(!empty($_GET["id"])){
	$usuarioID = $_GET["id"];
}else{
	$usuarioID = $_SESSION["id"];
}
try{
    $consultaCalendario=mysqli_query($conexionBdAdministrativo, "SELECT * FROM administrativo_usuarios WHERE usr_id='".$usuarioID."'");
} catch (Exception $e) {
    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
}
$usuarioCalendario = mysqli_fetch_array($consultaCalendario, MYSQLI_BOTH);
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
                        <h3><b><?= $paginaActual['pag_nombre'] ?>:</b> <?=$usuarioCalendario["usr_nombre"];?></h3>
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
                <?php include(RUTA_PROYECTO."includes/mensajes-informativos.php");?>
                <div class="row">
                    <?php
                        $colsm=12;
                        if(empty($_GET["id"]) || (!empty($_GET["id"]) && $_GET["id"]==$_SESSION["id"])){
                            $colsm=9;
                    ?>
                    <div class="col-md-3">
                        <div class="sticky-top mb-3">
                            <!-- general form elements -->
                            <div class="card card-success">
                                <div class="card-header">
                                    <h5 class="float-sm-right">Crear Evento</h5>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form class="form-horizontal" method="post" action="../bd_create/mi-calendario-guardar.php" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <input type="hidden" name="usuarioID" id="usuarioID" value="<?=$usuarioID;?>">

                                        <div class="form-group col-md-12">
                                            <label for="asunto">Asunto:</label>
                                            <input type="text" class="form-control" id="asunto" name="asunto" placeholder="Asunto del evento" value="">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="fechaEvento">Fecha:</label>
                                            <input type="date" class="form-control" id="fechaEvento" name="fechaEvento" placeholder="Fecha del evento" value="">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="switchToggle">
                                                <input type="checkbox" name="todoDia" id="todoDia" value="0" onchange="escogerTodoDia()">
                                                <span class="slider red round"></span>
                                            </label>
                                            <label class="control-label">Todo el día?</label>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="horaInicio">Hora de inicio:</label>
                                            <input type="time" class="form-control" id="horaInicio" placeholder="Hora de inicio" value="" name="horaInicio">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="horaFin">Hora a finalizar:</label>
                                            <input type="time" class="form-control" id="horaFin" placeholder="Hora a finalizar" value="" name="horaFin">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="lugarEvento">Lugar del evento:</label>
                                            <input type="text" class="form-control" id="lugarEvento" placeholder="Lugar del evento" value="" name="lugarEvento">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="enlaceEvento">Enlace del evento:</label>
                                            <input type="text" class="form-control" id="enlaceEvento" placeholder="Enlace del evento" value="" name="enlaceEvento">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="colorEvento">Color para el evento:</label>
                                            <input type="color" class="form-control" id="colorEvento" name="colorEvento" placeholder="Color para el evento" value="">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>Observación:</label>
                                            <div class="input-group">
                                                <textarea name="observacion" id="observacion" rows="3" style="width: 100%" placeholder="Observación..." ></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
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
                                                ?>
                                                <option value="<?=$usuario['usr_id'];?>"><?=$usuario['usr_nombre'].' - '.$usuario['utipo_nombre'];?></option>
                                                <?php $n++;}?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer" id="btnEnviar">
                                        <button type="submit" class="btn btn-success">Agregar</button>
                                        <?php if($datosUsuarioActual['usr_tipo']==DEV){ ?>
                                            <a class="btn btn-info" href="../bd_create/mi-calendario-guardar-festivos.php">Agregar Festivos al Calendario</a>
                                        <?php } ?>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.col -->
                    <?php }?>
                    <div class="col-md-<?=$colsm;?>">
                        <div class="card card-primary">
                            <div class="card-body p-0">
                                <div id="calendar"></div>

                                <div class="modal fade" id="modal-default">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Escoge un enlace</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" id="linkSelect" name="linkSelect">
                                                </select>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                <button id="openLinkButton" class="btn btn-success" onclick="abrirEnlace()">Abrir enlace</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                                <div style="display: none;">
                                    <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%" id="linkSelect" name="linkSelect">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
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
            <?php
                $eventos="";

                try{
                    $agenda = mysqli_query($conexionBdMicuenta, "SELECT age_id, age_evento, age_todo_dia, age_fecha, age_inicio, age_fin, age_color, age_enlace, agus_creador, HOUR(age_inicio) AS hoIni, MINUTE(age_inicio) AS mIni, HOUR(age_fin) AS hoFin, MINUTE(age_fin) AS mFin, DAY(age_fecha) AS dia, MONTH(age_fecha) AS mes, YEAR(age_fecha) AS agno FROM micuenta_agenda_usuarios
                    INNER JOIN micuenta_agenda ON age_id=agus_id_agenda AND age_id_empresa='".$datosUsuarioActual['usr_id_empresa']."' AND YEAR(age_fecha)>='".date("Y")."' AND MONTH(age_fecha)>='".date("m")."' WHERE agus_id_usuario='".$usuarioID."'");
                } catch (Exception $e) {
                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                }

                while($age = mysqli_fetch_array($agenda, MYSQLI_BOTH)){

                    $age["mes"]--;

                    $end="";
                    $tiempoIni="";
                    $todoDia="allDay: true,";
                    if($age["age_todo_dia"]!=1){
                        $todoDia="";
                        $tiempoIni=", ".$age["hoIni"].", ".$age["mIni"];
                        $end="end: new Date(".$age["agno"].", ".$age["mes"].", ".$age["dia"].", ".$age["hoFin"].", ".$age["mFin"]."),";
                    }

                    $enlace="";
                    if(empty($age["age_enlace"]) && $age["agus_creador"]==1 && $usuarioID==$_SESSION["id"]){
                        $enlace=", extendedProps: {
                            links: [
                                {
                                    title: 'Editar Evento',
                                    url: 'mi-calendario-editar.php?id=".$age["age_id"]."&idUss=".$usuarioID."'
                                },
                                {
                                    title: 'Eliminar Evento',
                                    url: '../bd_delete/mi-calendario-eliminar.php?id=".$age["age_id"]."&idUss=".$usuarioID."'
                                }
                            ]
                        }";
                    }
                    if(!empty($age["age_enlace"]) && $age["agus_creador"]==0 && $usuarioID==$_SESSION["id"]){
                        $enlace=", url: '".$age["age_enlace"]."'";
                    }
                    if(!empty($age["age_enlace"]) && $age["agus_creador"]==1 && $usuarioID==$_SESSION["id"]){
                        $enlace=", extendedProps: {
                                    links: [
                                        {
                                            title: 'Editar Evento',
                                            url: 'mi-calendario-editar.php?id=".$age["age_id"]."&idUss=".$usuarioID."'
                                        },
                                        {
                                            title: 'Eliminar Evento',
                                            url: '../bd_delete/mi-calendario-eliminar.php?id=".$age["age_id"]."&idUss=".$usuarioID."'
                                        },
                                        {
                                            title: 'Enlace Extra del Evento',
                                            url: '".$age["age_enlace"]."'
                                        }
                                    ]
                                }";
                    }

                    $eventos .= '
                        {
                            title               : "'.$age["age_id"].": ".$age["age_evento"].'",
                            start               : new Date('.$age["agno"].', '.$age["mes"].', '.$age["dia"].$tiempoIni.'),
                            '.$todoDia.$end.'
                            backgroundColor     : "'.$age["age_color"].'", 
                            borderColor         : "'.$age["age_color"].'"'.$enlace.'
                        },
            
                    ';
                }

                //FESTIVOS EN COLOMBIA
                try{
                    $agendaFestivos = mysqli_query($conexionBdMicuenta, "SELECT * FROM micuenta_agenda_festivos");
                } catch (Exception $e) {
                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                }
                $numFestivos=mysqli_num_rows($agendaFestivos);

                if($numFestivos>0){
                    while($festivos = mysqli_fetch_array($agendaFestivos, MYSQLI_BOTH)){
                        $nombreFestivo = $festivos["agefes_nombre"];
                        $d= $festivos["agefes_dia"];
                        $m= $festivos["agefes_mes"];
                        $y= $festivos["agefes_years"];
                        $eventos .= '{
                                        title               : "'.$nombreFestivo.' (FESTIVO)", 
                                        start               : new Date('.$y.', '.($m-1).', '.$d.'),
                                        allDay              : true, 
                                        backgroundColor     : "#f56954", 
                                        borderColor         : "#f56954"
                                    },';
                    }
                }

                $eventos = substr($eventos,0,-1);
            ?>
            /* initialize the calendar
            -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            var date = new Date()
            var d    = date.getDate(),
                m    = date.getMonth(),
                y    = date.getFullYear()

            var Calendar = FullCalendar.Calendar;
            // var Draggable = FullCalendar.Draggable;

            var calendarEl = document.getElementById('calendar');

            var calendar = new Calendar(calendarEl, {
                locale: 'Es',
                headerToolbar: {
                    left  : 'prev,next today',
                    center: 'title',
                    right : 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día',
                    list: 'Agenda'
                },
                themeSystem: 'bootstrap',
                //Random default events
                events: [<?=$eventos;?>],
                editable  : true,
                droppable : true, // this allows things to be dropped onto the calendar !!!
                // Función para manejar el clic en un evento
                eventClick: function(info) {
                    if (info.event.extendedProps && info.event.extendedProps.links) {
                        links = info.event.extendedProps.links; // Almacena los enlaces del evento seleccionado
                        populateLinkMenu(); // Llena el menú desplegable con los enlaces
                        openEnlacesModal(); // Muestra el modal con los enlaces
                    }
                    if (info.event.url) {
                        window.open(info.event.url, '_target'); // Abre el enlace en otra pestaña
                        event.preventDefault();
                    }
                }
            });

            calendar.render();
        })

        // Función para llenar el menú desplegable con los enlaces
        function populateLinkMenu() {
            var linkSelect = document.getElementById('linkSelect');
            // linkSelect.innerHTML = '<option value="" disabled selected>Selecciona un enlace</option>';
            links.forEach(link => {
                var option = document.createElement('option');
                option.text = link.title;
                option.value = link.url;
                linkSelect.add(option);
            });
        }


        // Función para abrir el modal
        function openEnlacesModal(id) {
            $('#modal-default').modal('show');
        }

        // Evento de clic en el botón para abrir el enlace seleccionado
        function abrirEnlace() {
            var linkSelect = document.getElementById('linkSelect');
            var selectedLink = linkSelect.value;
            if (selectedLink) {
                window.open(selectedLink, '_target'); // Abre el enlace seleccionado en una nueva pestaña
                event.preventDefault();
            }
        }
    </script>
    <?php include(RUTA_PROYECTO."includes/pie.php"); ?>
</body>
</html>