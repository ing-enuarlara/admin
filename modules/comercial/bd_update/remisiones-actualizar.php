<?php
    require_once("../../sesion.php");
    require('../../../apis/apis-dolar.php');

    $idPagina = 99;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    $conexionBdComercial->query("UPDATE comercial_remisiones SET 
    remi_fecha_propuesta='" . $_POST["fechaPropuesta"] . "', 
    remi_cliente='" . $_POST["cliente"] . "', 
    remi_fecha_vencimiento='" . $_POST["fechaVencimiento"] . "', 
    remi_vendedor='" . $_POST["vendedor"] . "', 
    remi_forma_pago='" . $_POST["formaPago"] . "', 
    remi_moneda='" . $_POST["moneda"] . "', 
    remi_ultima_modificacion=now(), 
    remi_usuario_modificacion='" . $_SESSION["id"] . "', 
    remi_observaciones='" . $conexionBdComercial->real_escape_string($_POST["notas"]) . "' 
    WHERE remi_id='" . $_POST["id"] . "'");

    $tipo = 3;
    require('cotizaciones-actualizar-productos.php');

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/remisiones-editar.php?id='.$_POST["id"].'";</script>';
    exit();