<?php
    require_once(RUTA_PROYECTO."includes/guardar-historial-acciones.php");
?>
<footer class="main-footer">
    <strong>Copyright &copy; <?=date("Y");?> <a href="https://ing-enuarlara.com" target="_blank">@ing-enuarlara.com ®™</a>.</strong> Todos los Derechos son Reservados.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> ZEFE-1.0.0<br>
        <?php
            if($_SESSION["datosUsuarioActual"]['usr_tipo']==DEV){
        ?>
        Tiempo de carga: <b><?=$tiempoMostrar;?></b>
        <?php }?>
    </div>
</footer>