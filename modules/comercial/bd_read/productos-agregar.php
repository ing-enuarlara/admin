<?php
include("../../sesion.php");

$idPagina = 21;

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
                <form class="form-horizontal" method="post" action="../bd_create/productos-guardar.php" enctype="multipart/form-data">
                  <div class="card-body">
                    <div class="form-group col-md-6">
                      <label for="exampleInputEmail1">Nombre:</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nombre del Producto" name="nombre">
                    </div>

                    <div class="col-sm-6">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>Detalles</label>
                        <textarea class="form-control" rows="3" placeholder="Detalles del producto ..." name="detalles" id="detalles"></textarea>
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label>Descripción</label>
                      <textarea class="form-control" rows="3" placeholder="Descripción del producto ..." name="especificaciones" id="especificaciones" value=""></textarea>
                    </div>
                    
                    <div class="form-group col-md-2">
                      <label for="exampleInputEmail1">Precio:</label>
                      <input type="number" class="form-control" id="exampleInputEmail1" placeholder="Precio del Producto" name="costo" step="0.01">
                    </div>
                    
                    <div class="form-group col-md-2">
                      <label for="inputDescuento">Descuento:</label>
                      <input type="number" class="form-control" id="inputDescuento" placeholder="Tiene descuento el Producto?" name="desc">
                    </div>

                    <div class="form-group col-md-3">
                      <label>Marca:</label>
                      <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="tipo">
                        <option value=""></option>
                        <?php
                        $where = "";
                        if ($_SESSION["datosUsuarioActual"]['usr_tipo'] != DEV) {
                          $where = "AND ctipo_id_empresa='" . $_SESSION["idEmpresa"] . "'";
                        }
                        try {
                          $consultaTiposProd = $conexionBdComercial->query("SELECT * FROM comercial_marca_productos WHERE ctipo_estado=1 $where");
                        } catch (Exception $e) {
                          include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
                        }
                        while ($datosTiposProd = mysqli_fetch_array($consultaTiposProd, MYSQLI_BOTH)) {
                          $nombreEmpresa = '';
                          if ($_SESSION["datosUsuarioActual"]['usr_tipo'] == DEV) {
                            try {
                              $empresa = $conexionBdAdmin->query("SELECT * FROM clientes_admin WHERE cliAdmi_id='" . $datosTiposProd['ctipo_id_empresa'] . "'");
                            } catch (Exception $e) {
                              include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
                            }
                            $nomEmpresa = mysqli_fetch_array($empresa, MYSQLI_BOTH);
                            $nombreEmpresa = "[" . $nomEmpresa['cliAdmi_nombre'] . "]";
                          }
                        ?>
                          <option value="<?= $datosTiposProd[0]; ?>"><?= $datosTiposProd['ctipo_nombre'] . $nombreEmpresa; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group col-md-6">
                      <label>Categoria:</label>
                      <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="categoria" id="categoria" onchange="traerSubCategorias()">
                        <option value=""></option>
                        <?php
                        $where = "";
                        if ($_SESSION["datosUsuarioActual"]['usr_tipo'] != DEV) {
                          $where = "WHERE ccat_id_empresa='" . $_SESSION["idEmpresa"] . "'";
                        }
                        try {
                          $consultaCategorias = $conexionBdComercial->query("SELECT * FROM comercial_categorias $where");
                        } catch (Exception $e) {
                          include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
                        }
                        while ($datosCategorias = mysqli_fetch_array($consultaCategorias, MYSQLI_BOTH)) {
                          $nombreEmpresa = '';
                          if ($_SESSION["datosUsuarioActual"]['usr_tipo'] == DEV) {
                            try {
                              $empresa = $conexionBdAdmin->query("SELECT * FROM clientes_admin WHERE cliAdmi_id='" . $datosCategorias['ccat_id_empresa'] . "'");
                            } catch (Exception $e) {
                              include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
                            }
                            $nomEmpresa = mysqli_fetch_array($empresa, MYSQLI_BOTH);
                            $nombreEmpresa = "[" . $nomEmpresa['cliAdmi_nombre'] . "]";
                          }
                        ?>
                          <option value="<?= $datosCategorias[0]; ?>"><?= $datosCategorias['ccat_nombre'] . $nombreEmpresa; ?></option>
                        <?php } ?>
                      </select>
                      <span id="mensaje" style="color: #6017dc; display:none;">Espere un momento por favor.</span>
                    </div>

                    <div class="form-group col-md-6" id="subCategoria-container" style="display:none;">
                      <label>Sub-Categoria:</label>
                      <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="marca" id="marca" disabled>
                      </select>
                      <script type="application/javascript">
                        function traerSubCategorias(enviada) {
                          var categoria = $('#categoria').val();
                          document.getElementById('marca').removeAttribute('disabled');

                          datos = "categoria=" + (categoria);
                          console.log(datos);
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

                    <div class="form-group col-md-2" id="existecia">
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
                      <input type="number" class="form-control" id="exampleInputEmail1" placeholder="Existencia del Producto" name="existencia">
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
                      <input type="text" class="form-control" id="inputReferencia" placeholder="Referencia del Producto" name="ref">
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
                      <div class="input-group">
                          <label class="switchToggle">
                            <input type="checkbox" name="prodVariacion" id="prodVariacion" value="1" onchange="habilitarVariacion()" data-bootstrap-switch data-off-color="danger" data-on-color="success">
                            <span class="slider red round"></span>
                          </label>
                      </div>
                    </div>
                    
                    <div class="form-group col-md-12" id="variacion" style="display:none;">
                      <label>Variaciones disponibles:</label>
                      <div id="tallas-container">
                        <div class="row mb-2">
                          <div class="col-md-1"><input type="text" name="tallas[]" placeholder="Talla" class="form-control" /></div>
                          <div class="col-md-1">
                            <select name="colores[]" data-placeholder="1º color" class="form-control select2" style="width: 100%;">
                              <option value="">Selecciona un color</option>
                              <option value="#000000">Negro</option>
                              <option value="#696969">Gris</option>
                              <option value="#FFFFFF">Blanco</option>
                              <option value="#FF0000">Rojo</option>
                              <option value="#FFA500">Naranja</option>
                              <option value="#FFFF00">Amarillo</option>
                              <option value="#008000">Verde</option>
                              <option value="#0000FF">Azul</option>
                              <option value="#800080">Morado</option>
                              <option value="#8A2BE2">Violeta</option>
                              <option value="#A52A2A">Marrón</option>
                              <option value="#D2691E">Chocolate</option>
                              <option value="#F5DEB3">Beige</option>
                              <option value="#FFC0CB">Rosa</option>
                            </select>
                          </div>
                          <div class="col-md-1">
                            <select name="colores2[]" data-placeholder="2º color (Opcional)" class="form-control select2" style="width: 100%;">
                              <option value="">2º color (Opcional)</option>
                              <option value="#000000">Negro</option>
                              <option value="#696969">Gris</option>
                              <option value="#FFFFFF">Blanco</option>
                              <option value="#FF0000">Rojo</option>
                              <option value="#FFA500">Naranja</option>
                              <option value="#FFFF00">Amarillo</option>
                              <option value="#008000">Verde</option>
                              <option value="#0000FF">Azul</option>
                              <option value="#800080">Morado</option>
                              <option value="#8A2BE2">Violeta</option>
                              <option value="#A52A2A">Marrón</option>
                              <option value="#D2691E">Chocolate</option>
                              <option value="#F5DEB3">Beige</option>
                              <option value="#FFC0CB">Rosa</option>
                            </select>
                          </div>
                          <div class="col-md-1"><input type="number" name="stocks[]" placeholder="Stock" class="form-control" /></div>
                          <div class="col-md-3"><input type="text" name="referencias[]" id="refQuemada" placeholder="Referencia" class="form-control" /></div>
                          <div class="col-md-3"><input type="text" name="codEan[]" placeholder="EAN" class="form-control" /></div>
                          <div class="col-md-1"><button type="button" class="btn btn-success" onclick="agregarVariacion()">+</button></div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label>Especificaciones del Producto:</label>
                      <div id="otras-especificaciones-container">
                        <div class="row mb-2">
                          <div class="col-md-5"><input type="text" class="form-control" placeholder="Etiqueta" name="otras_labels[]"></div>
                          <div class="col-md-5"><input type="text" class="form-control" placeholder="Valor" name="otras_values[]"></div>
                          <div class="col-md-2"><button type="button" class="btn btn-success" onclick="agregarOtraEspecificacion()">+</button></div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-sm-6">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>Palabras Claves</label>
                        <textarea class="form-control" rows="1" placeholder="Best Seller, Cadenas, Cadenas 50cm, Tienda, ..." name="paClave"></textarea>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
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
  <!-- Summernote -->
  <script src="<?= REDIRECT_ROUTE ?>plugins/summernote/summernote-bs4.min.js"></script>
  <!-- Page specific script -->
  <script type="application/javascript">
    function habilitarVariacion() {
      var prodVariacion = document.getElementById("prodVariacion");
      var variacion = document.getElementById("variacion");
      const tallasContainer = document.getElementById("tallas-container");
      const inputReferencia = document.getElementById("inputReferencia");
      const referencia = inputReferencia.value || '';

      if (prodVariacion.checked) {
        variacion.style.display = "block";
        const refQuemada = document.getElementById("refQuemada");
        refQuemada.value = referencia;
      } else {
        variacion.style.display = "none";
        tallasContainer.innerHTML = `
        <div class="row mb-2">
          <div class="col-md-1"><input type="text" name="tallas[]" placeholder="Talla" class="form-control" /></div>
          <div class="col-md-1">
            <select name="colores[]" data-placeholder="1º color" class="form-control select2" style="width: 100%;">
              <option value="">1º color</option>
              <option value="#000000">Negro</option>
              <option value="#696969">Gris</option>
              <option value="#FFFFFF">Blanco</option>
              <option value="#FF0000">Rojo</option>
              <option value="#FFA500">Naranja</option>
              <option value="#FFFF00">Amarillo</option>
              <option value="#008000">Verde</option>
              <option value="#0000FF">Azul</option>
              <option value="#800080">Morado</option>
              <option value="#8A2BE2">Violeta</option>
              <option value="#A52A2A">Marrón</option>
              <option value="#D2691E">Chocolate</option>
              <option value="#F5DEB3">Beige</option>
              <option value="#FFC0CB">Rosa</option>
            </select>
          </div>
          <div class="col-md-1">
            <select name="colores2[]" data-placeholder="2º color (Opcional)" class="form-control select2" style="width: 100%;">
              <option value="">2º color (Opcional)</option>
              <option value="#000000">Negro</option>
              <option value="#696969">Gris</option>
              <option value="#FFFFFF">Blanco</option>
              <option value="#FF0000">Rojo</option>
              <option value="#FFA500">Naranja</option>
              <option value="#FFFF00">Amarillo</option>
              <option value="#008000">Verde</option>
              <option value="#0000FF">Azul</option>
              <option value="#800080">Morado</option>
              <option value="#8A2BE2">Violeta</option>
              <option value="#A52A2A">Marrón</option>
              <option value="#D2691E">Chocolate</option>
              <option value="#F5DEB3">Beige</option>
              <option value="#FFC0CB">Rosa</option>
            </select>
          </div>
          <div class="col-md-1"><input type="number" name="stocks[]" placeholder="Stock" class="form-control" /></div>
          <div class="col-md-3"><input type="text" name="referencias[]" id="refQuemada" placeholder="Referencia" class="form-control" value="${referencia}" /></div>
          <div class="col-md-3"><input type="text" name="codEan[]" placeholder="EAN" class="form-control" /></div>
          <div class="col-md-1"><button type="button" class="btn btn-success" onclick="agregarVariacion()">+</button></div>
        </div>`;
      }
      $('.select2').select2()
    }

    function agregarVariacion() {
      const inputReferencia = document.getElementById("inputReferencia");
      const referencia = inputReferencia.value || '';
      const container = document.getElementById("tallas-container");
      const div = document.createElement("div");
      div.classList.add("form-group", "row", "mt-2");
      div.innerHTML = `
                          <div class="col-md-1"><input type="text" name="tallas[]" placeholder="Talla" class="form-control" /></div>
                          <div class="col-md-1">
                            <select name="colores[]" data-placeholder="1º color" class="form-control select2" style="width: 100%;">
                              <option value="">1º color</option>
                              <option value="#000000">Negro</option>
                              <option value="#696969">Gris</option>
                              <option value="#FFFFFF">Blanco</option>
                              <option value="#FF0000">Rojo</option>
                              <option value="#FFA500">Naranja</option>
                              <option value="#FFFF00">Amarillo</option>
                              <option value="#008000">Verde</option>
                              <option value="#0000FF">Azul</option>
                              <option value="#800080">Morado</option>
                              <option value="#8A2BE2">Violeta</option>
                              <option value="#A52A2A">Marrón</option>
                              <option value="#D2691E">Chocolate</option>
                              <option value="#F5DEB3">Beige</option>
                              <option value="#FFC0CB">Rosa</option>
                            </select>
                          </div>
                          <div class="col-md-1">
                            <select name="colores2[]" data-placeholder="2º color (Opcional)" class="form-control select2" style="width: 100%;">
                              <option value="">2º color (Opcional)</option>
                              <option value="#000000">Negro</option>
                              <option value="#696969">Gris</option>
                              <option value="#FFFFFF">Blanco</option>
                              <option value="#FF0000">Rojo</option>
                              <option value="#FFA500">Naranja</option>
                              <option value="#FFFF00">Amarillo</option>
                              <option value="#008000">Verde</option>
                              <option value="#0000FF">Azul</option>
                              <option value="#800080">Morado</option>
                              <option value="#8A2BE2">Violeta</option>
                              <option value="#A52A2A">Marrón</option>
                              <option value="#D2691E">Chocolate</option>
                              <option value="#F5DEB3">Beige</option>
                              <option value="#FFC0CB">Rosa</option>
                            </select>
                          </div>
                          <div class="col-md-1"><input type="number" name="stocks[]" placeholder="Stock" class="form-control" /></div>
                          <div class="col-md-3"><input type="text" name="referencias[]" placeholder="Referencia" class="form-control" value="${referencia}" /></div>
                          <div class="col-md-3"><input type="text" name="codEan[]" placeholder="EAN" class="form-control" /></div>
                          <div class="col-md-1"><button type="button" class="btn btn-danger" onclick="this.closest('.row').remove()">-</button></div>
                        `;
      container.appendChild(div);
      $('.select2').select2()
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