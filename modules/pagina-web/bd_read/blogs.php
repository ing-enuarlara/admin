<?php
include("../../sesion.php");

$idPagina = 130;

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
                        <a href="blogs-agregar.php" class="btn btn-primary"><i class="fas fa-solid fa-plus"></i> Agregar</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Titulo</th>
                                    <th>Contenido</th>
                                    <th>Categoria</th>
                                    <th>Palabras Claves</th>
                                    <th>Responsable</th>
                                    <th>Fecha Creación</th>
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
                                $where="";
                                if($datosUsuarioActual['usr_tipo']!=DEV){
                                    $where= "WHERE blogs_id_empresa='".$configuracion['conf_id_empresa']."'";
                                }
                                try{
                                    $blogs= $conexionBdPaginaWeb->query("SELECT * FROM blogs $where");
                                } catch (Exception $e) {
                                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                }
                                $num=1;
                                while($result = mysqli_fetch_array($blogs, MYSQLI_BOTH)){
                                    if($datosUsuarioActual['usr_tipo']==DEV){
                                        try{
                                            $empresa= $conexionBdAdmin->query("SELECT cliAdmi_nombre FROM clientes_admin WHERE cliAdmi_id='".$result['blogs_id_empresa']."'");
                                        } catch (Exception $e) {
                                            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                        }
                                        $nomEmpresa = mysqli_fetch_array($empresa, MYSQLI_BOTH);
                                    }

                                    try{
                                        $responsable= $conexionBdAdministrativo->query("SELECT usr_nombre FROM administrativo_usuarios WHERE usr_id='".$result['blogs_responsable']."'");
                                    } catch (Exception $e) {
                                        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                    }
                                    $nomResponsable = mysqli_fetch_array($responsable, MYSQLI_BOTH);

                                    try{
                                        $categoria= $conexionBdPaginaWeb->query("SELECT catblo_nombre FROM categorias_blogs WHERE catblo_id='".$result['blogs_id_categoria']."'");
                                    } catch (Exception $e) {
                                        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                    }
                                    $nomCategoria = mysqli_fetch_array($categoria, MYSQLI_BOTH);

                                    $texto = htmlspecialchars(strip_tags($result['blogs_contenido']));
                                ?>
                                <tr>
                                    <td><?=$num;?></td>
                                    <td><?=strip_tags($result['blogs_titulo']);?></td>
                                    <td title="<?=$texto;?>"
                                        data-observacion="<?=$texto;?>"
                                        onclick="toggleFullText(this)"
                                        style="cursor: pointer;">
                                        <?=substr($texto, 0, 100)?>...
                                    </td>
                                    <td><?=$nomCategoria['catblo_nombre'];?></td>
                                    <td><?=$result['blogs_palabras_claves'];?></td>
                                    <td><?=$nomResponsable['usr_nombre'];?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($result['blogs_fecha_creacion'])); ?></td>
                                    <?php
                                    if($datosUsuarioActual['usr_tipo']==DEV){
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
                                                <a class="dropdown-item" href="blogs-editar.php?id=<?=$result[0];?>" data-toggle="tooltip">Editar</a>
                                                <a class="dropdown-item" href="comentarios-blogs.php?id=<?=$result[0];?>" data-toggle="tooltip">Comentarios</a>
                                                <!--<div class="dropdown-divider"></div>-->
                                                <a class="dropdown-item" href="../bd_delete/blogs-eliminar.php?id=<?=$result[0];?>" onClick="if(!confirm('Este registro se eliminará del sistema, Desea continuar bajo su responsabilidad?')){return false;}" data-toggle="tooltip">Eliminar</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
								<?php $num++;}?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nº</th>
                                    <th>Titulo</th>
                                    <th>Contenido</th>
                                    <th>Categoria</th>
                                    <th>Palabras Claves</th>
                                    <th>Responsable</th>
                                    <th>Fecha Creación</th>
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

        function toggleFullText(element) {
            const fullText = element.getAttribute('data-observacion'); // Obtiene el texto completo del atributo 'data-observacion'.
            const isExpanded = element.getAttribute('data-expanded') === 'true'; // Verifica si el texto ya está expandido.

            if (isExpanded) {
                element.innerHTML = fullText.substring(0, 100) + '...'; // Trunca el texto a 100 caracteres y añade '...'.
                element.setAttribute('data-expanded', 'false'); // Marca el elemento como no expandido.
            } else {
                element.innerHTML = fullText; // Muestra el texto completo.
                element.setAttribute('data-expanded', 'true'); // Marca el elemento como expandido.
            }
        }
    </script>
    <?php include(RUTA_PROYECTO."includes/pie.php"); ?>
</body>
</html>