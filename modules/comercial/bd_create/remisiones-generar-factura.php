<?php
    require_once("../../sesion.php");

    $idPagina = 102;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        $generoFactura = mysqli_fetch_array(mysqli_query($conexionBdComercial,"SELECT * FROM comercial_facturas WHERE factura_remision='" . $_GET["id"] . "'"));
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }
    if(!empty($generoFactura['factura_id'])){

        try{
            mysqli_query($conexionBdComercial,"DELETE FROM comercial_facturas WHERE factura_id='" . $generoFactura['factura_id'] . "'");
            mysqli_query($conexionBdComercial,"DELETE FROM comercial_relacion_productos WHERE czpp_cotizacion='" . $generoFactura['factura_id'] . "' AND czpp_tipo=4");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }

    }

    try{
        mysqli_query($conexionBdComercial,"INSERT INTO comercial_facturas(factura_fecha_propuesta, factura_observaciones, factura_cliente, factura_fecha_vencimiento, factura_vendedor, factura_creador, factura_sucursal, factura_contacto, factura_forma_pago, factura_fecha_creacion, factura_moneda, factura_estado, factura_tipo, factura_concepto, factura_extranjera, factura_remision, factura_id_empresa, factura_fecha_remision)
        SELECT now(), remi_observaciones, remi_cliente, remi_fecha_vencimiento, remi_vendedor, '" . $_SESSION["id"] . "', remi_sucursal, remi_contacto, remi_forma_pago, now(), remi_moneda, 1, 1, 'Traída de remisión', 0, remi_id, remi_id_empresa, remi_fecha_propuesta FROM comercial_remisiones WHERE remi_id='" . $_GET["id"] . "'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}

    $idInsert = mysqli_insert_id($conexionBdComercial);

    try{
        $productos = mysqli_query($conexionBdComercial,"SELECT * FROM comercial_relacion_productos WHERE czpp_cotizacion='" . $_GET["id"] . "' AND czpp_tipo=3");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }


    while ($prod = mysqli_fetch_array($productos)) {
        if ($prod['czpp_orden'] == "") $prod['czpp_orden'] = 1;
        if ($prod['czpp_cantidad'] == "") $prod['czpp_cantidad'] = 1;

        try{
            mysqli_query($conexionBdComercial,"INSERT INTO comercial_relacion_productos(czpp_cotizacion, czpp_producto, czpp_valor, czpp_orden, czpp_cantidad, czpp_impuesto, czpp_tipo, czpp_descuento, czpp_observacion, czpp_servicio, czpp_combo, czpp_bodega)VALUES('" . $idInsert . "','" . $prod['czpp_producto'] . "', '" . $prod['czpp_valor'] . "', '" . $prod['czpp_orden'] . "', '" . $prod['czpp_cantidad'] . "', '" . $prod['czpp_impuesto'] . "', 4, '" . $prod['czpp_descuento'] . "', '" . $prod['czpp_observacion'] . "', '" . $prod['czpp_servicio'] . "', '" . $prod['czpp_combo'] . "', '" . $prod['czpp_bodega'] . "')");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
        
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/facturacion.php?q=' . $idInsert . '";</script>';
    exit();