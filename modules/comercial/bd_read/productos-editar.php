<?php
include("../../sesion.php");

$idPagina = 23;

include(RUTA_PROYECTO . "includes/verificar-paginas.php");
include(RUTA_PROYECTO . "includes/head.php");
require_once(RUTA_PROYECTO . "class/Productos.php");
require_once(RUTA_PROYECTO . "class/Categorias.php");
require_once(RUTA_PROYECTO . "class/SubCategorias.php");
require_once(RUTA_PROYECTO . "class/Tipos_Productos.php");
require_once(RUTA_PROYECTO . "class/Productos_Relacion.php");
require_once(RUTA_PROYECTO . 'class/Productos_Especificaciones.php');
require_once(RUTA_PROYECTO . 'class/Productos_Tallas.php');
require_once(RUTA_PROYECTO . 'class/Producto_Categorias.php');
require_once(RUTA_PROYECTO . 'class/Producto_Sub_Categorias.php');

$resultadoD = Productos::Select([
  'cprod_id' => $_GET['id']
], "*")->fetch(PDO::FETCH_ASSOC);

$arrayCate = Producto_Categorias::Select([
  'prct_producto' => $resultadoD['cprod_id'],
], "prct_categoria")->fetchAll(PDO::FETCH_COLUMN);
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
                <form class="form-horizontal" method="post" action="../bd_update/productos-actualizar.php" enctype="multipart/form-data">
                  <input type="hidden" name="id" id="id" value="<?= $_GET["id"]; ?>">
                  <div class="card-body">

                    <div class="form-group col-md-6">
                      <label for="exampleInputEmail1">Nombre:</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nombre del Producto" name="nombre" value="<?= htmlspecialchars($resultadoD['cprod_nombre']); ?>">
                    </div>

                    <!-- textarea -->
                    <div class="form-group col-md-6">
                      <label>Detalles</label>
                      <textarea class="form-control" rows="3" placeholder="Detalles del producto ..." name="detalles" id="detalles" value=""><?= $resultadoD['cprod_detalles']; ?></textarea>
                    </div>

                    <div class="form-group col-md-6">
                      <label>Descripción</label>
                      <textarea class="form-control" rows="3" placeholder="Descripción del producto ..." name="especificaciones" id="especificaciones" value=""><?= $resultadoD['cprod_especificaciones']; ?></textarea>
                    </div>

                    <div class="form-group col-md-2">
                      <label for="exampleInputEmail1">Precio:</label>
                      <input type="number" class="form-control" id="exampleInputEmail1" placeholder="Precio del Producto" name="costo" value="<?= $resultadoD['cprod_costo']; ?>" step="0.01">
                    </div>

                    <div class="form-group col-md-2">
                      <label for="inputDescuento">Descuento:</label>
                      <input type="number" class="form-control" id="inputDescuento" placeholder="Tiene descuento el Producto?" name="desc" value="<?= $resultadoD['cprod_descuento']; ?>">
                    </div>

                    <div class="form-group col-md-3">
                      <label>Marca:</label>
                      <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="tipo">
                        <option value=""></option>
                        <?php
                        $predicado['ctipo_estado'] = 1;
                        if ($_SESSION["datosUsuarioActual"]['usr_tipo'] != DEV) {
                          $predicado['ctipo_id_empresa'] = $_SESSION["idEmpresa"];
                        }
                        $consultaTiposProd = Tipos_Productos::Select($predicado, "ctipo_id, ctipo_nombre")->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($consultaTiposProd as $datosTiposProd) {
                          $selected = $resultadoD['cprod_tipo'] == $datosTiposProd['ctipo_id'] ? 'selected' : '';
                        ?>
                          <option value="<?= $datosTiposProd['ctipo_id']; ?>" <?= $selected; ?>><?= $datosTiposProd['ctipo_nombre']; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group col-md-6">
                      <label>Categoria:</label>
                      <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="categoria[]" multiple="multiple" id="categoria" onchange="traerSubCategorias()">
                        <option value=""></option>
                        <?php
                        $predicado = [];
                        if ($_SESSION["datosUsuarioActual"]['usr_tipo'] != DEV) {
                          $predicado['ccat_id_empresa'] = $_SESSION["idEmpresa"];
                        }
                        $consultaCategorias = Categorias::Select($predicado, "ccat_id, ccat_nombre")->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($consultaCategorias as $datosCategorias) {
                          $selected = in_array((int)$datosCategorias['ccat_id'], $arrayCate) ? 'selected' : '';
                        ?>
                          <option value="<?= $datosCategorias['ccat_id']; ?>" <?= $selected; ?>><?= $datosCategorias['ccat_nombre']; ?></option>
                        <?php } ?>
                      </select>
                      <span id="mensaje" style="color: #6017dc; display:none;">Espere un momento por favor.</span>
                    </div>

                    <div class="form-group col-md-6" id="subCategoria-container" style="display:none;">
                      <label>Sub-Categoria:</label>
                      <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="marca[]" multiple="multiple" id="marca" disabled>
                      </select>
                      <script type="application/javascript">
                        $(document).ready(traerSubCategorias(document.getElementById('categoria')));

                        function traerSubCategorias(enviada) {
                          var id = $('#id').val();
                          var categoria = $('#categoria').val();
                          document.getElementById('marca').removeAttribute('disabled');
                          datos = "id=" + (id) + "&categoria=" + (categoria);
                          $('#mensaje').show();
                          $.ajax({
                            type: "POST",
                            url: "../../../ajax/ajax-traer-sub-categorias.php",
                            data: datos,
                            success: function(response) {
                              $('#marca').empty();
                              $('#marca').append(response);
                            }
                          });
                        }
                      </script>
                    </div>

                    <div class="form-group col-md-2">
                      <label for="exampleInputEmail1">
                        Existencia:
                        <span
                          tabindex="0"
                          data-toggle="tooltip"
                          data-placement="top"
                          title="Si vas a usar variación del producto, puedes dejar este campo vacio y colocar por cada variación su stock y esta existencia total la calculara el sistema.">
                          <i class="fa fa-question-circle text-info"></i>
                        </span>
                      </label>
                      <input type="number" class="form-control" id="exampleInputEmail1" placeholder="Existencia del Producto" name="existencia" value="<?= $resultadoD['cprod_exitencia']; ?>">
                    </div>

                    <div class="form-group col-md-3">
                      <label for="inputCodigoEan">Codigo EAN:</label>
                      <input type="text" class="form-control" id="inputCodigoEan" placeholder="Codigo EAN del Producto" name="codigoEAN" value="<?= htmlspecialchars($resultadoD['cprod_ean_code']); ?>">
                    </div>

                    <div class="form-group col-md-3">
                      <label for="inputNucleo">
                        Nucleo Web:
                        <span
                          tabindex="0"
                          data-toggle="tooltip"
                          data-placement="top"
                          title="Si tienes variación de producto, coloca aqui un referente unico que contenga todos los colores del producto para poder relacionarlos en la web.">
                          <i class="fa fa-question-circle text-info"></i>
                        </span>
                      </label>
                      <input type="text" class="form-control" id="inputNucleo" placeholder="Nucleo Web del Producto" name="nucleo" value="<?= $resultadoD['cprod_nucleo_web'] ?? ""; ?>">
                    </div>

                    <div class="form-group col-md-3">
                      <label for="inputReferencia">
                        Referencia:
                        <span
                          tabindex="0"
                          data-toggle="tooltip"
                          data-placement="top"
                          title="En la variación del producto, puedes tambien manejar referencia para cada variación del producto.">
                          <i class="fa fa-question-circle text-info"></i>
                        </span>
                      </label>
                      <input type="text" class="form-control" id="inputReferencia" placeholder="Referencia del Producto" name="ref" value="<?= !empty($resultadoD['cprod_cod_ref']) ? $resultadoD['cprod_cod_ref'] : $resultadoD['cprod_id']; ?>">
                    </div>

                    <div class="form-group col-md-11">
                      <label for="prodVariacion">
                        Producto con variación?
                        <span
                          tabindex="0"
                          data-toggle="tooltip"
                          data-placement="top"
                          title="Si vas a usar variación del producto, como stockage por talla o color, o diferentes colores por tallas, puedes activar este checkbox.">
                          <i class="fa fa-question-circle text-info"></i>
                        </span>
                      </label>
                      <?php
                      $variaciones = Productos_Tallas::Select([
                        'cpta_producto' => $resultadoD['cprod_id'],
                        'cpta_prin' => NO
                      ])->fetchAll(PDO::FETCH_ASSOC);
                      $check = (!empty($variaciones) && count(array_filter($variaciones))) ? "checked" : "";
                      ?>
                      <div class="input-group">
                        <label class="switchToggle">
                          <input type="checkbox" name="prodVariacion" id="prodVariacion" <?= $check; ?> onchange="habilitarVariacion()" data-bootstrap-switch data-off-color="danger" data-on-color="success">
                          <span class="slider red round"></span>
                        </label>
                      </div>
                    </div>

                    <div class="form-group col-md-12" id="variacion" style="display:none;">
                      <label>Variaciones disponibles:</label>
                      <div id="tallas-container">
                        <?php
                        if (!empty($variaciones) && count(array_filter($variaciones))) {
                          $numT = 1;
                          foreach ($variaciones as $variacion) {
                            $btn = $numT == 1 ? '<button type="button" class="btn btn-success" onclick="agregarVariacion()">+</button>' : '<button type="button" class="btn btn-danger" onclick="this.closest(\'.row\').remove()">-</button>';
                        ?>
                            <div class="row mb-2">
                              <div class="col-md-1"><input type="text" name="tallas[]" placeholder="Talla" class="form-control" value="<?= $variacion['cpta_talla'] ?? '' ?>" /></div>
                              <div class="col-md-1"><input type="number" name="stocks[]" placeholder="Stock" class="form-control" value="<?= $variacion['cpta_stock'] ?? '' ?>" /></div>
                              <div class="col-md-3"><input type="text" name="referencias[]" placeholder="Referencia" class="form-control" value="<?= $variacion['cpta_referencia'] ?? '' ?>" /></div>
                              <div class="col-md-3"><input type="text" name="codEan[]" placeholder="EAN" class="form-control" value="<?= $variacion['cpta_cod_ean'] ?? '' ?>" /></div>
                              <div class="col-md-1"><?= $btn ?></div>
                            </div>
                          <?php
                            $numT++;
                          }
                        } else {
                          ?>
                          <div class="row mb-2">
                            <div class="col-md-1"><input type="text" name="tallas[]" placeholder="Talla" class="form-control" /></div>
                            <div class="col-md-1"><input type="number" name="stocks[]" placeholder="Stock" class="form-control" /></div>
                            <div class="col-md-3"><input type="text" name="referencias[]" id="refQuemada" placeholder="Referencia" class="form-control" /></div>
                            <div class="col-md-3"><input type="text" name="codEan[]" placeholder="EAN" class="form-control" /></div>
                            <div class="col-md-1"><button type="button" class="btn btn-success" onclick="agregarVariacion()">+</button></div>
                          </div>
                        <?php } ?>
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label>Especificaciones del Producto:</label>
                      <div id="otras-especificaciones-container">
                        <?php
                        $otras = Productos_Especificaciones::Select([
                          'cpt_id_producto' => $resultadoD['cprod_id'],
                          'cpt_tipo' => 'OTRO',
                          'cpt_tech_prin' => NO
                        ])->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($otras)) {
                          $numO = 1;
                          foreach ($otras as $otra) {
                            $btn = $numO == 1 ? '<button type="button" class="btn btn-success" onclick="agregarOtraEspecificacion()">+</button>' : '<button type="button" class="btn btn-danger" onclick="this.closest(\'.row\').remove()">-</button>';
                        ?>
                            <div class="row mb-2">
                              <div class="col-md-5"><input type="text" class="form-control" placeholder="Etiqueta" name="otras_labels[]" value="<?= $otra['cpt_lebel'] ?>"></div>
                              <div class="col-md-5"><input type="text" class="form-control" placeholder="Valor" name="otras_values[]" value="<?= $otra['cpt_value'] ?>"></div>
                              <div class="col-md-2"><?= $btn ?></div>
                            </div>
                          <?php
                            $numO++;
                          }
                        } else {
                          ?>
                          <div class="row mb-2">
                            <div class="col-md-5"><input type="text" class="form-control" placeholder="Etiqueta" name="otras_labels[]"></div>
                            <div class="col-md-5"><input type="text" class="form-control" placeholder="Valor" name="otras_values[]"></div>
                            <div class="col-md-2"><button type="button" class="btn btn-success" onclick="agregarOtraEspecificacion()">+</button></div>
                          </div>
                        <?php } ?>
                      </div>
                    </div>

                    <!-- textarea -->
                    <div class="form-group col-md-6">
                      <label>Palabras Claves</label>
                      <textarea class="form-control" rows="1" placeholder="Best Seller, Cadenas, Cadenas 50cm, Tienda, ..." name="paClave"><?= $resultadoD['cprod_palabras_claves']; ?></textarea>
                    </div>

                    <div class="form-group col-md-6" id="relacion-productos-container">
                      <label>Combinar Productos:</label>
                      <select data-placeholder="Escoja los productos a combinar" class="form-control select2" multiple="multiple" style="width: 100%;" name="productos[]" id="productos-select">
                        <?php
                          Productos::foreignKey(Productos::INNER, [
                              "cprod_id_empresa" => $_SESSION["idEmpresa"],
                              "AND" => "(cpre_producto = {$_GET["id"]} AND cprod_id = cpre_producto_relacion) OR (cpre_producto_relacion = {$_GET["id"]} AND cprod_id = cpre.cpre_producto)"
                          ]);
                          $result = Productos_Relacion::SelectJoin(
                              [
                                  Productos_Relacion::OTHER_PREDICATE => "cprod_id != {$_GET["id"]}"

                              ],
                              "cprod_id, cprod_nombre",
                              [
                                  Productos::class
                              ],"","cprod_id"
                          );

                          foreach ($result AS $resProducto) {
                        ?>
                          <option selected value="<?= $resProducto['cprod_id']; ?>"><?= strtoupper($resProducto['cprod_nombre']); ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group col-md-3">
                      <label>Estado:</label>
                      <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="estado">
                        <option value=""></option>
                        <option value="1" <?php if ($resultadoD['cprod_estado'] == 1) {
                                            echo "selected";
                                          } ?>>Activo</option>
                        <option value="0" <?php if ($resultadoD['cprod_estado'] == 0) {
                                            echo "selected";
                                          } ?>>Inactivo</option>
                      </select>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" class="btn btn-success">Actualizar</button>
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
  <!-- Ekko Lightbox -->
  <script src="<?= REDIRECT_ROUTE ?>plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
  <!-- Filterizr-->
  <script src="<?= REDIRECT_ROUTE ?>plugins/filterizr/jquery.filterizr.min.js"></script>
  <!-- Summernote -->
  <script src="<?= REDIRECT_ROUTE ?>plugins/summernote/summernote-bs4.min.js"></script>
  <!-- Page specific script -->
  <script type="application/javascript">
    $(function() {
      $('[data-toggle="tooltip"]').tooltip();
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

      $("input[data-bootstrap-switch]").each(function() {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
      })

    })
  </script>
  <script src="<?= REDIRECT_ROUTE ?>dist/js/productos.js"></script>
  <?php include(RUTA_PROYECTO . "includes/pie.php"); ?>
</body>

</html>