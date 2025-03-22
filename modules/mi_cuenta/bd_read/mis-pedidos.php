<?php
include("../../sesion.php");

$idPagina = 114;

include(RUTA_PROYECTO."includes/verificar-paginas.php");
include(RUTA_PROYECTO."includes/head.php");

$filtroC=""; $filtroP=""; $filtroR=""; $filtroF="";
if(!empty($_GET["vende"])){
    $filtroC.=" AND cotiz_vendedor='".$_GET["vende"]."'";
    $filtroP.=" AND pedid_vendedor='".$_GET["vende"]."'";
    $filtroR.=" AND remi_vendedor='".$_GET["vende"]."'";
    $filtroF.=" AND factura_vendedor='".$_GET["vende"]."'";
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
                <?php
                    if(!empty($_GET["cte"])){
                ?>
                <a href="<?=$_SERVER['PHP_SELF'];?>" style="margin-bottom: 5px;" class="btn btn-warning"> Quitar Filtro</a>
                <?php }?>
                <div class="row">
                    <!-- column -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="m-0 float-sm-right">Cotizaciones</h2>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nº Cotización</th>
                                            <th>Fecha Propuesta</th>
                                            <th>Vendedor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        try{
                                            $consulta= $conexionBdComercial->query("SELECT * FROM comercial_cotizaciones
                                            INNER JOIN ".BDMODADMINISTRATIVO.".administrativo_usuarios ON usr_id=cotiz_vendedor 
                                            WHERE cotiz_cliente='".$_SESSION["datosUsuarioActual"]['usr_id_cliente']."' $filtroC ORDER BY cotiz_id DESC");
                                        } catch (Exception $e) {
                                            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                        }
                                        while($result = mysqli_fetch_array($consulta, MYSQLI_BOTH)){
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="<?=REDIRECT_ROUTE?>modules/reportes/formato-cotizacion-1.php?id=<?=$result['cotiz_id'];?>" target="_blank">
                                                    <?= date("dmy", strtotime($result['cotiz_fecha_propuesta']))."-".$result['cotiz_id']; ?>
                                                </a>
                                            </td>
                                            <td><?=$result['cotiz_fecha_propuesta'];?></td>
                                            <td><?=$result['usr_nombre'];?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Nº Cotización</th>
                                            <th>Fecha Propuesta</th>
                                            <th>Vendedor</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <h2 class="m-0 float-sm-right">Remisiones</h2>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nº Remisión</th>
                                            <th>Fecha Propuesta</th>
                                            <th>Vendedor</th>
                                            <th>Nº Pedido</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $filtro="";
                                        try{
                                            $consulta= $conexionBdComercial->query("SELECT * FROM comercial_remisiones
                                            INNER JOIN ".BDMODADMINISTRATIVO.".administrativo_usuarios ON usr_id=remi_vendedor 
                                            WHERE remi_cliente='".$_SESSION["datosUsuarioActual"]['usr_id_cliente']."' $filtroR ORDER BY remi_id DESC");
                                        } catch (Exception $e) {
                                            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                        }
                                        while($result = mysqli_fetch_array($consulta, MYSQLI_BOTH)){
                                            $pedido='';
                                            if(!empty($result['remi_pedido'])){
                                                $pedido=date("dmy", strtotime($result['remi_fecha_pedido']))."-".$result['remi_pedido'];
                                            }
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="<?=REDIRECT_ROUTE?>modules/reportes/formato-remision-1.php?id=<?=$result['remi_id'];?>" target="_blank">
                                                    <?= date("dmy", strtotime($result['remi_fecha_propuesta']))."-".$result['remi_id']; ?>
                                                </a>
                                            </td>
                                            <td><?=$result['remi_fecha_propuesta'];?></td>
                                            <td><?=$result['usr_nombre'];?></td>
                                            <td><?= $pedido; ?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Nº Remisión</th>
                                            <th>Fecha Propuesta</th>
                                            <th>Vendedor</th>
                                            <th>Nº Pedido</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- column -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="m-0 float-sm-right">Pedidos</h2>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nº Pedido</th>
                                            <th>Fecha Propuesta</th>
                                            <th>Vendedor</th>
                                            <th>Estado</th>
                                            <th>Nº Cotización</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        try{
                                            $consulta= $conexionBdComercial->query("SELECT * FROM comercial_pedidos
                                            INNER JOIN ".BDMODADMINISTRATIVO.".administrativo_usuarios ON usr_id=pedid_vendedor 
                                            WHERE pedid_cliente='".$_SESSION["datosUsuarioActual"]['usr_id_cliente']."' $filtroP ORDER BY pedid_id DESC");
                                        } catch (Exception $e) {
                                            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                        }
                                        while($result = mysqli_fetch_array($consulta, MYSQLI_BOTH)){
                                            $cotiz='';
                                            if(!empty($result['pedid_cotizacion'])){
                                                $cotiz=date("dmy", strtotime($result['pedid_fecha_cotizacion']))."-".$result['pedid_cotizacion'];
                                            }
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="<?=REDIRECT_ROUTE?>modules/reportes/formato-pedido-1.php?id=<?=$result['pedid_id'];?>" target="_blank">
                                                    <?= date("dmy", strtotime($result['pedid_fecha_propuesta']))."-".$result['pedid_id']; ?>
                                                </a>
                                            </td>
                                            <td><?=$result['pedid_fecha_propuesta'];?></td>
                                            <td><?=$result['usr_nombre'];?></td>
                                            <td style="background-color: <?=$colorEstadoPedidos[$result['pedid_estado']];?>; color: white; font-size: 16px; font-weight: bold;"><?=$estadoPedidos[$result['pedid_estado']];?></td>
                                            <td><?= $cotiz; ?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Nº Pedido</th>
                                            <th>Fecha Propuesta</th>
                                            <th>Vendedor</th>
                                            <th>Estado</th>
                                            <th>Nº Cotización</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <h2 class="m-0 float-sm-right"><?=$paginaActual['pag_nombre']?></h2>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nº Factura</th>
                                            <th>Fecha Propuesta</th>
                                            <th>Vendedor</th>
                                            <th>Nº Remisión</th>
                                            <th>Total F. Ventas</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        try{
                                            $consulta= $conexionBdComercial->query("SELECT * FROM comercial_facturas
                                            INNER JOIN ".BDMODADMINISTRATIVO.".administrativo_usuarios ON usr_id=factura_vendedor 
                                            WHERE factura_cliente='".$_SESSION["datosUsuarioActual"]['usr_id_cliente']."' AND factura_tipo=1 $filtroF ORDER BY factura_id DESC");
                                        } catch (Exception $e) {
                                            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                        }
                                        
                                        $sumaFacturasVentas = 0;
                                        while($result = mysqli_fetch_array($consulta, MYSQLI_BOTH)){

                                            try{
                                                $consultaTotal = mysqli_query($conexionBdComercial, "SELECT * FROM comercial_relacion_productos WHERE czpp_cotizacion='" . $result['factura_id'] . "' AND czpp_tipo=4 AND czpp_valor>0 AND czpp_cantidad>0 GROUP BY czpp_id ");
                                            } catch (Exception $e) {
                                                include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                            }

                                            $total = 0;
                                            $sumaTotal = 0;
                                            $VlrDcto = 0;
                                            $totalConDcto = 0;
                                            $VlrIva = 0;
                                            $totalFinal = 0;
                                            $sumaTotalventas = 0;

                                            while($datos = mysqli_fetch_array($consultaTotal, MYSQLI_BOTH)){

                                                $total = ($datos['czpp_valor'] * $datos['czpp_cantidad']);
                                                $sumaTotal += $total;

                                                $nDescuento=0;
                                                if(!empty($datos['czpp_descuento'])){ $nDescuento=$datos['czpp_descuento'];}
                                                $VlrDcto = ($total * ($nDescuento/100));

                                                $totalConDcto = ($total - $VlrDcto);

                                                $nImpuesto=0;
                                                if(!empty($datos['czpp_impuesto'])){ $nImpuesto=$datos['czpp_impuesto'];}
                                                $VlrIva = ($totalConDcto * ($nImpuesto/100));

                                                $totalFinal = $totalConDcto + $VlrIva;

                                                $sumaTotalventas += $totalFinal;

                                            }

                                            //Para el total al pie de pagina
                                            $sumaFacturasVentas += $sumaTotalventas;

                                            $remision='';
                                            if(!empty($result['factura_remision'])){
                                                $remision=date("dmy", strtotime($result['factura_fecha_remision']))."-".$result['factura_remision'];
                                            }
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="<?=REDIRECT_ROUTE?>modules/reportes/formato-factura-1.php?id=<?=$result['factura_id'];?>" target="_blank">
                                                    <?= date("dmy", strtotime($result['factura_fecha_propuesta']))."-".$result['factura_id']; ?>
                                                </a>
                                            </td>
                                            <td><?=$result['factura_fecha_propuesta'];?></td>
                                            <td><?=$result['usr_nombre'];?></td>
                                            <td><?=$remision;?></td>
                                            <td align="center"><?= $simbolosMonedas[$result['factura_moneda']].number_format($sumaTotalventas, 0, ".", "."); ?></td>
                                            <td style="background-color: <?=$colorEstadoFactura[$result['factura_estado']];?>; color: white; font-size: 16px; font-weight: bold;"><?=$estadoFactura[$result['factura_estado']];?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" style="text-align: right;">Total</th>
                                            <th style="text-align: center;">$<?= number_format($sumaFacturasVentas, 0, ".", ".");?></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
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