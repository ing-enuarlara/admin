<?php
    require_once("../../sesion.php");

    $idPagina = 108;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        mysqli_query($conexionBdComercial,"UPDATE comercial_facturas SET factura_estado=1 WHERE factura_id='" . $_GET["id"] . "'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");
        
    echo '<script type="text/javascript">window.location.href="../bd_read/facturacion.php?q='.$_GET["id"].'";</script>';
    exit();