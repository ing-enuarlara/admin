<?php
include("../../sesion.php");

$idPagina = 75;

include(RUTA_PROYECTO."includes/verificar-paginas.php");
include(RUTA_PROYECTO."includes/head.php");

$filtro="";
if($datosUsuarioActual['usr_tipo']!=1 || !empty($_GET["cliAdmin"])){
    $filtro.=" AND (cotiz_id_empresa='".$configuracion['conf_id_empresa']."' OR cotiz_id_empresa='".$_GET["cliAdmin"]."')";
}
if(!empty($_GET["cte"])){
    $filtro.=" AND cotiz_cliente='".$_GET["cte"]."'";
}
if(!empty($_GET["respo"])){
    $filtro.=" AND cotiz_creador='".$_GET["respo"]."'";
}
if(!empty($_GET["vende"])){
    $filtro.=" AND cotiz_vendedor='".$_GET["vende"]."'";
}
$filtroID="cotiz_id=cotiz_id";
if(!empty($_GET["q"])){
    $filtroID="cotiz_id='".$_GET["q"]."'";
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
					    <a href="cotizaciones-agregar.php" class="btn btn-primary"><i class="fas fa-solid fa-plus"></i> Agregar Cotización</a>
                        <?php
                            if(!empty($filtro) || $filtroID!="cotiz_id=cotiz_id"){
                        ?>
					    <a href="<?=$_SERVER['PHP_SELF'];?>" class="btn btn-warning"> Quitar Filtro</a>
                        <?php }?>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nº Cotización</th>
                                    <th>Fecha Propuesta</th>
                                    <th>Cliente</th>
                                    <th>Descripción</th>
                                    <th>Responsable</th>
                                    <th>Vendedor</th>
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
                                try{
                                    $consulta= $conexionBdComercial->query("SELECT * FROM comercial_cotizaciones
                                    INNER JOIN comercial_clientes ON cli_id=cotiz_cliente 
                                    INNER JOIN ".BDMODADMINISTRATIVO.".administrativo_usuarios ON usr_id=cotiz_creador 
                                    INNER JOIN ".BDADMIN.".clientes_admin ON cliAdmi_id=cotiz_id_empresa 
                                    WHERE $filtroID $filtro ORDER BY cotiz_id DESC");
                                } catch (Exception $e) {
                                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                }
                                while($result = mysqli_fetch_array($consulta, MYSQLI_BOTH)){
                                    try{
                                        $consultaVendedor=$conexionBdAdministrativo->query("SELECT usr_id, usr_nombre FROM administrativo_usuarios WHERE usr_id='" . $result['cotiz_vendedor'] . "'");
                                    } catch (Exception $e) {
                                        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                    }
                                    $vendedor = mysqli_fetch_array($consultaVendedor, MYSQLI_BOTH);

                                    $fondoCotiz = '';
                                    if ($result['cotiz_vendida'] == 1) {
                                        $fondoCotiz = 'aquamarine';
                                    }

                                    try{
                                        $consultaGpedido=$conexionBdComercial->query("SELECT pedid_id, pedid_fecha_creacion FROM comercial_pedidos WHERE pedid_cotizacion='" . $result['cotiz_id'] . "'");
                                    } catch (Exception $e) {
                                        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                    }
                                    $generoPedido = mysqli_fetch_array($consultaGpedido, MYSQLI_BOTH);

                                    $IdGeneroPedido = '';
                                    $infoPedido = '';
                                    if(isset($generoPedido['pedid_id'])){
                                        if($generoPedido['pedid_id']!=""){
                                            $infoPedido = 'Esta cotización ya generó el pedido con ID: '.$generoPedido['pedid_id'].". En la fecha: ".$generoPedido['pedid_fecha_creacion'];
                                            $IdGeneroPedido = $generoPedido['pedid_id'];
                                        }
                                    }
                                ?>
                                <tr>
                                    <td style="background-color: <?= $fondoCotiz; ?>;" title="<?=$infoPedido;?>"><?=$result['cotiz_id'];?></td>
                                    <td><?= date("dmy", strtotime($result['cotiz_fecha_propuesta']))."-".$result['cotiz_id']; ?></td>
                                    <td><?=$result['cotiz_fecha_propuesta'];?></td>
                                    <td>
                                        <a href="<?=$_SERVER['PHP_SELF'];?>?cte=<?=$result['cli_id'];?>"><?=$result['cli_nombre'];?></a>
                                    </td>
                                    <td>
                                        <?php
                                            try{
                                                $productos = $conexionBdComercial->query("SELECT cprod_nombre FROM comercial_relacion_productos
                                            INNER JOIN comercial_productos ON cprod_id=czpp_producto WHERE czpp_cotizacion='" . $result['cotiz_id'] . "' AND czpp_tipo=1");
                                            } catch (Exception $e) {
                                                include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                            }
                                            $i = 1;
                                            while ($prod = mysqli_fetch_array($productos, MYSQLI_BOTH)) {
                                                if($i==1){echo "<b>Productos:</b><br>";}
                                                echo "<b>" . $i . ".</b> " . $prod['cprod_nombre'] . ", ";
                                                $i++;
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="<?=$_SERVER['PHP_SELF'];?>?respo=<?=$result['usr_id'];?>"><?=$result['usr_nombre'];?></a>
                                    </td>
                                    <td>
                                        <a href="<?=$_SERVER['PHP_SELF'];?>?vende=<?=$vendedor['usr_id'];?>"><?=$vendedor['usr_nombre'];?></a>
                                    </td>
                                    <?php
                                    if($datosUsuarioActual['usr_tipo']==1){
                                    ?>
                                    <td>
                                        <a href="<?=$_SERVER['PHP_SELF'];?>?cliAdmin=<?=$result['cliAdmi_id'];?>">
                                            <?=$result['cliAdmi_nombre'];?>
                                        </a>
                                    </td>
								    <?php }?>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info">Acciones</button>
                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <a class="dropdown-item" href="cotizaciones-editar.php?id=<?=$result[0];?>#productos">Editar</a>
                                                <a class="dropdown-item" href="../bd_delete/cotizaciones-eliminar.php?id=<?=$result[0];?>" onClick="if(!confirm('Este registro se eliminará del sistema, Desea continuar bajo su responsabilidad?')){return false;}">Eliminar</a>
                                                <a class="dropdown-item" href="../../reportes/formato-cotizacion-1.php?id=<?= $result[0]; ?>" target="_blank">Imprimir</a>
                                                <a class="dropdown-item" href="../bd_create/cotizaciones-replicar.php?id=<?=$result[0];?>">Replicar</a>
                                                <?php if($IdGeneroPedido == ''){?>
                                                <a class="dropdown-item" href="../bd_create/cotizaciones-generar-pedido.php?id=<?=$result[0];?>" onClick="if(!confirm('Desea generar pedido de esta cotización?')){return false;}">Generar pedido</a>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
								<?php }?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Nº Cotización</th>
                                    <th>Fecha Propuesta</th>
                                    <th>Cliente</th>
                                    <th>Descripción</th>
                                    <th>Responsable</th>
                                    <th>Vendedor</th>
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
    <!-- InputMask -->
    <script src="<?=REDIRECT_ROUTE?>plugins/moment/moment.min.js"></script>
    <script src="<?=REDIRECT_ROUTE?>plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="<?=REDIRECT_ROUTE?>plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
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

            $("input[data-bootstrap-switch]").each(function(){
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })
        });
    </script>
    <?php include(RUTA_PROYECTO."includes/pie.php"); ?>
</body>
</html>