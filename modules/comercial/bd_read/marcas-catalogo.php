<?php
include("../../sesion.php");
require_once(RUTA_PROYECTO . 'class/SubCategorias_Catalogo_Principal.php');
require_once(RUTA_PROYECTO . 'class/Categorias_Catalogo_Principal.php');
require_once(RUTA_PROYECTO . 'class/Clientes_Admin.php');

$idPagina = 178;

include(RUTA_PROYECTO . "includes/verificar-paginas.php");
include(RUTA_PROYECTO . "includes/head.php");
$busqueda = '';
$filtro = '';
if (!empty($_GET['search'])) {
    $busqueda = $_GET['search'];
    $filtro .= " AND (
    ccat_nombre LIKE '%" . $busqueda . "%' 
    OR cmarp_nombre LIKE '%" . $busqueda . "%' 
    OR cliAdmi_nombre LIKE '%" . $busqueda . "%'
    )";
}
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
                    <div class="card">
                        <div class="card-header">
                            <h2 class="m-0 float-sm-right"><?= $paginaActual['pag_nombre'] ?></h2>
                            <a href="marcas-catalogo-agregar.php" class="btn btn-primary"><i class="fas fa-solid fa-plus"></i> Agregar Sub-Categorias del Catalogo</a>
                            <?php
                            if (!empty($filtro)) {
                            ?>
                                <a href="<?= $_SERVER['PHP_SELF']; ?>" class="btn btn-warning"> Quitar Filtro</a>
                            <?php } ?>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nº</th>
                                        <th>Nombre Sub-Categorias</th>
                                        <th>Categoria</th>
                                        <th>Exclusiva</th>
                                        <th>Mas Productos</th>
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
                                        $predicado = ["cmarp_id_empresa" => $_SESSION["idEmpresa"]];
                                    }

                                    if (!empty($filtro)) {
                                        $filtro = preg_replace('/\sAND$/', '', $filtro);

                                        $predicado = !empty($predicado) ? array_merge($predicado, [SubCategorias_Catalogo_Principal::OTHER_PREDICATE => $filtro]) : [SubCategorias_Catalogo_Principal::OTHER_PREDICATE => $filtro];
                                    }

                                    Clientes_Admin::foreignKey(Clientes_Admin::INNER, [
                                        "cliAdmi_id" => 'cmarp_id_empresa'
                                    ]);
                                    Categorias_Catalogo_Principal::foreignKey(Categorias_Catalogo_Principal::LEFT, [
                                        "ccatp_id" => 'cmarp_categoria'
                                    ]);

                                    $marcas = SubCategorias_Catalogo_Principal::SelectJoin(
                                        $predicado,
                                        "*",
                                        [
                                            Clientes_Admin::class,
                                            Categorias_Catalogo_Principal::class
                                        ]
                                    );
                                    $num = 1;
                                    foreach ($marcas as $result) {
                                        $menu = "NO";
                                        if ($result['cmarp_menu'] == 1) {
                                            $menu = "SI";
                                        }
                                        $masJoyas = "NO";
                                        if ($result['cmarp_mas_joyas'] == 1) {
                                            $masJoyas = "SI";
                                        }
                                    ?>
                                        <tr>
                                            <td><?= $num; ?></td>
                                            <td><?= $result['cmarp_nombre']; ?></td>
                                            <td><?= $result['ccatp_nombre']; ?></td>
                                            <td><?= $menu; ?></td>
                                            <td><?= $masJoyas; ?></td>
                                            <?php
                                            if ($_SESSION["datosUsuarioActual"]['usr_tipo'] == DEV) {
                                            ?>
                                                <td><?= $result['cliAdmi_nombre']; ?></td>
                                            <?php } ?>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info">Acciones</button>
                                                    <button type="button" class="btn btn-info dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu" role="menu">
                                                        <a class="dropdown-item" href="marcas-catalogo-editar.php?id=<?= $result['cmarp_id']; ?>" data-toggle="tooltip">Editar</a>
                                                        <!--<div class="dropdown-divider"></div>-->
                                                        <a class="dropdown-item" href="../bd_delete/marcas-catalogo-eliminar.php?id=<?= $result['cmarp_id']; ?>" onClick="if(!confirm('Este registro se eliminará del sistema, Desea continuar bajo su responsabilidad?')){return false;}" data-toggle="tooltip">Eliminar</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php $num++;
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nº</th>
                                        <th>Nombre Sub-Categorias</th>
                                        <th>Categoria</th>
                                        <th>Exclusiva</th>
                                        <th>Mas Productos</th>
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
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    <?php include(RUTA_PROYECTO . "includes/pie.php"); ?>
</body>

</html>