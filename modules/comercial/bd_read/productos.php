<?php
include("../../sesion.php");

$idPagina = 20;

include(RUTA_PROYECTO."includes/verificar-paginas.php");
include(RUTA_PROYECTO."includes/head.php");
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
                        <?php if($datosUsuarioActual['usr_tipo']!=5){ ?>
		    			    <a href="productos-agregar.php" class="btn btn-primary"><i class="fas fa-solid fa-plus"></i> Agregar Productos</a>
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
                                    if($datosUsuarioActual['usr_tipo']==1){
                                    ?>
                                    <th>Nombre Empresa</th>
								    <?php }?>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $where="";
                                if($datosUsuarioActual['usr_tipo']!=1){
                                    $where="WHERE cprod_id_empresa='".$configuracion['conf_id_empresa']."'";
                                }
                                $productos= $conexionBdComercial->query("SELECT * FROM comercial_productos 
                                INNER JOIN comercial_productos_fotos ON cpf_id_producto=cprod_id AND cpf_principal=1 $where");
                                $num=1;
                                while($result = mysqli_fetch_array($productos, MYSQLI_BOTH)){
                                    if($datosUsuarioActual['usr_tipo']==1){
                                        $empresa= $conexionBdAdmin->query("SELECT * FROM clientes_admin WHERE cliAdmi_id='".$result['cprod_id_empresa']."'");
                                        $nomEmpresa = mysqli_fetch_array($empresa, MYSQLI_BOTH);
                                    }

                                    $categoria="";
                                    if($result['cprod_categoria']!=0){
                                        $consultaCategorias = $conexionBdComercial->query("SELECT * FROM comercial_categorias WHERE ccat_id='".$result['cprod_categoria']."'");
                                        $datosCategorias = mysqli_fetch_array($consultaCategorias, MYSQLI_BOTH);
                                        $categoria=$datosCategorias['ccat_nombre'];
                                    }

                                    $subCategoria="";
                                    if($result['cprod_marca']!=0){
                                        $consultaSubCategorias = $conexionBdComercial->query("SELECT * FROM comercial_marcas WHERE cmar_id='".$result['cprod_marca']."'");
                                        $datosSubCategorias = mysqli_fetch_array($consultaSubCategorias, MYSQLI_BOTH);
                                        $subCategoria=$datosSubCategorias['cmar_nombre'];
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
                                    <td><?=$categoria;?></td>
                                    <td><?=$subCategoria;?></td>
                                    <td style="color: <?=$color;?>;"><?=$estado;?></td>
                                    <?php
                                    if($datosUsuarioActual['usr_tipo']==1){
                                    ?>
                                    <td><?=$nomEmpresa['cliAdmi_nombre'];?></td>
								    <?php }?>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info">Acciones</button>
                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <?php if($datosUsuarioActual['usr_tipo']!=5){ ?>
                                                    <a class="dropdown-item" href="productos-editar.php?id=<?=$result[0];?>" data-toggle="tooltip">Editar</a>
                                                    <a class="dropdown-item" href="../bd_delete/productos-eliminar.php?id=<?=$result[0];?>" onClick="if(!confirm('Este registro se eliminará del sistema, Desea continuar bajo su responsabilidad?')){return false;}" data-toggle="tooltip">Eliminar</a>
                                                <?php }?>
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
                                    if($datosUsuarioActual['usr_tipo']==1){
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