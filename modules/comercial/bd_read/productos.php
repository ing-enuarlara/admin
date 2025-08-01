<?php
include("../../sesion.php");

$idPagina = 20;

include(RUTA_PROYECTO . "includes/verificar-paginas.php");
include(RUTA_PROYECTO . "includes/head.php");

$filtros = [];

if (!empty($_GET["cliAdmin"])) {
    $filtros[] = "cprod_id_empresa='" . $_GET["cliAdmin"] . "'";
}
if (!empty($_GET["marca"])) {
    $filtros[] = "cprod_tipo='" . $_GET["marca"] . "'";
}
if (!empty($_GET["cat"])) {
    $filtros[] = "cprod_categoria='" . $_GET["cat"] . "'";
}
if (!empty($_GET["subCat"])) {
    $filtros[] = "cprod_marca='" . $_GET["subCat"] . "'";
}
if (!empty($_GET["estado"])) {
    $filtros[] = "cprod_estado='" . $_GET["estado"] . "'";
}
if (!empty($_GET['search'])) {
    $busqueda = $_GET['search'];
    $filtros[] = "(
        cprod_id LIKE '%$busqueda%' OR 
        cprod_nombre LIKE '%$busqueda%' OR 
        cprod_cod_ref LIKE '%$busqueda%' OR 
        cprod_ean_code LIKE '%$busqueda%' OR 
        ctipo_nombre LIKE '%$busqueda%' OR 
        ccat_nombre LIKE '%$busqueda%' OR 
        cmar_nombre LIKE '%$busqueda%' OR 
        cprod_referencias LIKE '%$busqueda%'
    )";
}

$filtro = implode(" AND ", $filtros);
?>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/fontawesome-free/css/all.min.css">
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

        <?php //include(RUTA_PROYECTO."includes/carga.php"); 
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
                            <h2 class="m-0 float-sm-right"><?= $paginaActual['pag_nombre'] ?></h2>
                            <a href="productos-agregar.php" class="btn btn-primary"><i class="fas fa-solid fa-plus"></i> Agregar Productos</a>
                            <a href="productos-importar.php" class="btn btn-warning"><i class="fas fa-download"></i> Importar Productos</a>
                            <!-- <a href="productos-importar-fotos.php" class="btn btn-info"><i class="fas fa-download"></i> Importar Fotos</a> -->
                            <a href="productos-importar-especificacioines.php" class="btn btn-success"><i class="fas fa-download"></i> Importar Especificaciones</a>
                        </div>
                        <!-- /.card-header -->
                        <?php include(RUTA_PROYECTO . "includes/mod-buscador.php"); ?>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nº</th>
                                        <th>ID/Cod/Ref</th>
                                        <th></th>
                                        <th>Nombre Producto</th>
                                        <th>Precio</th>
                                        <th>Existencia</th>
                                        <th>Marca</th>
                                        <th>Categoria</th>
                                        <th>Sub-Categoria</th>
                                        <th>Estado</th>
                                        <?php
                                        if ($_SESSION["datosUsuarioActual"]['usr_tipo'] == DEV) {
                                        ?>
                                            <th>Nombre Empresa</th>
                                        <?php } ?>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $predicado = [];
                                    if ($_SESSION["datosUsuarioActual"]['usr_tipo'] != DEV) {
                                        $predicado = ['cprod_id_empresa' => $_SESSION["idEmpresa"]];
                                    }
                                    require_once(RUTA_PROYECTO . 'class/Productos.php');
                                    require_once(RUTA_PROYECTO . 'class/Productos_Fotos.php');
                                    require_once(RUTA_PROYECTO . 'class/Tipos_Productos.php');
                                    require_once(RUTA_PROYECTO . 'class/Categorias.php');
                                    require_once(RUTA_PROYECTO . 'class/SubCategorias.php');
                                    require_once(RUTA_PROYECTO . 'class/Productos_Tallas.php');
                                    require_once(RUTA_PROYECTO . 'class/Clientes_Admin.php');
                                    require_once(RUTA_PROYECTO . 'class/ApiSiniwin.php');

                                    Tipos_Productos::foreignKey(Tipos_Productos::LEFT, [
                                        "ctipo_id" => 'cprod_tipo'
                                    ]);
                                    Categorias::foreignKey(Categorias::LEFT, [
                                        "ccat_id" => 'cprod_categoria'
                                    ]);
                                    SubCategorias::foreignKey(SubCategorias::LEFT, [
                                        "cmar_id" => 'cprod_marca'
                                    ]);

                                    if (!empty($filtro)) {
                                        if (!is_array($predicado)) $predicado = [];
                                        $predicado[Productos::OTHER_PREDICATE] = $filtro;
                                    }

                                    include(RUTA_PROYECTO . "includes/consulta-paginacion-productos.php");

                                    if ($numRegistros > 0) {
                                        $num = $inicio + 1;
                                        foreach ($productos as $result) {
                                            $marca = !empty($result['ctipo_nombre']) ? $result['ctipo_nombre'] : "";

                                            $categoria = !empty($result['ccat_nombre']) ? $result['ccat_nombre'] : "";

                                            $subCategoria = !empty($result['cmar_nombre']) ? $result['cmar_nombre'] : "";

                                            $estado = "Activo";
                                            $color = "green";
                                            if ($result['cprod_estado'] != 1) {
                                                $estado = "Inactivo";
                                                $color = "red";
                                            }

                                            $colorExistencia = $result['cprod_exitencia'] <= 5 ? "red" : "green";

                                            $resultF = Productos_Fotos::Select([
                                                "cpf_id_producto"    => $result['cprod_id'],
                                                "cpf_principal"        => 1,
                                                "cpf_fotos_prin"    => NO
                                            ])->fetch(PDO::FETCH_ASSOC);
                                            $rutaFoto = "";
                                            if (!empty($resultF['cpf_fotos'])) {
                                                switch ($resultF['cpf_tipo']) {
                                                    case TIPO_IMG:
                                                        if (file_exists(RUTA_PROYECTO . "files/productos/" . $resultF['cpf_fotos'])) {
                                                            $rutaFoto = REDIRECT_ROUTE . "files/productos/" . $resultF['cpf_fotos'];
                                                        }
                                                        break;
                                                    case TIPO_URL:
                                                        $rutaFoto = $resultF['cpf_fotos'];
                                                        break;
                                                }
                                            }

                                            if ($_SESSION["datosUsuarioActual"]['usr_tipo'] == DEV) {
                                                $resultC = Clientes_Admin::Select([
                                                    "cliAdmi_id" => $result['cprod_id_empresa']
                                                ])->fetch(PDO::FETCH_ASSOC);
                                            }
                                    ?>
                                            <tr>
                                                <td><?= $num; ?></td>
                                                <td style="text-align: right;"><?= !empty($result['cprod_cod_ref']) ? $result['cprod_cod_ref'] : $result['cprod_id']; ?></td>
                                                <td align="center">
                                                    <?php if (!empty($rutaFoto)) { ?>
                                                        <img src="<?= $rutaFoto ?>" width="40">
                                                    <?php } ?>
                                                </td>
                                                <td><?= $result['cprod_nombre']; ?></td>
                                                <td style="text-align: right;"><?= number_format($result['cprod_costo'], 2, ",", "."); ?> €</td>
                                                <td style="color: <?= $colorExistencia; ?>;"><?= $result['cprod_exitencia']; ?></td>
                                                <td>
                                                    <a href="<?= $_SERVER['PHP_SELF']; ?>?marca=<?= $result['cprod_tipo']; ?>"><?= $marca; ?></a>
                                                </td>
                                                <td>
                                                    <a href="<?= $_SERVER['PHP_SELF']; ?>?cat=<?= $result['cprod_categoria']; ?>"><?= $categoria; ?></a>
                                                </td>
                                                <td>
                                                    <a href="<?= $_SERVER['PHP_SELF']; ?>?subCat=<?= $result['cprod_marca']; ?>"><?= $subCategoria; ?></a>
                                                </td>
                                                <td>
                                                    <a style="color: <?= $color; ?>;" href="<?= $_SERVER['PHP_SELF']; ?>?estado=<?= $result['cprod_estado']; ?>"><?= $estado; ?></a>
                                                </td>
                                                <?php
                                                if ($_SESSION["datosUsuarioActual"]['usr_tipo'] == DEV) {
                                                ?>
                                                    <td>
                                                        <a href="<?= $_SERVER['PHP_SELF']; ?>?cliAdmin=<?= $resultC['cliAdmi_id']; ?>"><?= $resultC['cliAdmi_nombre']; ?></a>
                                                    </td>
                                                <?php } ?>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info">Acciones</button>
                                                        <button type="button" class="btn btn-info dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <div class="dropdown-menu" role="menu">
                                                            <?php if (empty($result['fuente'])) { ?>
                                                                <a class="dropdown-item" href="productos-editar.php?id=<?= $result['cprod_id']; ?>" data-toggle="tooltip">Editar</a>
                                                                <a class="dropdown-item" href="../bd_delete/productos-eliminar.php?id=<?= $result['cprod_id']; ?>" onClick="if(!confirm('Este registro se eliminará del sistema, Desea continuar bajo su responsabilidad?')){return false;}" data-toggle="tooltip">Eliminar</a>
                                                            <?php } ?>
                                                            <a class="dropdown-item" href="productos-fotos.php?id=<?= $result['cprod_id']; ?>" data-toggle="tooltip">Fotos del Producto</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php $num++;
                                        }
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nº</th>
                                        <th>ID/Cod/Ref</th>
                                        <th></th>
                                        <th>Nombre Producto</th>
                                        <th>Precio</th>
                                        <th>Existencia</th>
                                        <th>Marca</th>
                                        <th>Categoria</th>
                                        <th>Sub-Categoria</th>
                                        <th>Estado</th>
                                        <?php
                                        if ($_SESSION["datosUsuarioActual"]['usr_tipo'] == DEV) {
                                        ?>
                                            <th>Nombre Empresa</th>
                                        <?php } ?>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <?php include(RUTA_PROYECTO . "includes/enlaces-paginacion.php"); ?>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </section>
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
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    <?php include(RUTA_PROYECTO . "includes/pie.php"); ?>
</body>

</html>