<?php
include("../../sesion.php");

$idPagina = 70;

include(RUTA_PROYECTO . "includes/verificar-paginas.php");
include(RUTA_PROYECTO . "includes/head.php");

$mensaje = 'La clave no cumple con todos los requerimientos:<br>- Debe tener entre 8 y 20 caracteres.<br>- Solo se admiten caracteres de la a-z, A-Z, números(0-9) y los siguientes simbolos(. y $).';
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
<script type="text/javascript">
    function clientesVerificar(enviada){
        var usuario = enviada.value;
        var opcion = 1;	  
        $('#resp').empty().hide().html("esperando...").show(1);
        datos = "usuario="+(usuario)+
                "&opcion="+(opcion);
        $.ajax({
            type: "POST",
            url: "../../../ajax/ajax-clientes-verificar.php",
            data: datos,
            success: function(data){
            $('#resp').empty().hide().html(data).show(1);
            }
        });
    }
    function mostrar(data) {
        if(data.value == "Colombia"){
            document.getElementById("local").style.display = "block";
            document.getElementById("extrangero").style.display = "none";
        }else{
            document.getElementById("local").style.display = "none";
            document.getElementById("extrangero").style.display = "block";
        }
    }
    function cambiarTipoInput() {
        var campo = document.getElementById("passwordInput");

        if (campo.type === "password") {
            campo.type = "text";
        } else {
            campo.type = "password";
        }
    }

    function validarClave(enviada) {
        var clave = enviada.value;
        var regex = /^[A-Za-z0-9.$*]{8,20}$/;

        if (regex.test(clave)) {
            document.getElementById("respuestaClave").style.color = 'green';
            document.getElementById("respuestaClave").style.display = 'block';
            document.getElementById("btnEnviar").style.display = 'block';
            $("#respuestaClave").html('Contraseña correcta');
        } else {
            document.getElementById("respuestaClave").style.color = 'red';
            document.getElementById("respuestaClave").style.display = 'block';
            document.getElementById("btnEnviar").style.display = 'none';
            $("#respuestaClave").html('<?= $mensaje ?>');
        }
    }
    function formatOption(option) {
        if (!option.id) return option.text; // Opción de título (placeholder)
        return $('<span><img src="' + $(option.element).data('icon') + '" width="15" height="15" />  | ' + option.text + '</span>');
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
                                <li class="breadcrumb-item"><a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/clientes.php">Clientes</a></li>
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
                                <form class="form-horizontal" method="post" action="../bd_create/clientes-guardar.php" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-group col-md-4">
                                            <label>Tipo Documento:</label>
                                            <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="tipoDoc">
                                                <option value=""></option>
                                                <?php
                                                try{
                                                    $consulta = $conexionBdGeneral->query("SELECT * FROM opciones_generales WHERE ogen_grupo=1");
                                                } catch (Exception $e) {
                                                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                                }
                                                while ($resOp = mysqli_fetch_array($consulta, MYSQLI_BOTH)) {
                                                ?>
                                                    <option value="<?= $resOp[0]; ?>"><?= $resOp['ogen_nombre'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="documentoInput">Documento:</label>
                                            <input type="text" class="form-control" id="documentoInput" placeholder="Documento del Cliente" name="documento" title="Ingrese solo el documento sin espacios" onChange="clientesVerificar(this)">
                                            <span style="color:blue;">Digite el documento sin número de verificación.</span><br>
                                            <span id="resp"></span>
                                        </div>

                                        <div class="form-group col-md-11">
                                            <label for="passwordInput">Contraseña:</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control col-md-4" id="passwordInput" onchange="validarClave(this)" placeholder="Ingrese una contraseña" name="clave" pattern="[A-Za-z0-9]+">
                                                <div class="input-group-prepend" onclick="cambiarTipoInput()">
                                                    <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                                </div>
                                            </div>
                                            <span id="respuestaClave" style="display:none"></span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="nombreInput">Nombre:</label>
                                            <input type="text" class="form-control" id="nombreInput" placeholder="Nombre del Usuario" name="nombre" pattern="[A-Za-zñÑáÁéÉíÍóÓúÚ\s]+" title="Ingrese solo letras">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="emailInput">Email:</label>
                                            <input type="email" class="form-control" id="emailInput" placeholder="ejemplo@dominio.com" name="email">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="cellInput">Celular:</label>
                                            <input type="tel" class="form-control" id="cellInput" placeholder="(xxx) xxx- xxx" name="celular">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>pais:</label>
                                            <select data-placeholder="Escoja una opción" class="form-control pais" style="width: 100%;" name="pais" onChange="mostrar(this)">
                                                <option value=""></option>
                                                <?php
                                                $service_url = 'https://restcountries.com/v3.1/all';
                                                $jsonObject = json_decode(file_get_contents($service_url), true);
                                                foreach ($jsonObject as $object) {
                                                    $nombrePais = $object["name"]["common"];
                                                    $banderaPais = $object["flags"]["png"];
                                                ?>
                                                    <option value="<?= $nombrePais; ?>" data-icon="<?= $banderaPais; ?>" <?php if ($nombrePais == "Colombia") { echo "selected"; } ?>>
                                                        <?= $nombrePais ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div id="local" style="display: block;">
                                            <div class="form-group col-md-4">
                                                <label>Ciudad:</label>
                                                <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="ciudad">
                                                    <option value=""></option>
                                                    <?php
                                                    try{
                                                        $consultaCiudad = $conexionBdAdmin->query("SELECT * FROM localidad_ciudades INNER JOIN localidad_departamentos ON dep_id=ciu_departamento ORDER BY ciu_departamento");
                                                    } catch (Exception $e) {
                                                        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                                    }
                                                    while ($ciudad = mysqli_fetch_array($consultaCiudad, MYSQLI_BOTH)) {
                                                    ?>
                                                        <option value="<?= $ciudad[0]; ?>"><?= $ciudad['ciu_nombre'] . '/' . $ciudad['dep_nombre'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div id="extrangero" style="display: none;">
                                            <div class="form-group col-md-4">
                                                <label for="ciudadInput">City:</label>
                                                <input type="text" class="form-control" id="ciudadInput" placeholder="City" value="" name="ciuExtra">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="direccionInput">Direccion:</label>
                                            <input type="text" class="form-control" id="direccionInput" placeholder="Direccion del Usuario" value="" name="direccion">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Tipo Cliente:</label>
                                            <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="cliTipo">
                                                <option value=""></option>
                                                <?php
                                                $where="";
                                                if($datosUsuarioActual['usr_tipo']!=DEV){
                                                    $where= "WHERE clicat_id_empresa='" . $configuracion['conf_id_empresa'] . "'";
                                                }
                                                try{
                                                    $cliTipo = $conexionBdComercial->query("SELECT * FROM comercial_categoria_clientes $where");
                                                } catch (Exception $e) {
                                                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                                }
                                                while ($resOp = mysqli_fetch_array($cliTipo, MYSQLI_BOTH)) {
                                                ?>
                                                    <option value="<?= $resOp[0]; ?>"><?= $resOp['clicat_nombre']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer" id="btnEnviar">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
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
    <!-- AdminLTE for demo purposes -->
    <script src="<?= REDIRECT_ROUTE ?>dist/js/demo.js"></script>
    <!-- Page specific script -->
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