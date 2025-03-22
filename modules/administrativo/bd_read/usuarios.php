<?php
include("../../sesion.php");

$idPagina = 48;

include(RUTA_PROYECTO."includes/verificar-paginas.php");
include(RUTA_PROYECTO."includes/head.php");
$busqueda='';
$filtro='';
$filtroAdmin='';
if($_SESSION["datosUsuarioActual"]['usr_tipo']!=DEV){
    $filtroAdmin .= " AND usr_id_empresa='".$_SESSION["idEmpresa"]."'";
}
if (!empty($_GET['search'])) {
    $busqueda = $_GET['search'];
    $filtro .= " AND (
    usr_id LIKE '%".$busqueda."%' 
    OR usr_login LIKE '%".$busqueda."%' 
    OR usr_nombre LIKE '%".$busqueda."%' 
    OR usr_email LIKE '%".$busqueda."%' 
    OR usr_telefono LIKE '%".$busqueda."%' 
    OR utipo_nombre LIKE '%".$busqueda."%' 
    OR usr_documento LIKE '%".$busqueda."%' 
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
  var operacion = 1;	

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
					    <a href="usuarios-agregar.php" class="btn btn-primary"><i class="fas fa-solid fa-plus"></i> Agregar Usuarios</a>
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
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Telefono</th>
                                    <th>Tipo de usuario</th>
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
                                try{
                                    $usuarios= $conexionBdAdministrativo->query("SELECT * FROM administrativo_usuarios
                                    INNER JOIN administrativo_roles ON utipo_id=usr_tipo
                                    INNER JOIN ".BDADMIN.".clientes_admin ON cliAdmi_id=usr_id_empresa 
                                    WHERE usr_id=usr_id {$filtroAdmin} {$filtro}");
                                } catch (Exception $e) {
                                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                                }
                                $num=1;
                                while($result = mysqli_fetch_array($usuarios, MYSQLI_BOTH)){

                                    $bgColor = '';
                                    $cheked = '';
                                    if($result['usr_bloqueado']==1) {$bgColor = '#ff572238'; $cheked = 'checked';}
                                ?>
                                <tr id="Reg<?=$result['usr_id'];?>" style="background-color:<?=$bgColor;?>;">
                                    <td><?=$num;?></td>
                                    <td>
                                        <input type="checkbox" id="<?=$result['usr_id'];?>" name="bloqueado" value="1" onChange="guardarAjax(this)" <?=$cheked;?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                    </td>
                                    <td><?=$result['usr_id'];?></td>
                                    <td><?=$result['usr_login'];?></td>
                                    <td><?=$result['usr_nombre'];?></td>
                                    <td><?=$result['usr_email'];?></td>
                                    <td><?=$result['usr_telefono'];?></td>
                                    <td><?=$result['utipo_nombre'];?></td>
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
                                                <a class="dropdown-item" href="usuarios-editar.php?id=<?=$result[0];?>">Editar</a>
                                                <a class="dropdown-item" href="<?=REDIRECT_ROUTE?>modules/mi_cuenta/bd_read/mi-calendario.php?id=<?=$result[0];?>">Calendario</a>
                                                <?php if($result['usr_tipo']!=DEV AND $_SESSION["datosUsuarioActual"]['usr_tipo']==DEV){?>
                                                <a class="dropdown-item" href="<?=REDIRECT_ROUTE?>includes/auto-login.php?user=<?=$result['usr_id'];?>&tipe=<?=$result['usr_tipo'];?>">Autologin</a>
                                                <?php }?>
                                                <!--<div class="dropdown-divider"></div>-->
                                                <a class="dropdown-item" href="../bd_delete/usuarios-eliminar.php?id=<?=$result[0];?>" onClick="if(!confirm('Este registro se eliminará del sistema, Desea continuar bajo su responsabilidad?')){return false;}">Eliminar</a>
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
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Telefono</th>
                                    <th>Tipo de usuario</th>
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