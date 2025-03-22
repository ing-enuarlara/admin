<?php
include("../../sesion.php");

$idPagina = 69;

include(RUTA_PROYECTO."includes/verificar-paginas.php");
include(RUTA_PROYECTO."includes/head.php");
$busqueda='';
$filtro='';
if (!empty($_GET['search'])) {
    $busqueda = $_GET['search'];
    $filtro .= " AND (
    cli_id LIKE '%".$busqueda."%' 
    OR cli_nombre LIKE '%".$busqueda."%' 
    OR cli_email LIKE '%".$busqueda."%' 
    OR cli_documento LIKE '%".$busqueda."%' 
    OR cli_pais LIKE '%".$busqueda."%' 
    OR cli_telefono LIKE '%".$busqueda."%' 
    OR clicat_nombre LIKE '%".$busqueda."%' 
    OR ciu_nombre LIKE '%".$busqueda."%' 
    OR dep_nombre LIKE '%".$busqueda."%' 
    OR cli_ciudad_extranjera LIKE '%".$busqueda."%' 
    OR cliAdmi_nombre LIKE '%".$busqueda."%' 
    )";
}
$tiposDocumento = [
    '108'=>'RC', '105'=>'CC', '109'=>'CE', '107'=>'TI', '110'=>'PP', '139'=>'PE', '106'=>'NUIP'
];
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

<script type="text/javascript">
function guardarAjax(datos){ 
  var idR = datos.id;
  var valor = 0;

	if(document.getElementById(idR).checked){
		valor = 1;
		document.getElementById("Reg"+idR).style.backgroundColor="#ff572238";
	}else{
		valor = 0;
		document.getElementById("Reg"+idR).style.backgroundColor="white";
	}
  var operacion = 2;	

$('#respuestaGuardar').empty().hide().html("").show(1);
	datos = "idR="+(idR)+
			"&valor="+(valor)+
			"&operacion="+(operacion);
		   $.ajax({
			   type: "POST",
			   url: "../../../ajax/ajax-guardar-bloqueado.php",
			   data: datos,
			   success: function(data){
			   	$('#respuestaGuardar').empty().hide().html(data).show(1);
		   	   }
		  });
}
</script>
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
                <span id="respuestaGuardar"></span>	
                <div class="card">
                    <div class="card-header">
                        <h2 class="m-0 float-sm-right"><?=$paginaActual['pag_nombre']?></h2>
					    <a href="clientes-agregar.php" class="btn btn-primary"><i class="fas fa-solid fa-plus"></i> Agregar Clientes</a>
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
                                    <th>Bloq.</th>
                                    <th>Pais</th>
                                    <th>Ciudad</th>
                                    <th>Documento</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Telefono</th>
                                    <th>T. Cliente</th>
                                    <th>CT</th>
                                    <th>PD</th>
                                    <th>RM</th>
                                    <th>FC</th>
                                    <?php
                                    if($_SESSION["datosUsuarioActual"]['usr_tipo']==DEV){
                                    ?>
                                    <th>Nombre Empresa</th>
								    <?php }?>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($_SESSION["datosUsuarioActual"]['usr_tipo']!=DEV){
                                    $filtro.=" AND cli_id_empresa='".$_SESSION["idEmpresa"]."' ";
                                }
                                try{
                                    $clientes= $conexionBdComercial->query("SELECT * FROM comercial_clientes 
                                    INNER JOIN comercial_categoria_clientes ON clicat_id=cli_categoria
                                    INNER JOIN ".BDADMIN.".localidad_ciudades ON ciu_id=cli_ciudad
                                    INNER JOIN ".BDADMIN.".localidad_departamentos ON dep_id=ciu_departamento
                                    INNER JOIN ".BDADMIN.".clientes_admin ON cliAdmi_id=cli_id_empresa 
                                    INNER JOIN ".BDGENERAL.".opciones_generales ON ogen_id=cli_tipo_doc 
                                    WHERE cli_id=cli_id $filtro");
                                } catch (Exception $e) {
                                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                }
                                $num=1;
                                while($result = mysqli_fetch_array($clientes, MYSQLI_BOTH)){
                                    $bgColor = ''; $cheked = '';
                                    if($result['cli_bloqueado']==1) {$bgColor = '#ff572238'; $cheked = 'checked';}
                                    $ciudad = $result['ciu_nombre']."/".$result['dep_nombre'];
                                    if($result['cli_ciudad']==1122) {$ciudad = $result['cli_ciudad_extranjera'];}
								
                                    try{
                                        $consultaNumeros = $conexionBdComercial->query("SELECT
                                        (SELECT count(cotiz_id) FROM comercial_cotizaciones WHERE cotiz_cliente='".$result['cli_id']."'),
                                        (SELECT count(pedid_id) FROM comercial_pedidos WHERE pedid_cliente='".$result['cli_id']."'),
                                        (SELECT count(remi_id) FROM comercial_remisiones WHERE remi_cliente='".$result['cli_id']."'),
                                        (SELECT count(factura_id) FROM comercial_facturas WHERE factura_cliente='".$result['cli_id']."')");
                                    } catch (Exception $e) {
                                        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                    }
                                    $numeros = mysqli_fetch_array($consultaNumeros, MYSQLI_BOTH);
                                    
                                    $color1='#FFF';	$color2='#FFF';	$color3='#FFF';	$color4='#FFF';
                                    if($numeros[0]==0){$color1='#FFF090';}
                                    if($numeros[1]==0){$color2='#FFF090';}
                                    if($numeros[2]==0){$color3='#FFF090';}
                                    if($numeros[3]==0){$color4='#FFF090';}
                                ?>
                                <tr id="Reg<?=$result['cli_id'];?>" style="background-color:<?=$bgColor;?>;">
                                    <td><?=$num;?></td>
                                    <td>
                                        <input type="checkbox" id="<?=$result['cli_id'];?>" name="bloqueado" value="1" onChange="guardarAjax(this)" <?=$cheked;?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                    </td>
                                    <td><?=$result['cli_pais'];?></td>
                                    <td><?=$ciudad;?></td>
                                    <td><?="Tipo: ".$tiposDocumento[$result['ogen_id']]."<br> Nº: ".$result['cli_documento'];?></td>
                                    <td><?=$result['cli_nombre'];?></td>
                                    <td><?=$result['cli_email'];?></td>
                                    <td><?=$result['cli_telefono'];?></td>
                                    <td><?=$result['clicat_nombre'];?></td>
                                    <td align="center" style="background-color:<?=$color1;?>;">
                                        <a href="cotizaciones.php?cte=<?=$result['cli_id'];?>" target="_blank"><?=$numeros[0];?></a>
                                    </td>
                                    <td align="center" style="background-color:<?=$color2;?>;">
                                        <a href="pedidos.php?cte=<?=$result['cli_id'];?>" target="_blank"><?=$numeros[1];?></a>
                                    </td>
                                    <td align="center" style="background-color:<?=$color3;?>;">
                                        <a href="remisiones.php?cte=<?=$result['cli_id'];?>" target="_blank"><?=$numeros[2];?></a>
                                    </td>
                                    <td align="center" style="background-color:<?=$color4;?>;">
                                        <a href="facturacion.php?cte=<?=$result['cli_id'];?>" target="_blank"><?=$numeros[3];?></a>
                                    </td>
                                    <?php
                                    if($_SESSION["datosUsuarioActual"]['usr_tipo']==DEV){
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
                                                <a class="dropdown-item" href="clientes-editar.php?id=<?=$result[0];?>">Editar</a>
                                                <?php if($_SESSION["datosUsuarioActual"]['usr_tipo']==DEV || $_SESSION["datosUsuarioActual"]['usr_tipo']==ADMIN){?>
                                                    <a class="dropdown-item" href="<?=REDIRECT_ROUTE?>includes/auto-login.php?user=<?=$result['cli_id_usuario'];?>&tipe=5">Autologin</a>
                                                <?php }?>
                                                <!--<div class="dropdown-divider"></div>-->
                                                <a class="dropdown-item" href="../bd_delete/clientes-eliminar.php?id=<?=$result[0];?>" onClick="if(!confirm('Este registro se eliminará del sistema, Desea continuar bajo su responsabilidad?')){return false;}">Eliminar</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
								<?php $num++;}?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nº</th>
                                    <th>Bloq.</th>
                                    <th>Pais</th>
                                    <th>Ciudad</th>
                                    <th>Documento</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Telefono</th>
                                    <th>T. Cliente</th>
                                    <th>CT</th>
                                    <th>PD</th>
                                    <th>RM</th>
                                    <th>FC</th>
                                    <?php
                                    if($_SESSION["datosUsuarioActual"]['usr_tipo']==DEV){
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