<?php
include("../../sesion.php");

$idPagina = 103;

include(RUTA_PROYECTO."includes/verificar-paginas.php");
include(RUTA_PROYECTO."includes/head.php");
$filtro="";
if($datosUsuarioActual['usr_tipo']!=1){
    $filtro.=" AND factura_id_empresa='".$configuracion['conf_id_empresa']."'";
}
if(!empty($_GET["tipo"])){
    $filtro.=" AND factura_tipo='".$_GET["tipo"]."'";
}
if(!empty($_GET["cte"])){
    $filtro.=" AND ((factura_cliente='".$_GET["cte"]."' AND factura_tipo=1) OR (factura_proveedor='".$_GET["cte"]."' AND factura_tipo=2))";
}
if(!empty($_GET["respo"])){
    $filtro.=" AND factura_creador='".$_GET["respo"]."'";
}
if(!empty($_GET["vende"])){
    $filtro.=" AND factura_vendedor='".$_GET["vende"]."'";
}
if(!empty($_GET["moneda"])){
    $filtro.=" AND factura_moneda='".$_GET["moneda"]."'";
}
if(isset($_GET["estado"])){
    $filtro.=" AND factura_estado='".$_GET["estado"]."'";
}
$filtroID="factura_id=factura_id";
if(!empty($_GET["q"])){
    $filtroID="factura_id='".$_GET["q"]."'";
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
					    <a href="facturacion-venta-agregar.php" class="btn btn-primary"><i class="fas fa-solid fa-plus"></i> Agregar Factura de Venta</a>
                        <?php
                            if(!empty($filtro) || $filtroID!="factura_id=factura_id"){
                        ?>
					    <a href="facturacion.php" class="btn btn-warning"> Quitar Filtro</a>
                        <?php }?>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nº Factura</th>
                                    <th>Tipo</th>
                                    <th>Concepto</th>
                                    <th>Fecha Propuesta</th>
                                    <th>Cliente/Proveedor</th>
                                    <th>Responsable</th>
                                    <th>Vendedor</th>
                                    <th>Nº Remisión</th>
                                    <th>Moneda</th>
                                    <th>Total F. Ventas</th>
                                    <th>Estado</th>
                                    <?php
                                    $colspan=2;
                                    if($datosUsuarioActual['usr_tipo']==1){
                                        $colspan=3;
                                    ?>
                                    <th>Nombre Empresa</th>
								    <?php }?>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $consulta= $conexionBdComercial->query("SELECT * FROM comercial_facturas
                                LEFT JOIN comercial_clientes ON cli_id=factura_cliente
                                LEFT JOIN comercial_proveedores ON prov_id=factura_proveedor
                                INNER JOIN ".BDMODADMINISTRATIVO.".administrativo_usuarios ON usr_id=factura_creador 
                                INNER JOIN ".BDADMIN.".clientes_admin ON cliAdmi_id=factura_id_empresa 
                                WHERE $filtroID $filtro ORDER BY factura_id DESC");
                                
                                $sumaFacturasVentas = 0;
                                $sumaFacturasCompras = 0;
                                $sumaFacturasVendedor = 0;
                                $sumaFacturasCliente = 0;
                                while($result = mysqli_fetch_array($consulta, MYSQLI_BOTH)){
                                    $consultaVendedor=$conexionBdAdministrativo->query("SELECT usr_id, usr_nombre FROM administrativo_usuarios WHERE usr_id='" . $result['factura_vendedor'] . "'");
                                    $vendedor = mysqli_fetch_array($consultaVendedor, MYSQLI_BOTH);

											
                                    $consultaTotal = mysqli_query($conexionBdComercial, "SELECT * FROM comercial_relacion_productos WHERE czpp_cotizacion='" . $result['factura_id'] . "' AND czpp_tipo=4 AND czpp_valor>0 AND czpp_cantidad>0 GROUP BY czpp_id ");

                                    $total = 0;
                                    $sumaTotal = 0;
                                    $VlrDcto = 0;
                                    $totalConDcto = 0;
                                    $VlrIva = 0;
                                    $totalFinal = 0;
                                    $sumaTotalventas = 0;
                                    $sumaTotalCompras = 0;

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

                                        //Para el total al pie de pagina
                                        if($result['factura_tipo'] == 1){
                                            $sumaTotalventas += $totalFinal;
                                        }
    
                                        //Para el total al pie de pagina
                                        if($result['factura_tipo'] == 2){
                                            $sumaTotalCompras += $totalFinal;
                                        }


                                    }
                                    $sumaTotalFinal=0;
                                    if($result['factura_tipo'] == 1){
                                        $sumaTotalFinal += $sumaTotalventas;
                                    }elseif($result['factura_tipo'] == 2){
                                        $sumaTotalFinal += $sumaTotalCompras;
                                    }
                                    
                                    $pCom = $configuracion['conf_comision_vendedores'] / 100;
                                    $comision = ($sumaTotalFinal * $pCom);
                                    $pCliente = $configuracion['conf_porcentaje_clientes'] / 100;
                                    $aCliente = ($sumaTotalFinal * $pCliente);

                                    //Para el total al pie de pagina
                                    $sumaFacturasVentas += $sumaTotalventas;
                                    $sumaFacturasCompras += $sumaTotalCompras;
                                    $sumaFacturasVendedor += $comision;
                                    $sumaFacturasCliente += $aCliente;

                                    //Color redimido clientes
                                    $colorRedimido = 'tomato';
                                    if($result['factura_redimido_cliente']==1){
                                            $colorRedimido = 'aquamarine';
                                    }

                                    //Color redimido vendedores
                                    $colorRedimidoV = 'tomato';
                                    if($result['factura_redimido_vendedor']==1){
                                            $colorRedimidoV = 'aquamarine';
                                    }

                                    $nombreClienteProveedor="";
                                    $idClienteProveedor="";
                                    if(!empty($result['cli_nombre'])){
                                        $idClienteProveedor=$result['cli_id'];
                                        $nombreClienteProveedor=strtoupper($result['cli_nombre']);
                                    }elseif(!empty($result['prov_nombre'])){
                                        $idClienteProveedor=$result['prov_id'];
                                        $nombreClienteProveedor=strtoupper($result['prov_nombre']);
                                    }

                                    $remision='';
                                    if(!empty($result['factura_remision'])){
                                        $remision=date("dmy", strtotime($result['factura_fecha_remision']))."-".$result['factura_remision'];
                                    }
                                ?>
                                <tr>
                                    <td style="background-color: <?= $fondoCotiz; ?>;" title="<?=$infoPedido;?>"><?=$result['factura_id'];?></td>
                                    <td><?= date("dmy", strtotime($result['factura_fecha_propuesta']))."-".$result['factura_id']; ?></td>
                                    <td>
                                        <a href="facturacion.php?tipo=<?=$result['factura_tipo'];?>" target="_blank"><?= $tipoFactura[$result['factura_tipo']]; ?></a>
                                    </td>
                                    <td><?= $result['factura_concepto']; ?></td>
                                    <td><?=$result['factura_fecha_propuesta'];?></td>
                                    <td>
                                        <a href="facturacion.php?cte=<?=$idClienteProveedor;?>" target="_blank"><?=$nombreClienteProveedor;?></a>
                                    </td>
                                    <td>
                                        <a href="facturacion.php?respo=<?=$result['usr_id'];?>" target="_blank"><?=$result['usr_nombre'];?></a>
                                    </td>
                                    <td>
                                        <a href="facturacion.php?vende=<?=$vendedor['usr_id'];?>" target="_blank"><?=$vendedor['usr_nombre'];?></a>
                                    </td>
                                    <td><?=$remision;?></td>
                                    <td>
                                        <a href="facturacion.php?moneda=<?=$result['factura_moneda'];?>">
                                            <?=$monedas[$result['factura_moneda']];?>
                                        </a>
                                    </td>
                                    <td align="center"><?= $simbolosMonedas[$result['factura_moneda']].number_format($sumaTotalventas, 0, ".", "."); ?></td>
                                    <td style="background-color: <?=$colorEstadoFactura[$result['factura_estado']];?>;">
                                        <a href="facturacion.php?estado=<?=$result['factura_estado'];?>"style="text-decoration: underline; color: white; font-size: 16px; font-weight: bold;">
                                            <?=$estadoFactura[$result['factura_estado']];?>
                                        </a>
                                    </td>
                                    <?php
                                    if($datosUsuarioActual['usr_tipo']==1){
                                    ?>
                                    <td><?=$result['cliAdmi_nombre'];?></td>
								    <?php }?>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info">Acciones</button>
                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <?php
                                                    if($result['factura_tipo'] == 1){
                                                ?>
                                                <a class="dropdown-item" href="facturacion-venta-editar.php?id=<?=$result[0];?>#productos">Editar</a>
                                                <a class="dropdown-item" href="../../reportes/formato-factura-1.php?id=<?= $result[0]; ?>" target="_blank">Imprimir</a>
                                                <?php
                                                    }else{
                                                ?>
                                                <a class="dropdown-item" href="facturacion-compra-editar.php?id=<?=$result[0];?>">Editar</a>
                                                <a class="dropdown-item" href="../../reportes/formato-factura-2.php?id=<?= $result[0]; ?>" target="_blank">Imprimir</a>
                                                <?php
                                                    }
                                                    if($result['factura_estado'] != 1){
                                                ?>
                                                <a class="dropdown-item" href="../bd_update/facturacion-generar-pago.php?id=<?=$result[0];?>">Generar Pago</a>
                                                <?php
                                                    }
                                                ?>
                                                <a class="dropdown-item" href="../bd_delete/facturacion-eliminar.php?id=<?=$result[0];?>" onClick="if(!confirm('Este registro se eliminará del sistema, Desea continuar bajo su responsabilidad?')){return false;}">Eliminar</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
								<?php }?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="10" style="text-align: right;">Total</th>
                                    <th style="text-align: center;">$<?= number_format($sumaFacturasVentas, 0, ".", ".");?></th>
                                    <!-- <th style="text-align: center;">$<?= number_format($sumaFacturasCompras, 0, ".", ".");?></th> -->
                                    <th colspan="<?=$colspan;?>"></th>
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