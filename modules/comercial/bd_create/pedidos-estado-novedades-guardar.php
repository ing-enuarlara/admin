<?php
    require_once("../../sesion.php");

    $idPagina = 90;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    if($_POST["estadoActual"]!=$_POST["estado"]){
        try{
            mysqli_query($conexionBdComercial,"UPDATE comercial_pedidos SET pedid_estado='" . $_POST["estado"] . "' WHERE pedid_id='".$_POST["id"]."'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
    }

    try{
        mysqli_query($conexionBdComercial,"INSERT INTO comercial_pedidos_novedades(pednov_dia, pednov_mes, pednov_estado, pednov_novedad, pednov_pedido, pednov_usuario)VALUES('" . $_POST["dia"] . "', '" . $_POST["mes"] . "', '" . $_POST["estado"] . "', '" . $_POST["novedad"] . "', '" . $_POST["id"] . "', '" . $_SESSION["id"] . "')");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/pedidos-estado.php?id=' . $_POST["id"] . '";</script>';
    exit();