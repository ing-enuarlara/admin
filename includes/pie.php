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

<?php require_once(RUTA_PROYECTO."includes/guardar-historial-acciones.php"); ?>