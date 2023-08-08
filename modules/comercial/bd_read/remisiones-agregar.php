<?php
include("../../sesion.php");

$idPagina = 96;

include(RUTA_PROYECTO . "includes/verificar-paginas.php");
include(RUTA_PROYECTO . "includes/head.php");
$vende='';
if(!empty($_GET["vende"])){
    $vende = $_GET["vende"];
}
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
<script type="text/javascript">
    function clientes(datoscliente){
        var id = datoscliente.value;
        location.href = "remisiones-agregar.php?cte="+id+"&vende=<?=$vende?>";
    }
</script>
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
                                <li class="breadcrumb-item"><a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/remisiones.php">Remisiones</a></li>
                                <li class="breadcrumb-item active"><?= $paginaActual['pag_nombre'] ?></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <?php include(RUTA_PROYECTO . "includes/mensajes-informativos.php"); ?>
                    <div class="row">
                        <!-- column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-success">
                                <div class="card-header">
                                    <h5 class="float-sm-right"><?= $paginaActual['pag_nombre'] ?></h5>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form class="form-horizontal" method="post" action="../bd_create/remisiones-guardar.php" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-group col-md-6">
                                            <label>Escoja un cliente:</label>
                                            <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="cliente" onChange="clientes(this)" required>
                                                <option value=""></option>
                                                <?php
                                                $where="";
                                                if($datosUsuarioActual['usr_tipo']!=1){
                                                    $where="WHERE cli_id_empresa='".$configuracion['conf_id_empresa']."'";
                                                }
                                                try{
                                                    $consulta = $conexionBdComercial->query("SELECT * FROM comercial_clientes 
                                                    INNER JOIN ".BDADMIN.".clientes_admin ON cliAdmi_id=cli_id_empresa $where");
                                                } catch (Exception $e) {
                                                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                                }
                                                while($result = mysqli_fetch_array($consulta, MYSQLI_BOTH)){
                                                    $disabled = '';
                                                    $dealer = '';
                                                    if($result['cli_categoria']==3){
                                                        $dealer = '(DEALER)';

                                                        if($datosUsuarioActual['usr_tipo']!=1){
                                                            $disabled = 'disabled';
                                                        }	
                                                    }
                                                    $selected='';
                                                    if(!empty($_GET["cte"]) and $_GET["cte"]==$result[0]){
                                                        $selected = 'selected';
                                                    }
                                                    $empresa='';
                                                    if($datosUsuarioActual['usr_tipo']==1){
                                                        $empresa=' ['.$result['cliAdmi_nombre'].']';
                                                    }
                                                ?>
                                                    <option value="<?=$result[0];?>" <?=$selected?> <?=$disabled?>><?=$result['cli_nombre']." ".$dealer." ".$empresa;?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <?php
                                            if(!empty($_GET['cte'])){
                                        ?>
                                                <a href="clientes-editar.php?id=<?=$_GET["cte"];?>" class="btn btn-info" target="_blank">Editar cliente</a>
                                        <?php
                                                try{
                                                    $consultaCli=$conexionBdComercial->query("SELECT * FROM comercial_clientes WHERE cli_id='".$_GET['cte']."'");
                                                } catch (Exception $e) {
                                                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                                }
                                                $clienteInfo = mysqli_fetch_array($consultaCli, MYSQLI_BOTH);
                                        ?>

                                        <div class="form-group col-md-6">
                                            <label>Vendedor:</label>
                                            <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="vendedor" required>
                                                <option value=""></option>
                                                <?php
                                                    $where="";
                                                    if($datosUsuarioActual['usr_tipo']!=1){
                                                        $where="AND usr_id_empresa='".$configuracion['conf_id_empresa']."'";
                                                    }
                                                    try{
                                                        $consulta = $conexionBdAdministrativo->query("SELECT * FROM administrativo_usuarios 
                                                        INNER JOIN ".BDADMIN.".clientes_admin ON cliAdmi_id=usr_id_empresa WHERE usr_bloqueado!=1 $where ORDER BY usr_nombre");
                                                    } catch (Exception $e) {
                                                        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                                    }
                                                    while($result = mysqli_fetch_array($consulta, MYSQLI_BOTH)){
                                                        $empresa='';
                                                        if($datosUsuarioActual['usr_tipo']==1){
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

                                        <hr>

                                        
                                        <div class="form-group col-md-2">
                                            <label for="exampleInputEmail1">Fecha de propuesta:</label>
                                            <input type="date" class="form-control" id="exampleInputEmail1" name="fechaPropuesta" required value="<?=date("Y-m-d");?>">
                                        </div>
                                        
                                        <div class="form-group col-md-2">
                                            <label for="exampleInputEmail1">Fecha de vencimiento:</label>
                                            <input type="date" class="form-control" id="exampleInputEmail1" name="fechaVencimiento" required value="<?=date("Y-m-d");?>">
                                        </div>

                                        <?php
                                            if($clienteInfo['cli_credito']==1){
                                                $msjCredito = "Este cliente tiene crédito con la compañía.";
                                                $colorCredito = 'aquamarine';
                                            }else{
                                                $msjCredito = "Este cliente aún NO tiene crédito con la compañía.";
                                                $colorCredito = 'gold';
                                            }
                                        ?>
                                        <p style="color: black; background-color: <?=$colorCredito;?>; padding: 10px; font-weight: bold;"><?=$msjCredito;?></p>

                                        <div class="form-group col-md-2">
                                            <label>Forma de pago:</label>
                                            <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="formaPago">
                                                <option value=""></option>
                                                <option value="1" <?php if($clienteInfo['cli_credito']==0)echo "selected";?>>Contado</option>
                                                <option value="2" <?php if($clienteInfo['cli_credito']==1)echo "selected";?>>Crédito</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label>Moneda:</label>
                                            <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="moneda">
                                                <option value=""></option>
                                                <option value="1" selected>COP</option>
                                                <option value="2">USD</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-10">
                                            <label>Productos:</label>
                                            <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="producto[]" multiple="multiple">
                                                <option value=""></option>
												<?php
                                                    $where="";
                                                    if($datosUsuarioActual['usr_tipo']!=1){
                                                        $where="AND cprod_id_empresa='".$configuracion['conf_id_empresa']."'";
                                                    }
                                                    try{
                                                        $consulta = $conexionBdComercial->query("SELECT * FROM comercial_productos
                                                        INNER JOIN comercial_categorias ON ccat_id=cprod_categoria 
                                                        INNER JOIN ".BDADMIN.".clientes_admin ON cliAdmi_id=cprod_id_empresa WHERE cprod_id=cprod_id $where ORDER BY cprod_nombre");
                                                    } catch (Exception $e) {
                                                        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                                    }
                                                    while($result = mysqli_fetch_array($consulta, MYSQLI_BOTH)){
                                                        $empresa='';
                                                        if($datosUsuarioActual['usr_tipo']==1){
                                                            $empresa=' ['.$result['cliAdmi_nombre'].']';
                                                        }
												?>
													<option value="<?=$result[0];?>"><?=$result[0].". ".strtoupper($result['cprod_nombre'])."/".$result['ccat_nombre']." - (HAY ".$result['cprod_exitencia'].")".$empresa;?></option>
												<?php
												}
												?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-10">
                                            <label for="summernote">Observaciones:</label>
                                            <textarea name="notas" rows="5" cols="80" style="width: 80%" id="summernote" placeholder="Observaciones..."></textarea>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer" id="btnEnviar">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
			                        <?php }?>
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