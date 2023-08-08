<?php
    require_once("../../sesion.php");

    $idPagina = 92;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        mysqli_query($conexionBdComercial,"DELETE FROM comercial_pedidos WHERE pedid_id='" . $_GET["id"] . "'");
        mysqli_query($conexionBdComercial,"DELETE FROM comercial_pedidos_novedades WHERE pednov_pedido='" . $_GET["id"] . "'");
        mysqli_query($conexionBdComercial,"DELETE FROM comercial_relacion_productos WHERE czpp_cotizacion='" . $_GET["id"] . "' AND czpp_tipo=2");
        mysqli_query($conexionBdComercial,"UPDATE comercial_cotizaciones SET cotiz_vendida=0 WHERE cotiz_id='" . $_GET["idC"] . "'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/pedidos.php";</script>';
    exit();