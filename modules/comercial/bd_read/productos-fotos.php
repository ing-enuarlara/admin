<?php
include("../../sesion.php");

$idPagina = 56;

include(RUTA_PROYECTO . "includes/verificar-paginas.php");
include(RUTA_PROYECTO . "includes/head.php");
require_once(RUTA_PROYECTO . 'class/Productos_Tallas.php');

try {
    $consuluta = $conexionBdComercial->query("SELECT * FROM comercial_productos WHERE cprod_id='" . $_GET["id"] . "'");
} catch (Exception $e) {
    include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
}
$resultadoD = mysqli_fetch_array($consuluta, MYSQLI_BOTH);

$coloresVariacion = Productos_Tallas::Select(
    [
        'cpta_producto' => $resultadoD['cprod_id'],
        'cpta_prin' => NO
    ], "cpta_color"
)->fetchAll(PDO::FETCH_ASSOC);
$colores = [];
foreach ($coloresVariacion as $color) {
    if (!in_array($color['cpta_color'], $colores)) {
        $colores[] = $color['cpta_color'];
    }
}
?>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/fontawesome-free/css/all.min.css">
<!-- Ekko Lightbox -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/ekko-lightbox/ekko-lightbox.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- JQVMap -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/jqvmap/jqvmap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>dist/css/adminlte.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/daterangepicker/daterangepicker.css">
<!-- summernote -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/summernote/summernote-bs4.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
                                <li class="breadcrumb-item"><a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/productos.php">Productos</a></li>
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
                    <div class="card">
                        <div class="card-header">
                            <h2 class="m-0 float-sm-right"><?= $paginaActual['pag_nombre'] . " de " . $resultadoD['cprod_nombre'] ?></h2>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                                <i class="fas fa-solid fa-plus"></i> Agregar Fotos
                            </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <?php
                                try {
                                    $consultaFotos = $conexionBdComercial->query("SELECT * FROM comercial_productos_fotos WHERE cpf_id_producto='" . $_GET["id"] . "' AND cpf_fotos_prin = '" . NO . "'");
                                } catch (Exception $e) {
                                    include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
                                }
                                while ($resultadoFotos = mysqli_fetch_array($consultaFotos, MYSQLI_BOTH)) {

                                    $rutaFoto = !empty($resultadoFotos['cpf_tipo']) ? ($resultadoFotos['cpf_tipo'] == TIPO_IMG ? REDIRECT_ROUTE . "files/productos/" . $resultadoFotos['cpf_fotos'] : $resultadoFotos['cpf_fotos']) : "";
                                ?>
                                    <div class="col-sm-2">
                                        <a href="<?= $rutaFoto ?>" data-toggle="lightbox" data-title="<?= $resultadoD['cprod_nombre'] ?>" data-gallery="gallery">
                                            <img src="<?= $rutaFoto ?>" class="img-fluid mb-2" alt="Foto para <?= $resultadoD['cprod_nombre'] ?>" />
                                        </a>
                                        <?php
                                        // if($resultadoFotos['cpf_principal']!=1){
                                        ?>
                                        <div class="form-group" style="display: flex;">
                                            <a href="../bd_delete/productos-fotos-eliminar.php?id=<?= $_GET["id"] ?>&idPf=<?= $resultadoFotos['cpf_id'] ?>" onClick="if(!confirm('Este registro se eliminará del sistema, Desea continuar bajo su responsabilidad?')){return false;}" class="btn btn-danger" style="margin: auto;"><i class="fa fa-trash"></i></a>
                                        </div>
                                        <?php
                                        // }
                                        ?>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </section>

            <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <form class="form-horizontal" method="post" action="../bd_create/productos-fotos-guardar.php" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $_GET["id"]; ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Cargar Foto</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php if (!empty($colores) && count(array_filter($colores))) { ?>
                                    <div class="form-group col-md-12">
                                        <label for="exampleInputEmail1">Relacionar con color:</label>
                                        <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="color" id="color">
                                            <option value="">Para el Producto General</option>
                                            <?php foreach ($colores as $color) { ?>
                                                <option value="<?= $color ?>" ><?= $coloresBases[$color]; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                <?php } ?>
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1">Tipo de Imagen:</label>
                                    <select data-placeholder="Escoja una opción" class="form-control select2" onchange="cargarImagen(this)" style="width: 100%;" name="tipoImg" id="tipoImg">
                                        <option value=""></option>
                                        <option value="<?= TIPO_IMG ?>" <?= $resultadoD['cpf_tipo'] == TIPO_IMG ? "selected" : ""; ?>>Imagen</option>
                                        <option value="<?= TIPO_URL ?>" <?= $resultadoD['cpf_tipo'] == TIPO_URL ? "selected" : ""; ?>>Url</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12" id="tipoFile" style="display:none;">
                                    <label for="customFile">Foto Principal</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="ftProducto[]" multiple>
                                        <label class="custom-file-label" for="customFile">Escoger Foto...</label>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById("customFile").addEventListener("change", function() {
                                        var files = this.files;
                                        var label = Array.from(files).map(f => f.name).join(", ");
                                        this.nextElementSibling.innerText = label || "Escoger Foto...";
                                    });
                                </script>
                                <div class="form-group col-md-12" id="tipoUrl" style="display:none;">
                                    <label for="exampleInputEmail1">Url de la Imagen:</label>
                                    <input type="text" class="form-control" placeholder="Url de la Imagen" name="urlProducto" id="urlImg">
                                </div>
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
                                </script>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </form>
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
        <?php include(RUTA_PROYECTO . "includes/footer.php"); ?>
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>
    <!-- jQuery -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Ekko Lightbox -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <!-- ChartJS -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/moment/moment.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= REDIRECT_ROUTE ?>dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?= REDIRECT_ROUTE ?>dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?= REDIRECT_ROUTE ?>dist/js/pages/dashboard.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/jszip/jszip.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
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