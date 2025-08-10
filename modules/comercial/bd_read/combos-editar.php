<?php
include("../../sesion.php");
require_once(RUTA_PROYECTO . "class/Combos.php");
require_once(RUTA_PROYECTO . "class/Productos.php");
require_once(RUTA_PROYECTO . "class/Combos_Productos.php");

$idPagina = 196;

include(RUTA_PROYECTO . "includes/verificar-paginas.php");
include(RUTA_PROYECTO . "includes/head.php");

$resultadoD = Combos::Select(['combo_id' => $_GET['id']], "*")->fetch(PDO::FETCH_ASSOC);
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
								<li class="breadcrumb-item"><a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/combos.php">Ver Combos</a></li>
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
									<form class="form-horizontal" method="post" action="../bd_update/combos-actualizar.php" enctype="multipart/form-data">
										<input type="hidden" name="id" value="<?= $_GET["id"]; ?>">
										<div class="card-body">

											<div class="form-group col-md-6">
												<label for="exampleInputEmail1">Titulo:</label>
												<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Titulo para el combo" name="titulo" value="<?= $resultadoD['combo_title']; ?>">
											</div>

											<div class="col-sm-6">
												<!-- textarea -->
												<div class="form-group">
													<label>Descripción del combo</label>
													<textarea class="form-control" rows="3" placeholder="Descripción del combo" name="descripcion" id="detalles"><?= $resultadoD['combo_descripcion']; ?></textarea>
												</div>
											</div>

											<div class="form-group col-md-2">
												<label for="inputDescuento">Descuento:</label>
												<input type="number" class="form-control" id="inputDescuento" placeholder="Tiene descuento el combo?" name="desc" value="<?= $resultadoD['combo_descuento']; ?>">
											</div>

											<div class="form-group col-md-6" id="relacion-productos-container">
												<label>Productos del combo:</label>
												<select data-placeholder="Escoja los productos del combo" class="form-control select2" multiple="multiple" style="width: 100%;" name="productos[]" id="productos-select">
													<?php
													Productos::foreignKey(Productos::INNER, [
														"cprod_id" => 'ccp_producto',
														"cprod_id_empresa" => 'ccp_empresa'
													]);
													$result = Combos_Productos::SelectJoin(
														[
															'ccp_combo' => $_GET["id"]

														],
														"cprod_id, cprod_nombre",
														[
															Productos::class
														]
													);

													foreach ($result as $resProducto) {
													?>
														<option selected value="<?= $resProducto['cprod_id']; ?>"><?= strtoupper($resProducto['cprod_nombre']); ?></option>
													<?php } ?>
												</select>
											</div>

											<div class="form-group col-md-3">
												<label>Activo:</label>
												<select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="estado">
													<option value=""></option>
													<option value="SI" <?= $resultadoD['combo_activo'] == SI ? "selected" : "" ?> >SI</option>
													<option value="NO" <?= $resultadoD['combo_activo'] == NO ? "selected" : "" ?> >NO</option>
												</select>
											</div>
										</div>
										<!-- /.card-body -->
										<div class="card-footer">
											<button type="submit" class="btn btn-primary">Actualizar</button>
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
		})
	</script>
	<script src="<?= REDIRECT_ROUTE ?>dist/js/productos.js"></script>
	<?php include(RUTA_PROYECTO . "includes/pie.php"); ?>
</body>

</html>