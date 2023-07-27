<?php
    require_once("../../sesion.php");
    require('../../../apis/apis-dolar.php');

    $idPagina = 79;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    $conexionBdComercial->query("UPDATE comercial_cotizaciones SET 
    cotiz_fecha_propuesta='" . $_POST["fechaPropuesta"] . "', 
    cotiz_cliente='" . $_POST["cliente"] . "', 
    cotiz_fecha_vencimiento='" . $_POST["fechaVencimiento"] . "', 
    cotiz_vendedor='" . $_POST["vendedor"] . "', 
    cotiz_forma_pago='" . $_POST["formaPago"] . "', 
    cotiz_moneda='" . $_POST["moneda"] . "', 
    cotiz_ultima_modificacion=now(), 
    cotiz_usuario_modificacion='" . $_SESSION["id"] . "', 
    cotiz_observaciones='" . $conexionBdComercial->real_escape_string($_POST["notas"]) . "', 
    cotiz_envio='" . $_POST["envio"] . "' 
    WHERE cotiz_id='" . $_POST["id"] . "'");

    require('cotizaciones-actualizar-productos.php');

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/cotizaciones-editar.php?id='.$_POST["id"].'";</script>';
    exit();
