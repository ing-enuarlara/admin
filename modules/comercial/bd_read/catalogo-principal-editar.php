<?php
include("../../sesion.php");
require_once(RUTA_PROYECTO . 'class/Catalogo_Principal.php');
require_once(RUTA_PROYECTO . 'class/Productos_Fotos.php');
require_once(RUTA_PROYECTO . 'class/Clientes_Admin.php');
require_once(RUTA_PROYECTO . 'class/Tipos_Catalogo_Principal.php');
require_once(RUTA_PROYECTO . 'class/Categorias_Catalogo_Principal.php');
require_once(RUTA_PROYECTO . 'class/Productos_Especificaciones.php');

$idPagina = 163;

include(RUTA_PROYECTO . "includes/verificar-paginas.php");
include(RUTA_PROYECTO . "includes/head.php");

Productos_Fotos::foreignKey(Productos_Fotos::LEFT, [
  "cpf_id_producto"   => 'cprin_id',
  "cpf_principal"     => 1,
  "cpf_fotos_prin"    => '"' . SI . '"'
]);
try {
  $consulta = Catalogo_Principal::SelectJoin(
    [
      "cprin_id" => $_GET["id"]
    ],
    "*",
    [
      Productos_Fotos::class
    ]
  );
} catch (Exception $e) {
  include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
}
$resultadoD = $consulta[0];

$rutaFoto = !empty($resultadoD['cpf_tipo']) ? ($resultadoD['cpf_tipo'] == TIPO_IMG ? REDIRECT_ROUTE . "files/productos/" . $resultadoD['cpf_fotos'] : $resultadoD['cpf_fotos']) : "";
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

    <?php //include(RUTA_PROYECTO . "includes/carga.php"); 
    ?>

    <?php include(RUTA_PROYECTO . "includes/encabezado.php"); ?>

    <?php include(RUTA_PROYECTO . "includes/menu.php"); ?>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= REDIRECT_ROUTE ?>modules/index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/catalogo-principal.php">Ver Articulos</a></li>
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
                  <form class="form-horizontal" method="post" action="../bd_update/catalogo-principal-actualizar.php" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $_GET["id"]; ?>">
                    <div class="card-body">
                      <div class="col-md-6" style="margin-top: 10px;">
                        <div class="filtr-item col-md-12" data-category="1" data-sort="white sample">
                          <a href="<?= $rutaFoto ?>" data-toggle="lightbox" data-title="Foto principal del articulo">
                            <img src="<?= $rutaFoto ?>" class="img-fluid mb-2" alt="white sample" style="margin-left: auto; margin-right: auto; display: flex; flex-wrap: wrap; width: 200px;" />
                          </a>
                        </div>
                      </div>

                      <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Tipo de Imagen:</label>
                        <select data-placeholder="Escoja una opción" class="form-control select2" onchange="cargarImagen(this)" style="width: 100%;" name="tipoImg" id="tipoImg">
                          <option value=""></option>
                          <option value="<?= TIPO_IMG ?>" <?= $resultadoD['cpf_tipo'] == TIPO_IMG ? "selected" : ""; ?>>Imagen</option>
                          <option value="<?= TIPO_URL ?>" <?= $resultadoD['cpf_tipo'] == TIPO_URL ? "selected" : ""; ?>>Url</option>
                        </select>
                      </div>
                      <div class="form-group col-md-6" id="tipoFile" style="display:none;">
                        <label for="customFile">Foto Principal</label>
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="customFile" name="ftProducto">
                          <label class="custom-file-label" for="customFile">Escoger Foto...</label>
                        </div>
                      </div>
                      <div class="form-group col-md-6" id="tipoUrl" style="display:none;">
                        <label for="exampleInputEmail1">Url de la Imagen:</label>
                        <input type="text" class="form-control" placeholder="Url de la Imagen" name="urlProducto" id="urlImg">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Nombre:</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nombre del Articulo" name="nombre" value="<?= $resultadoD['cprin_nombre']; ?>">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Referencia:</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Referencia del Articulo" name="ref" value="<?= !empty($resultadoD['cprin_cod_ref']) ? $resultadoD['cprin_cod_ref'] : $resultadoD['cprin_id']; ?>">
                      </div>
                      <div class="form-group col-md-2">
                        <label for="exampleInputEmail1">Precio Base:</label>
                        <input type="number" class="form-control" id="exampleInputEmail1" placeholder="Precio del Articulo" name="costo" value="<?= $resultadoD['cprin_costo']; ?>">
                      </div>
                      <div class="form-group col-md-2">
                        <label for="exampleInputEmail1">Existencia:</label>
                        <input type="number" class="form-control" id="exampleInputEmail1" placeholder="Existencia del Producto" name="existencia" value="<?= $resultadoD['cprin_exitencia']; ?>">
                      </div>
                      <div class="form-group col-md-3">
                        <label>Tipo:</label>
                        <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="tipo">
                          <option value=""></option>
                          <?php
                          $predicadoTipo = [
                            'ctipop_estado' => 1
                          ];
                          if ($_SESSION["datosUsuarioActual"]['usr_tipo'] != DEV) {
                            $predicadoTipo = array_merge($predicadoTipo, ['ctipop_id_empresa' => $_SESSION["idEmpresa"]]);
                          }
                          try {
                            $consultaTiposProd = Tipos_Catalogo_Principal::Select($predicadoTipo)->fetchAll(PDO::FETCH_ASSOC);
                          } catch (Exception $e) {
                            include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
                          }
                          foreach ($consultaTiposProd as $datosTiposProd) {
                            $nombreEmpresa = '';
                            if ($_SESSION["datosUsuarioActual"]['usr_tipo'] == DEV) {
                              try {
                                $empresa = Clientes_Admin::Select([
                                  'cliAdmi_id' => $datosTiposProd['ctipop_id_empresa']
                                ])->fetch(PDO::FETCH_ASSOC);
                              } catch (Exception $e) {
                                include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
                              }
                              $nombreEmpresa = "[" . $empresa['cliAdmi_nombre'] . "]";
                            }
                            $selected = '';
                            if ($resultadoD['cprin_tipo'] == $datosTiposProd['ctipop_id']) {
                              $selected = 'selected';
                            }
                          ?>
                            <option value="<?= $datosTiposProd['ctipop_id']; ?>" <?= $selected; ?>><?= $datosTiposProd['ctipop_nombre'] . $nombreEmpresa; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Categoria:</label>
                        <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="categoria" id="categoria" onchange="traerSubCategorias()">
                          <option value=""></option>
                          <?php
                          $predicadoCat = [];
                          if ($_SESSION["datosUsuarioActual"]['usr_tipo'] != DEV) {
                            $predicadoCat = ['ccatp_id_empresa' => $_SESSION["idEmpresa"]];
                          }
                          try {
                            $consultaCategorias = Categorias_Catalogo_Principal::Select($predicadoCat)->fetchAll(PDO::FETCH_ASSOC);
                          } catch (Exception $e) {
                            include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
                          }
                          foreach ($consultaCategorias as $datosCategorias) {
                            $nombreEmpresa = '';
                            if ($_SESSION["datosUsuarioActual"]['usr_tipo'] == DEV) {
                              try {
                                $empresa = Clientes_Admin::Select([
                                  'cliAdmi_id' => $datosCategorias['ccatp_id_empresa']
                                ])->fetch(PDO::FETCH_ASSOC);
                              } catch (Exception $e) {
                                include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
                              }
                              $nombreEmpresa = "[" . $empresa['cliAdmi_nombre'] . "]";
                            }
                            $selected = '';
                            if ($resultadoD['cprin_categoria'] == $datosCategorias['ccatp_id']) {
                              $selected = 'selected';
                            }
                          ?>
                            <option value="<?= $datosCategorias['ccatp_id']; ?>" <?= $selected; ?>><?= $datosCategorias['ccatp_nombre'] . $nombreEmpresa; ?></option>
                          <?php } ?>
                        </select>
                        <span id="mensaje" style="color: #6017dc; display:none;">Espere un momento por favor.</span>
                      </div>
                      <div class="form-group col-md-6" id="subCategoria-container" style="display:none;">
                        <label>Sub-Categoria:</label>
                        <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="marca" id="marca" disabled>
                        </select>
                        <script type="application/javascript">
                          $(document).ready(traerSubCategorias(document.getElementById('categoria')));

                          function traerSubCategorias(enviada) {
                            var categoria = $('#categoria').val();
                            var subCategoria = <?= $resultadoD['cprin_marca']; ?>;
                            document.getElementById('marca').removeAttribute('disabled');

                            datos = "categoria=" + (categoria) +
                              "&subCategoria=" + (subCategoria);
                            console.log(datos);
                            $('#mensaje').show();
                            $.ajax({
                              type: "POST",
                              url: "../../../ajax/ajax-traer-sub-categorias-catalogo.php",
                              data: datos,
                              success: function(response) {
                                $('#marca').empty();
                                $('#marca').append(response);
                              }
                            });
                          }
                        </script>
                      </div>
                      <!-- textarea -->
                      <div class="form-group col-md-6">
                        <label>Detalles</label>
                        <textarea class="form-control" rows="3" placeholder="Detalles del producto ..." name="detalles" id="detalles" value=""><?= $resultadoD['cprin_detalles']; ?></textarea>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Descripción</label>
                        <textarea class="form-control" rows="3" placeholder="Descripción del producto ..." name="especificaciones" id="especificaciones" value=""><?= $resultadoD['cprin_especificaciones']; ?></textarea>
                      </div>
                      <!-- textarea -->
                      <div class="form-group col-md-6">
                        <label>Palabras Claves</label>
                        <textarea class="form-control" rows="1" placeholder="Best Seller, Cadenas, Cadenas 50cm, Tienda, ..." name="paClave"><?= $resultadoD['cprin_palabras_claves']; ?></textarea>
                      </div>

                      <hr>
                      <h5>Especificaciones del Producto</h5>

                      <script type="application/javascript">
                        function agregarColor() {
                          const container = document.getElementById("color-picker-container");
                          const div = document.createElement("div");
                          div.classList.add("form-group", "row", "mt-2");
                          div.innerHTML = `
                          <div class="col-md-6"><input type="color" class="form-control" name="especificaciones_colores[]" value="#000000"></div>
                          <div class="col-md-2"><button type="button" class="btn btn-danger" onclick="this.closest('.row').remove()">-</button></div>
                        `;
                          container.appendChild(div);
                        }

                        function agregarTalla() {
                          const container = document.getElementById("tallas-container");
                          const div = document.createElement("div");
                          div.classList.add("form-group", "row", "mt-2");
                          div.innerHTML = `
                          <div class="col-md-6"><input type="text" class="form-control" placeholder="Talla" name="especificaciones_tallas[]"></div>
                          <div class="col-md-2"><button type="button" class="btn btn-danger" onclick="this.closest('.row').remove()">-</button></div>
                        `;
                          container.appendChild(div);
                        }

                        function agregarOtraEspecificacion() {
                          const contenedor = document.getElementById("otras-especificaciones-container");
                          const nuevaFila = document.createElement("div");
                          nuevaFila.classList.add("row", "mb-2");
                          nuevaFila.innerHTML = `
                          <div class="col-md-5"><input type="text" class="form-control" placeholder="Etiqueta" name="otras_labels[]"></div>
                          <div class="col-md-5"><input type="text" class="form-control" placeholder="Valor" name="otras_values[]"></div>
                          <div class="col-md-2"><button type="button" class="btn btn-danger" onclick="this.closest('.row').remove()">-</button></div>
                        `;
                          contenedor.appendChild(nuevaFila);
                        }
                      </script>

                      <div class="form-group col-md-6">
                        <label>Selecciona colores: <button type="button" class="btn btn-success" onclick="agregarColor()">+</button></label>
                        <div id="color-picker-container">
                          <?php
                          $colores = Productos_Especificaciones::Select([
                            'cpt_id_producto' => $resultadoD['cprin_id'],
                            'cpt_tipo' => 'COLOR',
                            'cpt_tech_prin' => SI
                          ])->fetchAll(PDO::FETCH_ASSOC);

                          if (!empty($colores)) {
                            $numC = 1;
                            foreach ($colores as $color) {
                          ?>
                              <div class="row mb-2">
                                <div class="col-md-6"><input type="color" name="especificaciones_colores[]" class="form-control" value="<?= $color['cpt_value'] ?>"></div>
                                <div class="col-md-2"><button type="button" class="btn btn-danger" onclick="this.closest('.row').remove()">-</button></div>
                              </div>
                            <?php
                              $numC++;
                            }
                          } ?>
                        </div>
                      </div>

                      <div class="form-group col-md-6">
                        <label>Tallas disponibles:</label>
                        <div id="tallas-container">
                          <?php
                          $tallas = Productos_Especificaciones::Select([
                            'cpt_id_producto' => $resultadoD['cprin_id'],
                            'cpt_tipo' => 'TALLA',
                            'cpt_tech_prin' => SI
                          ])->fetchAll(PDO::FETCH_ASSOC);

                          if (!empty($tallas)) {
                            $numT = 1;
                            foreach ($tallas as $talla) {
                              $btn = $numT == 1 ? '<button type="button" class="btn btn-success" onclick="agregarTalla()">+</button>' : '<button type="button" class="btn btn-danger" onclick="this.closest(\'.row\').remove()">-</button>';
                          ?>
                              <div class="row mb-2">
                                <div class="col-md-6"><input type="text" name="especificaciones_tallas[]" class="form-control" value="<?= $talla['cpt_value'] ?>"></div>
                                <div class="col-md-2"><?= $btn ?></div>
                              </div>
                            <?php
                              $numT++;
                            }
                          } else {
                            ?>
                            <div class="row mb-2">
                              <div class="col-md-6"><input type="text" name="especificaciones_tallas[]" class="form-control"></div>
                              <div class="col-md-2"><button type="button" class="btn btn-success" onclick="agregarTalla()">+</button></div>
                            </div>
                          <?php } ?>
                        </div>
                      </div>

                      <div class="form-group col-md-6">
                        <label>Otras especificaciones:</label>
                        <div id="otras-especificaciones-container">
                          <?php
                          $otras = Productos_Especificaciones::Select([
                            'cpt_id_producto' => $resultadoD['cprin_id'],
                            'cpt_tipo' => 'OTRO',
                            'cpt_tech_prin' => SI
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
                      <div class="form-group col-md-3">
                        <label>Estado:</label>
                        <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="estado">
                          <option value=""></option>
                          <option value="1" <?php if ($resultadoD['cprin_estado'] == 1) {
                                              echo "selected";
                                            } ?>>Activo</option>
                          <option value="0" <?php if ($resultadoD['cprin_estado'] == 0) {
                                              echo "selected";
                                            } ?>>Inactivo</option>
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

    $(document).ready(function() {
      cargarImagen(document.getElementById('tipoImg'));
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