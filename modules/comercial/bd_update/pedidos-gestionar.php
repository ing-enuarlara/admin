<?php
    require_once("../../sesion.php");

    $idPagina = 91;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    if($_GET["op"]==1){
        try{
            mysqli_query($conexionBdComercial,"UPDATE comercial_pedidos SET pedid_estado=0 WHERE pedid_id='" . $_GET["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }

        $dia=date("d");
        $mes=date("M");
        try{
            mysqli_query($conexionBdComercial,"INSERT INTO comercial_pedidos_novedades(pednov_dia, pednov_mes, pednov_estado, pednov_novedad, pednov_pedido, pednov_usuario)VALUES('" . $dia . "', '" . $mes . "', 0, 'Su pedido fue anulado', '" . $_GET["id"] . "', '" . $_SESSION["id"] . "')");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }

        try{
            mysqli_query($conexionBdComercial,"UPDATE comercial_cotizaciones SET cotiz_vendida=0 WHERE cotiz_id='" . $_GET["idC"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
    }

    if($_GET["op"]==2){
        try{
            mysqli_query($conexionBdComercial,"UPDATE comercial_pedidos SET pedid_estado=1 WHERE pedid_id='" . $_GET["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }

        $dia=date("d");
        $mes=date("M");
        try{
            mysqli_query($conexionBdComercial,"INSERT INTO comercial_pedidos_novedades(pednov_dia, pednov_mes, pednov_estado, pednov_novedad, pednov_pedido, pednov_usuario)VALUES('" . $dia . "', '" . $mes . "', 1, 'Su pedido fue restaurado, lo estamos preparando para su envío', '" . $_GET["id"] . "', '" . $_SESSION["id"] . "')");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }

        try{
            mysqli_query($conexionBdComercial,"UPDATE comercial_cotizaciones SET cotiz_vendida=1 WHERE cotiz_id='" . $_GET["idC"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/pedidos.php";</script>';
    exit();