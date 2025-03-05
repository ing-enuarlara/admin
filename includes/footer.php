<?php
    require_once(RUTA_PROYECTO."includes/guardar-historial-acciones.php");
?>
<footer class="main-footer">
    <strong>Copyright &copy; <?=date("Y");?> <a href="https://dev.oceanblue.es" target="_blank">Ocean Blue Dev ®™</a>.</strong> Todos los Derechos son Reservados.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> OCB-1.0.0<br>
        <?php
            if($datosUsuarioActual['usr_tipo']==DEV){
        ?>
        Tiempo de carga: <b><?=$tiempoMostrar;?></b>
        <?php }?>
    </div>
</footer>