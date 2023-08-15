<?php
try {
    $consultaMensajesNoVistos = mysqli_query($conexionBdMicuenta, "SELECT men_visto FROM micuenta_mensajes WHERE men_para='" . $_SESSION['id'] . "' AND men_visto=0 AND men_eliminado_para!=1");
} catch (Exception $e) {
    include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
}
$noVistos = mysqli_num_rows($consultaMensajesNoVistos);
?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Carpetas</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item active">
                <a href="<?= REDIRECT_ROUTE ?>modules/mi_cuenta/bd_read/mailbox.php" class="nav-link">
                    <i class="fas fa-inbox"></i> Recibidos
                    <?php
                        if($noVistos>0){
                    ?>
                        <span class="badge bg-success float-right"><?= $noVistos ?></span>
                    <?php } ?>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= REDIRECT_ROUTE ?>modules/mi_cuenta/bd_read/mailbox-enviados.php" class="nav-link">
                    <i class="far fa-envelope"></i> Enviados
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= REDIRECT_ROUTE ?>modules/mi_cuenta/bd_read/mailbox-eliminados.php" class="nav-link">
                    <i class="far fa-trash-alt"></i> Eliminados
                </a>
            </li>
        </ul>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->