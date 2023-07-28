<?php   
    require_once("../../sesion.php");

    $idPagina = 93;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    $generoRemision = mysqli_fetch_array(mysqli_query($conexionBdComercial,"SELECT * FROM comercial_remisiones WHERE remi_pedido='" . $_GET["id"] . "'"));
    if(!empty($generoRemision['remi_id'])){

        mysqli_query($conexionBdComercial,"DELETE FROM comercial_remisiones WHERE remi_id='" . $generoRemision['remi_id'] . "'");
        mysqli_query($conexionBdComercial,"DELETE FROM comercial_relacion_productos WHERE czpp_cotizacion='" . $generoRemision['remi_id'] . "' AND czpp_tipo=3");

    }

    mysqli_query($conexionBdComercial,"INSERT INTO comercial_remisiones(remi_fecha_propuesta, remi_observaciones, remi_cliente, remi_fecha_vencimiento, remi_vendedor, remi_creador, remi_sucursal, remi_contacto, remi_forma_pago, remi_fecha_creacion, remi_moneda, remi_pedido, remi_estado, remi_id_empresa, remi_fecha_pedido) SELECT now(), pedid_observaciones, pedid_cliente, pedid_fecha_vencimiento, pedid_vendedor, '" . $_SESSION["id"] . "', pedid_sucursal, pedid_contacto, pedid_forma_pago, pedid_fecha_creacion, pedid_moneda, pedid_id, 1, pedid_id_empresa, pedid_fecha_propuesta FROM comercial_pedidos WHERE pedid_id='" . $_GET["id"] . "'");

    $idInsert = mysqli_insert_id($conexionBdComercial);


    $productos = mysqli_query($conexionBdComercial,"SELECT * FROM comercial_relacion_productos WHERE czpp_cotizacion='" . $_GET["id"] . "' AND czpp_tipo=2");


    while ($prod = mysqli_fetch_array($productos)) {
        if ($prod['czpp_orden'] == "") $prod['czpp_orden'] = 1;
        if ($prod['czpp_cantidad'] == "") $prod['czpp_cantidad'] = 1;

        mysqli_query($conexionBdComercial,"INSERT INTO comercial_relacion_productos(czpp_cotizacion, czpp_producto, czpp_valor, czpp_orden, czpp_cantidad, czpp_impuesto, czpp_tipo, czpp_bodega, czpp_descuento)VALUES('" . $idInsert . "','" . $prod['czpp_producto'] . "', '" . $prod['czpp_valor'] . "', '" . $prod['czpp_orden'] . "', '".$prod['czpp_cantidad']."', '" . $prod['czpp_impuesto'] . "', 3, 1, '" . $prod['czpp_descuento'] . "')");
        
        $contador++;
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/remisiones.php";</script>';
    exit();