<?php
include("../../sesion.php");

$idPagina = 157;

include(RUTA_PROYECTO . "includes/verificar-paginas.php");
include(RUTA_PROYECTO . "includes/head.php");

try {
	$consuluta = $conexionBdComercial->query("SELECT * FROM comercial_ofertas 
  WHERE ofer_id='" . $_GET["id"] . "'");
} catch (Exception $e) {
	include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
}
$resultadoD = mysqli_fetch_array($consuluta, MYSQLI_BOTH);

try {
	$consulutaProd = $conexionBdComercial->query("SELECT cop_id_articulo FROM comercial_ofertas_productos 
  WHERE cop_id_oferta='" . $_GET["id"] . "'");
} catch (Exception $e) {
	include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
}
$prods = $consulutaProd->fetch_all(MYSQLI_ASSOC);
$arrayProds = [];
foreach ($prods as $prod) {
	$arrayProds[$prod['cop_id_articulo']] = $prod['cop_id_articulo'];
}

$rutaFoto = !empty($resultadoD['ofer_tipo_img']) ? ($resultadoD['ofer_tipo_img'] == TIPO_IMG ? REDIRECT_ROUTE . "files/ofertas/" . $resultadoD['ofer_img'] : $resultadoD['ofer_img']) : "";
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
								<li class="breadcrumb-item"><a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/ofertas.php">Ver Ofertas</a></li>
								<li class="breadcrumb-item active"><?= $paginaActual['pag_nombre'] ?></li>
							</ol>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
			</div>
			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<!-- column -->
						<div class="col-md-12">
							<!-- general form elements -->
							<div class="card card-success">
								<div class="card-header">
									<h5 class="float-sm-right"><?= $paginaActual['pag_nombre'] ?></h5>
								</div>

								<!-- /.card-header -->
								<div class="col-md-12">
									<!-- form start -->
									<form class="form-horizontal" method="post" action="../bd_update/ofertas-actualizar.php" enctype="multipart/form-data">
										<input type="hidden" name="id" value="<?= $_GET["id"]; ?>">
										<input type="hidden" name="tipoOfertaActual" value='<?= $resultadoD['ofer_tipo'] ?>'>
										<input type="hidden" name="articulosActuales" value='<?= json_encode($arrayProds ?? []) ?>'>
										<div class="card-body">

											<div class="form-group col-md-6">
												<label for="fechaInicio">Fecha Inicio:</label>
												<input type="date" class="form-control" id="fechaInicio" name="fechaInicio" placeholder="Fecha Inicio" value="<?= $resultadoD['ofer_fecha_inicio'] ?>">
											</div>

											<div class="form-group col-md-6">
												<label for="fechaFinal">Fecha Final:</label>
												<input type="date" class="form-control" id="fechaFinal" name="fechaFinal" placeholder="Fecha Final" value="<?= $resultadoD['ofer_fecha_fin'] ?>">
											</div>

											<hr>
											<div class="col-md-6" style="margin-top: 10px;">
												<div class="filtr-item col-md-12" data-category="1" data-sort="white sample">
													<a href="<?= $rutaFoto ?>" data-toggle="lightbox" data-title="Foto principal de la oferta">
														<img src="<?= $rutaFoto ?>" class="img-fluid mb-2" alt="white sample" style="margin-left: auto; margin-right: auto; display: flex; flex-wrap: wrap; width: 200px;" />
													</a>
												</div>
											</div>

											<div class="form-group col-md-6">
												<label for="exampleInputEmail1">Tipo de Imagen para la Ofertas:</label>
												<select data-placeholder="Escoja una opción" class="form-control select2" onchange="cargarImagen(this)" style="width: 100%;" name="tipoImg" id="tipoImg">
													<option value=""></option>
													<option value="<?= TIPO_IMG ?>" <?= $resultadoD['ofer_tipo_img'] == TIPO_IMG ? "selected" : ""; ?>>Imagen</option>
													<option value="<?= TIPO_URL ?>" <?= $resultadoD['ofer_tipo_img'] == TIPO_URL ? "selected" : ""; ?>>Url</option>
												</select>
											</div>

											<div class="form-group col-md-6" id="tipoFile" style="display:none;">
												<label for="customFile">Foto Principal de la Ofertas</label>
												<div class="custom-file">
													<input type="file" class="custom-file-input" id="customFile" name="ftOferta">
													<label class="custom-file-label" for="customFile">Escoger Foto...</label>
												</div>
											</div>

											<div class="form-group col-md-6" id="tipoUrl" style="display:none;">
												<label for="exampleInputEmail1">Url de la Imagen de la Ofertas:</label>
												<input type="text" class="form-control" id="exampleInputEmail1" value="<?= $resultadoD['ofer_tipo_img'] == TIPO_URL ? $rutaFoto : "" ?>" placeholder="Url de la Imagen" name="urlImgOferta" id="urlImg">
											</div>

											<hr>

											<div class="form-group col-md-6">
												<label for="exampleInputEmail1">Titulo:</label>
												<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Titulo de la Ofertas" name="titulo" value="<?= $resultadoD['ofer_title'] ?>">
											</div>

											<div class="col-sm-6">
												<!-- textarea -->
												<div class="form-group">
													<label>Descripción de la Ofertas</label>
													<textarea class="form-control" rows="3" placeholder="Descripción de la Ofertas" name="descripcion" id="detalles"><?= $resultadoD['ofer_descripcion'] ?></textarea>
												</div>
											</div>

											<!-- Tipos -->
											<div class="form-group col-md-6">
												<label>Tipo de Oferta:</label>
												<select data-placeholder="Escoja una opción" class="form-control select2" onchange="escogerArticulos(this.value)" style="width: 100%;" name="tipoOfertas" id="tipoOfertas">
													<option value=""></option>
													<option value="<?= TODA ?>" <?= $resultadoD['ofer_tipo'] == TODA ? "selected" : ""; ?>>Toda la Tienda</option>
													<option value="<?= PROD ?>" <?= $resultadoD['ofer_tipo'] == PROD ? "selected" : ""; ?>>Para Productos</option>
													<option value="<?= CATE ?>" <?= $resultadoD['ofer_tipo'] == CATE ? "selected" : ""; ?>>Para Categorias</option>
													<option value="<?= SUB_CATE ?>" <?= $resultadoD['ofer_tipo'] == SUB_CATE ? "selected" : ""; ?>>Para Sub-Categorias</option>
													<option value="<?= TIPO ?>" <?= $resultadoD['ofer_tipo'] == TIPO ? "selected" : ""; ?>>Para Tipos de Productos</option>
												</select>
												<span style="color: red; display: none" id="cargaArticulos"></span>
											</div>

											<!-- Contenedor Articulos -->
											<div class="form-group col-md-6" style="display:none;" id="divArticulos">
												<label id="lebelArticulos">Articulos:</label>
												<select class="form-control select2" multiple="multiple" name="articulos[]" id="selectArticulos" style="width: 100%;"></select>
											</div>

											<div class="form-group col-md-6">
												<label>Oferta Activa?</label>
												<select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="activo" id="activo">
													<option value=""></option>
													<option value="<?= SI ?>" <?= $resultadoD['ofer_activo'] == SI ? "selected" : ""; ?>>SI</option>
													<option value="<?= NO ?>" <?= $resultadoD['ofer_activo'] == NO ? "selected" : ""; ?>>NO</option>
												</select>
											</div>
										</div>
										<!-- /.card-body -->
										<div class="card-footer">
											<button type="submit" class="btn btn-primary">Guardar</button>
										</div>
									</form>
								</div>
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
	<!-- Ekko Lightbox -->
	<script src="<?= REDIRECT_ROUTE ?>plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
	<!-- Filterizr-->
	<script src="<?= REDIRECT_ROUTE ?>plugins/filterizr/jquery.filterizr.min.js"></script>
	<!-- Summernote -->
	<script src="<?= REDIRECT_ROUTE ?>plugins/summernote/summernote-bs4.min.js"></script>
	<!-- Page specific script -->
	<script>
		function cargarImagen(tipo) {
			if (tipo.value == '<?= TIPO_IMG ?>') {
				var urlImg = document.getElementById('urlImg');
				if (urlImg) {
					urlImg.value = '';
				}
				document.getElementById('tipoFile').style.display = 'block';
				document.getElementById('tipoUrl').style.display = 'none';
			}

			if (tipo.value == '<?= TIPO_URL ?>') {
				document.getElementById('tipoFile').style.display = 'none';
				document.getElementById('tipoUrl').style.display = 'block';
			}
		}

		document.addEventListener("DOMContentLoaded", () => {
			function escogerArticulos(tipo) {
				const div = document.getElementById('divArticulos');
				const lebel = document.getElementById('lebelArticulos');
				const select = document.getElementById('selectArticulos');
				const cargaArticulos = document.getElementById('cargaArticulos');
				const arrayProds = <?= json_encode($arrayProds ?? []) ?>;

				if (div) div.style.display = 'none';
				if (lebel) lebel.innerHTML = '';
				if (select) select.innerHTML = '';

				if (!tipo || tipo == '<?= TODA ?>') return;
				cargaArticulos.style.display = 'block';
				cargaArticulos.innerHTML = 'Cargando Opciones....';

				fetch('../../../ajax/ajax-cargar_selects.php?tipo=' + tipo)
					.then(res => res.json())
					.then(data => {
						const target = {
							'<?= PROD ?>': 'Productos: ',
							'<?= CATE ?>': 'Categorías: ',
							'<?= SUB_CATE ?>': 'Sub-Categorías: ',
							'<?= TIPO ?>': 'Tipos de Productos: '
						};

						if (target[tipo]) {

							if (div && select) {
								lebel.innerHTML = target[tipo];
								div.style.display = 'block';
								data.forEach(opt => {
									const option = document.createElement('option');
									option.value = opt.id;
									option.textContent = opt.nombre;

									if (arrayProds[opt.id] && tipo == '<?= $resultadoD['ofer_tipo'] ?>') {
										option.selected = true;
									}

									select.appendChild(option);
								});

								$(select).trigger('change.select2');
								$(select).select2({
									placeholder: "Escoja una opción",
									allowClear: true
								});
								cargaArticulos.style.display = 'none';
							}
						}
					});
			}

			// Hacer global la función para el onchange
			window.escogerArticulos = escogerArticulos;
		});

		$(document).ready(function() {
			cargarImagen(document.getElementById('tipoImg'));
			escogerArticulos(document.getElementById('tipoOfertas').value);
		});

		$(function() {
			// Summernote
			$('#detalles').summernote();
			$('#especificaciones').summernote();
			bsCustomFileInput.init();

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
		if (previewNode) {
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
		}
		// DropzoneJS Demo Code End
	</script>>
	<!-- Page specific script -->
	<script>
		$(function() {
			$(document).on('click', '[data-toggle="lightbox"]', function(event) {
				event.preventDefault();
				$(this).ekkoLightbox({
					alwaysShowClose: true
				});
			});

			$('.filter-container').filterizr({
				gutterPixels: 3
			});
			$('.btn[data-filter]').on('click', function() {
				$('.btn[data-filter]').removeClass('active');
				$(this).addClass('active');
			});
		})
	</script>
	<?php include(RUTA_PROYECTO . "includes/pie.php"); ?>
</body>

</html>