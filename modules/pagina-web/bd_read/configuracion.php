<?php
include("../../sesion.php");

$idPagina = 38;

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
            <div class="col-md-12">
              <div class="card card-success">
                <div class="card-header">
                  <h5 class="float-sm-right"><?= $paginaActual['pag_nombre'] ?></h5>
                </div>
                <?php
                $consultaConfigPaginaWeb = $conexionBdPaginaWeb->query("SELECT * FROM configuracion WHERE conf_id_empresa='" . $datosUsuarioActual['usr_id_empresa'] . "'");
                $configuracionPaginaWeb = mysqli_fetch_array($consultaConfigPaginaWeb, MYSQLI_BOTH);

                $default = 'files/default.png';
                $rutaLogo = $default;
                if (!empty($configuracionPaginaWeb['conf_logo'])) {
                  $rutaLogo = 'files/logo/' . $configuracionPaginaWeb['conf_logo'];
                }
                $rutaImgMenu = $default;
                if (!empty($configuracionPaginaWeb['conf_imgMenu'])) {
                  $rutaImgMenu = 'files/' . $configuracionPaginaWeb['conf_imgMenu'];
                }
                $bannerP1 = $default;
                if (!empty($configuracionPaginaWeb['conf_banner_p1'])) {
                  $bannerP1 = 'files/banner/' . $configuracionPaginaWeb['conf_banner_p1'];
                }
                $bannerP2 = $default;
                if (!empty($configuracionPaginaWeb['conf_banner_p2'])) {
                  $bannerP2 = 'files/banner/' . $configuracionPaginaWeb['conf_banner_p2'];
                }
                $bannerP3 = $default;
                if (!empty($configuracionPaginaWeb['conf_banner_p3'])) {
                  $bannerP3 = 'files/banner/' . $configuracionPaginaWeb['conf_banner_p3'];
                }
                $bannerP4 = $default;
                if (!empty($configuracionPaginaWeb['conf_banner_p4'])) {
                  $bannerP4 = 'files/banner/' . $configuracionPaginaWeb['conf_banner_p4'];
                }
                $bannerP5 = $default;
                if (!empty($configuracionPaginaWeb['conf_banner_p5'])) {
                  $bannerP5 = 'files/banner/' . $configuracionPaginaWeb['conf_banner_p5'];
                }
                $bannerP6 = $default;
                if (!empty($configuracionPaginaWeb['conf_banner_p6'])) {
                  $bannerP6 = 'files/banner/' . $configuracionPaginaWeb['conf_banner_p6'];
                }
                $bannerG1 = $default;
                if (!empty($configuracionPaginaWeb['conf_banner_g1'])) {
                  $bannerG1 = 'files/banner/' . $configuracionPaginaWeb['conf_banner_g1'];
                }
                $slider1 = $default;
                if (!empty($configuracionPaginaWeb['conf_slider1'])) {
                  $slider1 = 'files/slider/' . $configuracionPaginaWeb['conf_slider1'];
                }
                $slider2 = $default;
                if (!empty($configuracionPaginaWeb['conf_slider2'])) {
                  $slider2 = 'files/slider/' . $configuracionPaginaWeb['conf_slider2'];
                }

                $numeroWhatsapp = '';
                if (!empty($configuracionPaginaWeb['conf_whatsapp'])) {
                  $whatsapp = explode("=57", $configuracionPaginaWeb['conf_whatsapp']);
                  $numeroWhatsapp = $whatsapp[1];
                }
                ?>

                <!-- form start -->
                <form class="form-horizontal" method="post" action="../bd_update/configuracion-actualizar.php" enctype="multipart/form-data">
                  <input type="hidden" name="id" value="<?= $configuracionPaginaWeb['conf_id_empresa'] ?>">
                  <div class="card-body p-0">
                    <div class="bs-stepper">
                      <div class="bs-stepper-header" role="tablist">
                        <!-- your steps here -->
                        <div class="step" data-target="#inforPagina-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="inforPagina-part" id="inforPagina-part-trigger">
                            <span class="bs-stepper-circle">1</span>
                            <span class="bs-stepper-label">Información de la Pagina</span>
                          </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#redSocial-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="redSocial-part" id="redSocial-part-trigger">
                            <span class="bs-stepper-circle">2</span>
                            <span class="bs-stepper-label">Redes Sociales</span>
                          </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#imgInicio-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="imgInicio-part" id="imgInicio-part-trigger">
                            <span class="bs-stepper-circle">3</span>
                            <span class="bs-stepper-label">Imagenes de Inicio</span>
                          </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#slider-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="slider-part" id="slider-part-trigger">
                            <span class="bs-stepper-circle">4</span>
                            <span class="bs-stepper-label">Imagenes de Slider</span>
                          </button>
                        </div>
                      </div>
                      <div class="bs-stepper-content">
                        <!-- your steps content here -->
                        <div id="inforPagina-part" class="content" role="tabpanel" aria-labelledby="inforPagina-part-trigger">

                          <div class="col-md-6" style="margin-top: 10px;">
                            <div class="filtr-item col-md-12" data-category="1" data-sort="white sample">
                              <a href="<?= REDIRECT_ROUTE . $rutaLogo ?>" data-toggle="lightbox" data-title="Logo de la empresa">
                                <img src="<?= REDIRECT_ROUTE . $rutaLogo ?>" class="img-fluid mb-2" alt="white sample" style="margin-left: auto; margin-right: auto; display: flex; flex-wrap: wrap; width: 200px;" />
                              </a>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="customFile">Logo</label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="customFile" name="foto">
                              <label class="custom-file-label" for="customFile">Escoger Logo...</label>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Nombre de la Tienda:</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nombre de la Tienda" name="nombre" value="<?= $configuracionPaginaWeb['conf_empresa'] ?>">
                          </div>

                          <div class="form-group col-md-6">
                            <label>Email:</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                              </div>
                              <input type="email" class="form-control" placeholder="Email" name="email" value="<?= $configuracionPaginaWeb['conf_email'] ?>">
                            </div>
                          </div>
                          <!-- phone mask -->

                          <div class="form-group col-md-6">
                            <label>Telefono:</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                              </div>
                              <input type="text" class="form-control" placeholder="Telefono" name="telefono" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?= $configuracionPaginaWeb['conf_telefono'] ?>">
                            </div>
                            <!-- /.input group -->
                          </div>

                          <div class="form-group col-md-6">
                            <label for="direccion">Dirección de la tienda:</label>
                            <textarea name="direccion" id="direccion"><?= $configuracionPaginaWeb['conf_direccion'] ?></textarea>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="summernote">Texto para Encabezado:</label>
                            <textarea name="textEncabezado" id="summernote"><?= $configuracionPaginaWeb['conf_text_encabezado'] ?></textarea>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Envíos:</label>
                            <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="envios">
                              <option value=""></option>
                              <option value="NACIONALES" <?php if ($configuracionPaginaWeb['conf_envios'] == 'NACIONALES') echo "selected"; ?>>NACIONALES</option>
                              <option value="A TODO EL MUNDO" <?php if ($configuracionPaginaWeb['conf_envios'] == 'A TODO EL MUNDO') echo "selected"; ?>>A TODO EL MUNDO</option>
                            </select>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">URL de la tienda:</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Direccion Web" name="web" value="<?= $configuracionPaginaWeb['conf_web'] ?>">
                          </div>

                          <a class="btn btn-secondary" onclick="stepper.next()">Siguiente</a>
                        </div>
                        <div id="redSocial-part" class="content" role="tabpanel" aria-labelledby="redSocial-part-trigger">

                          <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Enlace para Facebook:</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa-brands fa-facebook-f"></i></span>
                              </div>
                              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Facebook" name="facebook" value="<?= $configuracionPaginaWeb['conf_facebook'] ?>">
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Enlace para Instagram:</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa-brands fa-instagram"></i></span>
                              </div>
                              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Instagram" name="instagram" value="<?= $configuracionPaginaWeb['conf_instagram'] ?>">
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Enlace para TikTok:</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa-brands fa-tiktok"></i></span>
                              </div>
                              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="TikTok" name="tiktok" value="<?= $configuracionPaginaWeb['conf_tiktok'] ?>">
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Numero para Whatsapp:</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa-brands fa-whatsapp"></i></span>
                              </div>
                              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Whatsapp" name="whatsapp" value="<?= $numeroWhatsapp ?>">
                            </div>
                          </div>

                          <a class="btn btn-secondary" onclick="stepper.previous()">Anterior</a>
                          <a class="btn btn-secondary" onclick="stepper.next()">Siguiente</a>
                        </div>
                        <div id="imgInicio-part" class="content" role="tabpanel" aria-labelledby="imgInicio-part-trigger">

                          <div class="col-md-6" style="margin-top: 10px;">
                            <div class="filtr-item col-md-12" data-category="1" data-sort="white sample">
                              <a href="<?= REDIRECT_ROUTE . $rutaImgMenu ?>" data-toggle="lightbox" data-title="Imagen del menu">
                                <img src="<?= REDIRECT_ROUTE . $rutaImgMenu ?>" class="img-fluid mb-2" alt="white sample" style="margin-left: auto; margin-right: auto; display: flex; flex-wrap: wrap; width: 200px;" />
                              </a>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="customFile">Imagen para Menu</label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="customFile" name="imgMenu">
                              <label class="custom-file-label" for="customFile">Escoger imagen...</label>
                            </div>
                          </div>

                          <div class="col-md-6" style="margin-top: 10px;">
                            <div class="filtr-item col-md-12" data-category="1" data-sort="white sample">
                              <a href="<?= REDIRECT_ROUTE . $bannerP1 ?>" data-toggle="lightbox" data-title="Banner Pequeño #1">
                                <img src="<?= REDIRECT_ROUTE . $bannerP1 ?>" class="img-fluid mb-2" alt="white sample" style="margin-left: auto; margin-right: auto; display: flex; flex-wrap: wrap; width: 200px;" />
                              </a>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="customFile">Banner Pequeño #1</label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="customFile" name="bannerP1">
                              <label class="custom-file-label" for="customFile">Escoger Banner Pequeño #1...</label>
                            </div>
                          </div>

                          <div class="col-md-6" style="margin-top: 10px;">
                            <div class="filtr-item col-md-12" data-category="1" data-sort="white sample">
                              <a href="<?= REDIRECT_ROUTE . $bannerP2 ?>" data-toggle="lightbox" data-title="Banner Pequeño #2">
                                <img src="<?= REDIRECT_ROUTE . $bannerP2 ?>" class="img-fluid mb-2" alt="white sample" style="margin-left: auto; margin-right: auto; display: flex; flex-wrap: wrap; width: 200px;" />
                              </a>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="customFile">Banner Pequeño #2</label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="customFile" name="bannerP2">
                              <label class="custom-file-label" for="customFile">Escoger Banner Pequeño #2...</label>
                            </div>
                          </div>

                          <div class="col-md-6" style="margin-top: 10px;">
                            <div class="filtr-item col-md-12" data-category="1" data-sort="white sample">
                              <a href="<?= REDIRECT_ROUTE . $bannerP3 ?>" data-toggle="lightbox" data-title="Banner Pequeño #3">
                                <img src="<?= REDIRECT_ROUTE . $bannerP3 ?>" class="img-fluid mb-2" alt="white sample" style="margin-left: auto; margin-right: auto; display: flex; flex-wrap: wrap; width: 200px;" />
                              </a>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="customFile">Banner Pequeño #3</label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="customFile" name="bannerP3">
                              <label class="custom-file-label" for="customFile">Escoger Banner Pequeño #3...</label>
                            </div>
                          </div>

                          <div class="col-md-6" style="margin-top: 10px;">
                            <div class="filtr-item col-md-12" data-category="1" data-sort="white sample">
                              <a href="<?= REDIRECT_ROUTE . $bannerP4 ?>" data-toggle="lightbox" data-title="Banner Pequeño #4">
                                <img src="<?= REDIRECT_ROUTE . $bannerP4 ?>" class="img-fluid mb-2" alt="white sample" style="margin-left: auto; margin-right: auto; display: flex; flex-wrap: wrap; width: 200px;" />
                              </a>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="customFile">Banner Pequeño #4</label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="customFile" name="bannerP4">
                              <label class="custom-file-label" for="customFile">Escoger Banner Pequeño #4...</label>
                            </div>
                          </div>

                          <div class="col-md-6" style="margin-top: 10px;">
                            <div class="filtr-item col-md-12" data-category="1" data-sort="white sample">
                              <a href="<?= REDIRECT_ROUTE . $bannerP5 ?>" data-toggle="lightbox" data-title="Banner Pequeño #5">
                                <img src="<?= REDIRECT_ROUTE . $bannerP5 ?>" class="img-fluid mb-2" alt="white sample" style="margin-left: auto; margin-right: auto; display: flex; flex-wrap: wrap; width: 200px;" />
                              </a>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="customFile">Banner Pequeño #5</label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="customFile" name="bannerP5">
                              <label class="custom-file-label" for="customFile">Escoger Banner Pequeño #5...</label>
                            </div>
                          </div>

                          <div class="col-md-6" style="margin-top: 10px;">
                            <div class="filtr-item col-md-12" data-category="1" data-sort="white sample">
                              <a href="<?= REDIRECT_ROUTE . $bannerP6 ?>" data-toggle="lightbox" data-title="Banner Pequeño #6">
                                <img src="<?= REDIRECT_ROUTE . $bannerP6 ?>" class="img-fluid mb-2" alt="white sample" style="margin-left: auto; margin-right: auto; display: flex; flex-wrap: wrap; width: 200px;" />
                              </a>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="customFile">Banner Pequeño #6</label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="customFile" name="bannerP6">
                              <label class="custom-file-label" for="customFile">Escoger Banner Pequeño #6...</label>
                            </div>
                          </div>

                          <div class="col-md-6" style="margin-top: 10px;">
                            <div class="filtr-item col-md-12" data-category="1" data-sort="white sample">
                              <a href="<?= REDIRECT_ROUTE . $bannerG1 ?>" data-toggle="lightbox" data-title="Banner Grande #1">
                                <img src="<?= REDIRECT_ROUTE . $bannerG1 ?>" class="img-fluid mb-2" alt="white sample" style="margin-left: auto; margin-right: auto; display: flex; flex-wrap: wrap; width: 200px;" />
                              </a>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="customFile">Banner Grande #1</label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="customFile" name="bannerG1">
                              <label class="custom-file-label" for="customFile">Escoger Banner Grande #1...</label>
                            </div>
                          </div>
                          <a class="btn btn-secondary" onclick="stepper.previous()">Anterior</a>
                          <a class="btn btn-secondary" onclick="stepper.next()">Siguiente</a>
                        </div>
                        <div id="slider-part" class="content" role="tabpanel" aria-labelledby="slider-part-trigger">

                          <div class="col-md-6" style="margin-top: 10px;">
                            <div class="filtr-item col-md-12" data-category="1" data-sort="white sample">
                              <a href="<?= REDIRECT_ROUTE . $slider1 ?>" data-toggle="lightbox" data-title="Slider #1">
                                <img src="<?= REDIRECT_ROUTE . $slider1 ?>" class="img-fluid mb-2" alt="white sample" style="margin-left: auto; margin-right: auto; display: flex; flex-wrap: wrap; width: 200px;" />
                              </a>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="customFile">Slider #1</label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="customFile" name="slider1">
                              <label class="custom-file-label" for="customFile">Escoger Slider #1...</label>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="textSlider1">Texto para Slider #1:</label>
                            <textarea name="textSlider1" id="textSlider1"><?= $configuracionPaginaWeb['conf_textSlider1'] ?></textarea>
                          </div>

                          <div class="col-md-6" style="margin-top: 10px;">
                            <div class="filtr-item col-md-12" data-category="1" data-sort="white sample">
                              <a href="<?= REDIRECT_ROUTE . $slider2 ?>" data-toggle="lightbox" data-title="Slider #2">
                                <img src="<?= REDIRECT_ROUTE . $slider2 ?>" class="img-fluid mb-2" alt="white sample" style="margin-left: auto; margin-right: auto; display: flex; flex-wrap: wrap; width: 200px;" />
                              </a>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="customFile">Slider #2</label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="customFile" name="slider2">
                              <label class="custom-file-label" for="customFile">Escoger Slider #2...</label>
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="textSlider2">Texto para Slider #2:</label>
                            <textarea name="textSlider2" id="textSlider2"><?= $configuracionPaginaWeb['conf_textSlider2'] ?></textarea>
                          </div>
                          <a class="btn btn-secondary" onclick="stepper.previous()">Anterior</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary float-sm-right">Guardar</button>
                  </div>
                </form>
              </div>
              <!-- /.card -->
            </div>
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
      $('#textSlider1').summernote()
      $('#textSlider2').summernote()
      $('#direccion').summernote()

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
      $('#fechaIni').datetimepicker({
        format: 'L'
      });
      $('#fechaFin').datetimepicker({
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