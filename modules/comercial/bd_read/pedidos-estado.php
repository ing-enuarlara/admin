<?php
include("../../sesion.php");

$idPagina = 88;

include(RUTA_PROYECTO . "includes/verificar-paginas.php");
include(RUTA_PROYECTO . "includes/head.php");

try{
    $consulta=mysqli_query($conexionBdComercial,"SELECT * FROM comercial_pedidos 
    INNER JOIN ".BDMODADMINISTRATIVO.".administrativo_usuarios ON usr_id=pedid_creador 
    WHERE pedid_id='".$_GET["id"]."'");
} catch (Exception $e) {
    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
}
$resultadoD = mysqli_fetch_array($consulta, MYSQLI_BOTH);
?>	
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/fontawesome-free/css/all.min.css">
<!-- daterange picker -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/daterangepicker/daterangepicker.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<!-- BS Stepper -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/bs-stepper/css/bs-stepper.min.css">
<!-- dropzonejs -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/dropzone/min/dropzone.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>dist/css/adminlte.min.css">
<!-- summernote -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/summernote/summernote-bs4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include(RUTA_PROYECTO . "includes/carga.php"); ?>

        <?php include(RUTA_PROYECTO . "includes/encabezado.php"); ?>

        <?php include(RUTA_PROYECTO . "includes/menu.php"); ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= REDIRECT_ROUTE ?>modules/index.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/pedidos.php">Pedidos</a></li>
                                <li class="breadcrumb-item active"><?= $paginaActual['pag_nombre'] ?></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <?php 
                        include(RUTA_PROYECTO . "includes/mensajes-informativos.php");
                        
                        $disabled='';
                        $readonly='';
                        if($resultadoD['pedid_estado']==0 || $resultadoD['pedid_estado']==3){
                            $disabled='disabled';
                            $readonly='readonly';
                    ?>
                        <script>
                            $(document).ready(function() {
                                document.getElementById('btnEnviar').style.display="none";
                                document.getElementById('btnEnviar2').style.display="none";
                            });
                        </script>
                    <?php
                        }
                        if($resultadoD['pedid_estado']==0){
                    ?>
                        <p style="color: black; background-color: gold; padding: 10px; font-weight: bold;">Este Pedido fue anulado, si desea restaurarlo, de click 
                        <a href="../bd_update/pedidos-gestionar.php?id=<?=$resultadoD['pedid_id'];?>&idC=<?=$resultadoD['pedid_cotizacion'];?>&op=2" onClick="if(!confirm('Desea generar pedido de esta cotización?')){return false;}">AQUÍ</a></p>
                    <?php
                        }
                    ?>	
                    <div class="row">
                        <!-- column -->
                        <div class="col-md-3">
                            <!-- general form elements -->
                            <div class="card card-success">
                                <div class="card-header">
                                    <h5 class="float-sm-right">Editar Pedido</h5>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form class="form-horizontal" method="post" action="../bd_update/pedidos-estado-actualizar.php" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?=$_GET["id"];?>">
                                    <div class="card-body">
                                        <div class="form-group col-md-12">
                                            <label for="nPedidoInput">Nº Pedido:</label>
                                            <input type="text" class="form-control" id="nPedidoInput" placeholder="Nº Pedido" value="<?= date("dmy", strtotime($resultadoD['pedid_fecha_propuesta']))."-".$resultadoD['pedid_id']; ?>" disabled>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="fechaPropuesta">Fecha Propuesta:</label>
                                            <input type="date" class="form-control" id="fechaPropuesta" name="fecha" value="<?=$resultadoD['pedid_fecha_propuesta'];?>" <?=$disabled?>>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>Cambiar Estado</label>
                                            <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="estado" <?=$disabled?>>
                                                <option value=""></option>
                                                <?php
                                                $n=0;
                                                while($n<=4){
                                                ?>
                                                <option value="<?=$n;?>" <?php if($resultadoD['pedid_estado']==$n){ echo "selected";}?>><?=$estadoPedidos[$n];?></option>
                                                <?php $n++;}?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="empresaEnvio">Empresa de Envío:</label>
                                            <input type="text" class="form-control" id="empresaEnvio" placeholder="Empresa de Envío" value="<?= $resultadoD['pedid_empresa_envio']; ?>" name="empresaEnvio" <?=$disabled?>>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="codigoSegui">Código de seguimiento:</label>
                                            <input type="text" class="form-control" id="codigoSegui" placeholder="Código de seguimiento" value="<?= $resultadoD['pedid_codigo_seguimiento']; ?>" name="codigoSeguimiento" <?=$disabled?>>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer" id="btnEnviar">
                                        <button type="submit" class="btn btn-success">Actualizar Estado</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h5 class="float-sm-right">Añadir Novedades</h5>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form class="form-horizontal" method="post" action="../bd_create/pedidos-estado-novedades-guardar.php" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?=$_GET["id"];?>">
                                    <input type="hidden" name="estadoActual" value="<?=$resultadoD['pedid_estado'];?>">
                                    <div class="card-body">
                                        <div class="form-group col-md-12">
                                            <label for="diaActual">Dia:</label>
                                            <input type="text" class="form-control" id="diaActual" name="dia" value="<?=date("d");?>" <?=$disabled?>>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="mesActual">Mes:</label>
                                            <input type="text" class="form-control" id="mesActual" name="mes" value="<?=date("M");?>" <?=$disabled?>>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>Estado Actual</label>
                                            <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="estado" <?=$disabled?>>
                                                <option value=""></option>
                                                <?php
                                                $n=0;
                                                while($n<=4){
                                                ?>
                                                <option value="<?=$n;?>" <?php if($resultadoD['pedid_estado']==$n){ echo "selected";}?>><?=$estadoPedidos[$n];?></option>
                                                <?php $n++;}?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>Novedad:</label>
                                            <div class="input-group">
                                                <textarea name="novedad" rows="3" style="width: 100%" placeholder="Novedades..." <?=$readonly?>></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer" id="btnEnviar2">
                                        <button type="submit" class="btn btn-primary">Añadir Novedad</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.column -->
                        <!-- column -->
                        <div class="col-md-9">
                            <!-- general form elements -->
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h5 class="float-sm-right"><?= $paginaActual['pag_nombre'] ?></h5>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <!-- The time line -->
                                    <div class="timeline">
                                        <?php
                                            try{
                                                $preparacionNov = mysqli_query($conexionBdComercial,"SELECT * FROM comercial_pedidos_novedades 
                                                INNER JOIN ".BDMODADMINISTRATIVO.".administrativo_usuarios ON usr_id=pednov_usuario 
                                                WHERE pednov_pedido='".$_GET["id"]."' ORDER BY pednov_id DESC");
                                            } catch (Exception $e) {
                                                include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                            }
                                            while($preparacion = mysqli_fetch_array($preparacionNov, MYSQLI_BOTH)){
                                                $fechaDF=$preparacion['pednov_fecha_registro'];
                                                include(RUTA_PROYECTO."includes/datos-fechas.php");
                                        ?>
                                            <div class="time-label">
                                                <span class="bg-<?=$colorEstadoTimelinePedidos[$preparacion['pednov_estado']];?>">
                                                    <?=$preparacion['pednov_dia'].' '.$preparacion['pednov_mes'].' '.date("Y", strtotime($preparacion['pednov_fecha_registro']))?>
                                                </span>
                                            </div>
                                            <!-- /.timeline-label -->
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-clock bg-<?=$colorEstadoTimelinePedidos[$preparacion['pednov_estado']];?>"></i>
                                                <div class="timeline-item">
                                                    <span class="time">
                                                        <i class="fas fa-clock"></i> 
                                                        <a href="#" title="<?=$timaLineAlt?>" style="color: #999;"><?=$timaLine?></a>
                                                    </span>
                                                    <h3 class="timeline-header no-border">
                                                        <span class="bg-<?=$colorEstadoTimelinePedidos[$preparacion['pednov_estado']];?>" style="font-size: 16px; font-weight: bold; padding: 5px; border-radius: 5px;">[<?=$estadoPedidos[$preparacion['pednov_estado']];?>]</span>
                                                        <a href="#"><?=$preparacion['usr_nombre'];?></a> <?=$preparacion['pednov_novedad'];?>
                                                    </h3>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                        <?php }?>
                                        <div>
                                            <i class="fas fa-clock bg-gray"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                </div>
                                <!-- /.card-footer -->
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
        <?php include(RUTA_PROYECTO . "includes/footer.php"); ?>
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>
    <!-- jQuery -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/moment/moment.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- BS-Stepper -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- dropzonejs -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/dropzone/min/dropzone.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= REDIRECT_ROUTE ?>dist/js/adminlte.min.js"></script>
    <!-- Summernote -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/summernote/summernote-bs4.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?= REDIRECT_ROUTE ?>dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
        // Summernote
        $('#summernote').summernote()

        // CodeMirror
        CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
            mode: "htmlmixed",
            theme: "monokai"
        });
        })
    </script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()
            
            $('.pais').select2({
                templateSelection: formatOption
            });

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });

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
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
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

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

        })

        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function() {
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
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file)
            }
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
    <?php include(RUTA_PROYECTO . "includes/pie.php"); ?>
</body>

</html>