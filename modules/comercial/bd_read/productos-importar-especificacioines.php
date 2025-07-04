<?php
include("../../sesion.php");

$idPagina = 147;

include(RUTA_PROYECTO . "includes/verificar-paginas.php");
include(RUTA_PROYECTO . "includes/head.php");
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
								<li class="breadcrumb-item"><a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/productos.php">Ver Productos</a></li>
								<li class="breadcrumb-item active"><?= $paginaActual['pag_nombre'] ?></li>
							</ol>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
			</div>
			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<?php include(RUTA_PROYECTO."includes/mensajes-informativos.php"); ?>
					<div class="row">
						<!-- column -->
						<div class="col-md-3">
							<!-- general form elements -->
							<div class="card card-success">
								<div class="card-header">
									<h5 class="float-sm-left">Paso a paso</h5>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<p><b>1.</b> Descargue la plantilla de excel en este enlace. <a href="<?=REDIRECT_ROUTE."files/excel/Plantilla-Importacion-productos-especificacioines.xlsx"?>" target="_blank" class="btn btn-xs btn-secondary">DESCARGAR PLANTILLA</a></p>
									<p><b>2.</b> Llene los campos en el orden que la plantilla los solicita.</p>
									<p><b>3.</b> Finalmente guarde la plantilla ya completada, carguela en el campo que dice <mark>Subir la plantilla lista</mark> y dele click al botón importar especificaciones.</p>
								</div>
							</div>

							<div class="card card-success">
								<div class="card-header">
									<h5 class="float-sm-left">Consideraciones</h5>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<p><b>-></b> Tenga en cuenta, para importar las especificaciones, los campos Cod/Referencia/ID y Valor son obligatorios.</p>
									<p><b>-></b> Para el campo <mark>valor</mark>, debe colocar el valor numerico o textual de la especificacion detallada en el <mark>nombre</mark>.</p>
								</div>
							</div>
							<!-- /.card -->
						</div>
						<div class="col-md-9">
							<!-- general form elements -->
							<div class="card card-success">
								<div class="card-header">
									<h5 class="float-sm-right"><?= $paginaActual['pag_nombre'] ?></h5>
								</div>
								<!-- /.card-header -->
								<!-- form start -->
								<form class="form-horizontal" method="post" action="../../../import-export/excel-importar-especificacioines-productos.php" enctype="multipart/form-data">
									<div class="card-body">
										<div class="form-group col-md-8">
											<label for="customFile">Subir la plantilla lista</label>
											<div class="custom-file">
												<input type="file" class="custom-file-input" name="plantilla">
												<label class="custom-file-label" for="customFile">Escoger Plantilla...</label>
											</div>
										</div>

										<div class="form-group col-md-8">
											<label for="exampleInputEmail1">Coloque el número de la fila desde donde quiere que el archivo sea leido:</label>
											<input type="number" class="form-control" id="exampleInputEmail1" placeholder="Coloque el número de la fila desde donde quiere que el archivo sea leido" name="filaInicial" value="3">
											<small class="form-text text-muted text-red">Primera fila desde donde hay información de los productos.<br>Esto se usa para evitar que se lean filas que no tienen información.</small>
										</div>

										<div class="form-group col-md-8">
											<label for="exampleInputEmail1">Coloque el número de la última fila hasta donde quiere que el archivo sea leido:</label>
											<input type="number" class="form-control" id="exampleInputEmail1" placeholder="Coloque el número de la última fila hasta donde quiere que el archivo sea leido" name="filaFinal" value="200">
											<small class="form-text text-muted text-red">Fila hasta donde hay información de los productos.<br>Esto se usa para evitar que se lean filas que no tienen información.</small>
										</div>

										<?php if( !isset($_SESSION['admin']) ){?>
											<div class="form-group col-md-8">
												<label>Empresa:</label>
												<select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="idEmpresa">
													<option value=""></option>
													<?php
													try {
														$empresa = $conexionBdAdmin->query("SELECT * FROM clientes_admin WHERE cliAdmi_id != '" . $_SESSION["idEmpresa"] . "'");
													} catch (Exception $e) {
														include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
													}
													while ($datosEmpresa = mysqli_fetch_array($empresa, MYSQLI_BOTH)) {
													?>
														<option value="<?= $datosEmpresa['cliAdmi_id']; ?>"><?= $datosEmpresa['cliAdmi_nombre']; ?></option>
													<?php } ?>
												</select>
											</div>
										<?php } ?>
									</div>
									<!-- /.card-body -->
									<div class="card-footer">
										<button type="submit" class="btn btn-primary">Importar Especificaciones</button>
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