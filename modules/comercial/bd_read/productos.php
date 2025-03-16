<?php
include("../../sesion.php");

$idPagina = 20;

include(RUTA_PROYECTO."includes/verificar-paginas.php");
include(RUTA_PROYECTO."includes/head.php");

$filtro="";
if(!empty($_GET["cliAdmin"])){
    $filtro.=" AND cprod_id_empresa='".$_GET["cliAdmin"]."'";
}
if(!empty($_GET["cat"])){
    $filtro.=" AND cprod_categoria='".$_GET["cat"]."'";
}
if(!empty($_GET["subCat"])){
    $filtro.=" AND cprod_marca='".$_GET["subCat"]."'";
}
if(!empty($_GET["estado"])){
    $filtro.=" AND cprod_estado='".$_GET["estado"]."'";
}
$busqueda='';
if (!empty($_GET['search'])) {
    $busqueda = $_GET['search'];
    $filtro .= " AND (
    cprod_id LIKE '%".$busqueda."%' 
    OR cprod_nombre LIKE '%".$busqueda."%' 
    OR ccat_nombre LIKE '%".$busqueda."%' 
    OR cmar_nombre LIKE '%".$busqueda."%' 
    OR cliAdmi_nombre LIKE '%".$busqueda."%' 
    )";
}
?>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- JQVMap -->
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/jqvmap/jqvmap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>dist/css/adminlte.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/daterangepicker/daterangepicker.css">
<!-- summernote -->
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/summernote/summernote-bs4.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?=REDIRECT_ROUTE?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    
    <?php include(RUTA_PROYECTO."includes/carga.php"); ?>

    <?php include(RUTA_PROYECTO."includes/encabezado.php"); ?>
    
    <?php include(RUTA_PROYECTO."includes/menu.php"); ?>
    
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                        <div class="col-sm-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?=REDIRECT_ROUTE?>modules/index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active"><?=$paginaActual['pag_nombre']?></li>
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
                        <h2 class="m-0 float-sm-right"><?=$paginaActual['pag_nombre']?></h2>
                            <a href="productos-agregar.php" class="btn btn-primary"><i class="fas fa-solid fa-plus"></i> Agregar Productos</a>
                        <?php 
                            if(!empty($filtro)){
                        ?>
                            <a href="<?=$_SERVER['PHP_SELF'];?>" class="btn btn-warning"> Quitar Filtro</a>
                        <?php }?>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>ID</th>
                                    <th></th>
                                    <th>Nombre Producto</th>
                                    <th>Precio</th>
                                    <th>Existencia</th>
                                    <th>Categoria</th>
                                    <th>Sub-Categoria</th>
                                    <th>Estado</th>
                                    <?php
                                    if($datosUsuarioActual['usr_tipo']==DEV){
                                    ?>
                                    <th>Nombre Empresa</th>
								    <?php }?>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $filtroAdmin="";
                                if($datosUsuarioActual['usr_tipo']!=DEV){
                                    $filtroAdmin.=" AND cprod_id_empresa='".$configuracion['conf_id_empresa']."'";
                                }
                                try{
                                    $productos= $conexionBdComercial->query("SELECT * FROM comercial_productos 
                                    LEFT JOIN comercial_categorias ON ccat_id=cprod_categoria 
                                    LEFT JOIN comercial_marcas ON cmar_id=cprod_marca 
                                    INNER JOIN comercial_productos_fotos ON cpf_id_producto=cprod_id AND cpf_principal=1 
                                    INNER JOIN ".BDADMIN.".clientes_admin ON cliAdmi_id=cprod_id_empresa 
                                    WHERE cprod_id=cprod_id {$filtroAdmin} {$filtro}");
                                } catch (Exception $e) {
                                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                }
                                $num=1;
                                while($result = mysqli_fetch_array($productos, MYSQLI_BOTH)){
                                    $categoria="";
                                    if(!empty($result['ccat_nombre'])){
                                        $categoria=$result['ccat_nombre'];
                                    }

                                    $subCategoria="";
                                    if(!empty($result['cmar_nombre'])){
                                        $subCategoria=$result['cmar_nombre'];
                                    }

                                    $estado="Activo";
                                    $color="green";
                                    if($result['cprod_estado']!=1){
                                        $estado="Inactivo";
                                        $color="red";
                                    }

                                    $colorExistencia="green";
                                    if($result['cprod_exitencia']<=5){
                                        $colorExistencia="red";
                                    }
                                ?>
                                <tr>
                                    <td><?=$num;?></td>
                                    <td><?=$result['cprod_id'];?></td>
                                    <td align="center">
                                        <?php if (!empty($result['cpf_fotos'])) { ?>
                                            <img src="<?= REDIRECT_ROUTE."files/productos/".$result['cpf_fotos'] ?>" width="40">
                                        <?php } ?>
                                    </td>
                                    <td><?=$result['cprod_nombre'];?></td>
                                    <td><?=number_format($result['cprod_costo'],0,",",".");?></td>
                                    <td style="color: <?=$colorExistencia;?>;"><?=$result['cprod_exitencia'];?></td>
                                    <td>
                                        <a href="<?=$_SERVER['PHP_SELF'];?>?cat=<?=$result['cprod_categoria'];?>"><?=$categoria;?></a>
                                    </td>
                                    <td>
                                        <a href="<?=$_SERVER['PHP_SELF'];?>?subCat=<?=$result['cprod_marca'];?>"><?=$subCategoria;?></a>
                                    </td>
                                    <td>
                                        <a style="color: <?=$color;?>;" href="<?=$_SERVER['PHP_SELF'];?>?estado=<?=$result['cprod_estado'];?>"><?=$estado;?></a>
                                    </td>
                                    <?php
                                    if($datosUsuarioActual['usr_tipo']==DEV){
                                    ?>
                                    <td>
                                        <a href="<?=$_SERVER['PHP_SELF'];?>?cliAdmin=<?=$result['cliAdmi_id'];?>"><?=$result['cliAdmi_nombre'];?></a>
                                    </td>
								    <?php }?>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info">Acciones</button>
                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <a class="dropdown-item" href="productos-editar.php?id=<?=$result[0];?>" data-toggle="tooltip">Editar</a>
                                                <a class="dropdown-item" href="../bd_delete/productos-eliminar.php?id=<?=$result[0];?>" onClick="if(!confirm('Este registro se eliminará del sistema, Desea continuar bajo su responsabilidad?')){return false;}" data-toggle="tooltip">Eliminar</a>
                                                <a class="dropdown-item" href="productos-fotos.php?id=<?=$result[0];?>" data-toggle="tooltip">Fotos del Producto</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
								<?php $num++;}?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nº</th>
                                    <th>ID</th>
                                    <th></th>
                                    <th>Nombre Producto</th>
                                    <th>Precio</th>
                                    <th>Existencia</th>
                                    <th>Categoria</th>
                                    <th>Sub-Categoria</th>
                                    <th>Estado</th>
                                    <?php
                                    if($datosUsuarioActual['usr_tipo']==DEV){
                                    ?>
                                    <th>Nombre Empresa</th>
								    <?php }?>
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
    <?php include(RUTA_PROYECTO."includes/footer.php"); ?>
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
  </div>
  <!-- jQuery -->
    <script src="<?=REDIRECT_ROUTE?>plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?=REDIRECT_ROUTE?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?=REDIRECT_ROUTE?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="<?=REDIRECT_ROUTE?>plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="<?=REDIRECT_ROUTE?>plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="<?=REDIRECT_ROUTE?>plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?=REDIRECT_ROUTE?>plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="<?=REDIRECT_ROUTE?>plugins/moment/moment.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?=REDIRECT_ROUTE?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="<?=REDIRECT_ROUTE?>plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?=REDIRECT_ROUTE?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?=REDIRECT_ROUTE?>dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?=REDIRECT_ROUTE?>dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?=REDIRECT_ROUTE?>dist/js/pages/dashboard.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="<?=REDIRECT_ROUTE?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/jszip/jszip.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- Page specific script -->
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
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
    <?php include(RUTA_PROYECTO."includes/pie.php"); ?>
</body>
</html>