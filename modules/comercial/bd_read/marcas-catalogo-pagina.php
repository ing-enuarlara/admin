<?php
include("../../sesion.php");
require_once(RUTA_PROYECTO . 'class/SubCategorias_Catalogo_Principal.php');
require_once(RUTA_PROYECTO . 'class/Categorias_Catalogo_Principal.php');
require_once(RUTA_PROYECTO . 'class/Catalogo_Marca_pagina.php');
require_once(RUTA_PROYECTO . 'class/Sub_Categorias.php');
require_once(RUTA_PROYECTO . 'class/Clientes_Admin.php');

$idPagina = 190;

include(RUTA_PROYECTO . "includes/verificar-paginas.php");
include(RUTA_PROYECTO . "includes/head.php");

$resultadoD = SubCategorias_Catalogo_Principal::Select([
	"cmarp_id" => $_GET["id"]
])->fetch(PDO::FETCH_ASSOC);
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
								<li class="breadcrumb-item"><a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/marcas-catalogo.php">Ver Sub-Categorias del Catalogo</a></li>
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
									<form class="form-horizontal" method="post" action="../bd_create/marcas-catalogo-pagina-guardar.php" enctype="multipart/form-data">
										<input type="hidden" name="id" value="<?= $_GET["id"]; ?>">
										<div class="form-group col-md-6">
											<label for="exampleInputEmail1">Nombre:</label>
											<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nombre de la Sub-Categorias" readonly value="<?= $resultadoD['cmarp_nombre']; ?>">
										</div>
										<?php
										Categorias_Catalogo_Principal::foreignKey(Categorias_Catalogo_Principal::INNER, [
											'ccatp_id' => 'subca_cate',
											'ccatp_id_empresa' => $_SESSION["idEmpresa"]
										]);
										Catalogo_Marca_pagina::foreignKey(Catalogo_Marca_pagina::LEFT, [
											'cpmc_cate' => 'subca_cate',
											'cpmc_marca' => 'subca_marca'
										]);
										$categorias = Sub_Categorias::SelectJoin(
											[
												'subca_marca' => $resultadoD['cmarp_id'],
												'subca_prin' => SI
											],
											"ccatp_id, ccatp_nombre, cpmc.*",
											[
												Categorias_Catalogo_Principal::class,
												Catalogo_Marca_pagina::class
											]
										);
										$num = 1;
										foreach ($categorias as $categoria) {

											$rutaFoto = !empty($categoria['cpmc_tipo_img']) ? ($categoria['cpmc_tipo_img'] == TIPO_IMG ? REDIRECT_ROUTE . $categoria['cpmc_imagen'] : $categoria['cpmc_imagen']) : "";
										?>
											<div class="col-md-6" style="margin-top: 10px;">
												<div class="filtr-item col-md-12" data-category="1" data-sort="Imagen Sub-Categoria">
													<img src="<?= $rutaFoto ?? '' ?>" class="img-fluid mb-2" alt="Imagen Sub-Categoria" id="imgCate_<?= $categoria['ccatp_id'] ?>" style="margin-left: auto; margin-right: auto; display: flex; flex-wrap: wrap; width: 200px; max-width: 150px;" />
												</div>
											</div>
											<div class="form-group col-md-6">
												<label for="exampleInputEmail1">Tipo de Imagen para <?= $categoria['ccatp_nombre'] ?>:</label>
												<select data-placeholder="Escoja una opción" class="form-control select2" onchange="cargarImagen(<?= $categoria['ccatp_id'] ?>)" style="width: 100%;" name="data[<?= $categoria['ccatp_id'] ?>][tipoImg]" id="tipoImg_<?= $categoria['ccatp_id'] ?>">
													<option value=""></option>
													<option value="<?= TIPO_IMG ?>" <?= $categoria['cpmc_tipo_img'] == TIPO_IMG ? "selected" : ""; ?>>Imagen</option>
													<option value="<?= TIPO_URL ?>" <?= $categoria['cpmc_tipo_img'] == TIPO_URL ? "selected" : ""; ?>>Url</option>
												</select>
											</div>
											<div class="form-group col-md-6" id="tipoFile_<?= $categoria['ccatp_id'] ?>" style="display:none;">
												<label for="customFile_<?= $categoria['ccatp_id'] ?>">Imagen para <?= $categoria['ccatp_nombre'] ?></label>
												<div class="custom-file">
													<input type="file" class="custom-file-input" id="customFile_<?= $categoria['ccatp_id'] ?>" name="data[<?= $categoria['ccatp_id'] ?>][imgMarca]" onchange="cambiarIMG(<?= $categoria['ccatp_id'] ?>)">
													<label class="custom-file-label" for="customFile_<?= $categoria['ccatp_id'] ?>">Escoger Foto...</label>
												</div>
											</div>
											<div class="form-group col-md-6" id="tipoUrl_<?= $categoria['ccatp_id'] ?>" style="display:none;">
												<label for="exampleInputEmail1">Url de la Imagen para <?= $categoria['ccatp_nombre'] ?>:</label>
												<input type="text" class="form-control" placeholder="Url de la Imagen" name="data[<?= $categoria['ccatp_id'] ?>][urlMarca]" id="urlImg_<?= $categoria['ccatp_id'] ?>" onchange="cambiarIMG(<?= $categoria['ccatp_id'] ?>)" value="<?= $rutaFoto ?? '' ?>">
											</div>
											<div class="form-group col-md-6">
												<label>Concepto para <?= $categoria['ccatp_nombre'] ?>:</label>
												<textarea class="form-control" rows="3" placeholder="Concepto de la Sub-categoria.." name="data[<?= $categoria['ccatp_id'] ?>][concepto]" id="concepto<?= $num ?>" value=""><?= $categoria['cpmc_concepto']; ?></textarea>
											</div>
											<script>
												function cargarImagen(id) {
													const tipo = document.getElementById('tipoImg_' + id);
													const fileDiv = document.getElementById('tipoFile_' + id);
													const urlDiv = document.getElementById('tipoUrl_' + id);
													const urlInput = document.getElementById('urlImg_' + id);

													if (tipo.value === '<?= TIPO_IMG ?>') {
														if (urlInput) urlInput.value = '';
														fileDiv.style.display = 'block';
														urlDiv.style.display = 'none';
													} else if (tipo.value === '<?= TIPO_URL ?>') {
														fileDiv.style.display = 'none';
														urlDiv.style.display = 'block';
													}
												}

												function cambiarIMG(id) {
													let tipo = document.getElementById('tipoImg_' + id);
													let img = document.getElementById("imgCate_" + id);
													let input = document.getElementById("customFile_" + id);
													let urlInput = document.getElementById('urlImg_' + id);

													if (tipo.value === '<?= TIPO_IMG ?>') {
														if (input.files[0]) {
															img.src = URL.createObjectURL(input.files[0]);
														}
													} else if (tipo.value === '<?= TIPO_URL ?>') {
														if (urlInput) {
															img.src = urlInput.value;
														}
													}
												}

												$(document).ready(function() {
													cargarImagen(<?= $categoria['ccatp_id'] ?>);
												});
											</script>
										<?php $num++;
										} ?>
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
	<script>
		$(function() {
			// Summernote
			$('#concepto1').summernote();
			$('#concepto2').summernote();
			$('#concepto3').summernote();
			$('#concepto4').summernote();
			$('#concepto5').summernote();
			bsCustomFileInput.init();
			//Initialize Select2 Elements
			$('.select2').select2()

			//Initialize Select2 Elements
			$('.select2bs4').select2({
				theme: 'bootstrap4'
			})

		})
		// DropzoneJS Demo Code End
	</script>
	<?php include(RUTA_PROYECTO . "includes/pie.php"); ?>
</body>

</html>