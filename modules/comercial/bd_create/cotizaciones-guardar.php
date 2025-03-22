<?php
    require_once("../../sesion.php");
    require('../../../apis/apis-dolar.php');

    $idPagina = 78;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        $conexionBdComercial->query("INSERT INTO comercial_cotizaciones(cotiz_fecha_propuesta, cotiz_cliente, cotiz_fecha_vencimiento, cotiz_vendedor, cotiz_creador, cotiz_forma_pago, cotiz_fecha_creacion, cotiz_moneda, cotiz_observaciones, cotiz_id_empresa)VALUES('" . $_POST["fechaPropuesta"] . "','" . $_POST["cliente"] . "','" . $_POST["fechaVencimiento"] . "','" . $_POST["vendedor"] . "','" . $_SESSION["id"] . "','" . $_POST["formaPago"] . "',now(),'" . $_POST["moneda"] . "','" . $_POST["notas"] . "', '" . $_SESSION["idEmpresa"] . "')");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    $idInsertU = mysqli_insert_id($conexionBdComercial);

    $tipo = 1;
    require("cotizaciones-guardar-productos.php");

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/cotizaciones-editar.php?id=' . $idInsertU . '";</script>';
    exit();