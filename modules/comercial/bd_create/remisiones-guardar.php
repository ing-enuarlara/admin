<?php
    require_once("../../sesion.php");
    require('../../../apis/apis-dolar.php');

    $idPagina = 97;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        $conexionBdComercial->query("INSERT INTO comercial_remisiones(remi_fecha_propuesta, remi_cliente, remi_fecha_vencimiento, remi_vendedor, remi_creador, remi_forma_pago, remi_fecha_creacion, remi_moneda, remi_observaciones, remi_id_empresa)VALUES('" . $_POST["fechaPropuesta"] . "','" . $_POST["cliente"] . "','" . $_POST["fechaVencimiento"] . "','" . $_POST["vendedor"] . "','" . $_SESSION["id"] . "','" . $_POST["formaPago"] . "',now(),'" . $_POST["moneda"] . "','" . $_POST["notas"] . "', '" . $datosUsuarioActual['usr_id_empresa'] . "')");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    $idInsertU = mysqli_insert_id($conexionBdComercial);

    $tipo = 3;
    require("cotizaciones-guardar-productos.php");

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/remisiones-editar.php?id=' . $idInsertU . '";</script>';
    exit();