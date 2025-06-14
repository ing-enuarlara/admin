<?php   
    require_once("../../sesion.php");

    $idPagina = 85;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    $generoPedido = mysqli_fetch_array($conexionBdComercial->query("SELECT * FROM comercial_pedidos WHERE pedid_cotizacion='" . $_GET["id"] . "'"), MYSQLI_BOTH);

    if(!empty($generoPedido['pedid_id'])){

        try{
            $conexionBdComercial->query("DELETE FROM comercial_pedidos WHERE pedid_id='" . $generoPedido['pedid_id'] . "'");
            $conexionBdComercial->query("DELETE FROM comercial_pedidos_novedades WHERE pednov_pedido='" . $generoPedido['pedid_id'] . "'");
            $conexionBdComercial->query("DELETE FROM comercial_relacion_productos WHERE czpp_cotizacion='" . $generoPedido['pedid_id'] . "' AND czpp_tipo=2");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }

    }

    try{
        $consulta= $conexionBdComercial->query("INSERT INTO comercial_pedidos (pedid_fecha_propuesta, pedid_observaciones, pedid_cliente, pedid_fecha_vencimiento, pedid_vendedor, pedid_creador, pedid_sucursal, pedid_contacto, pedid_forma_pago, pedid_fecha_creacion, pedid_moneda, pedid_cotizacion, pedid_estado, pedid_id_empresa, pedid_fecha_cotizacion) SELECT now(), cotiz_observaciones, cotiz_cliente, cotiz_fecha_vencimiento, cotiz_vendedor, '" . $_SESSION["id"] . "', cotiz_sucursal, cotiz_contacto, cotiz_forma_pago, now(), cotiz_moneda, '" . $_GET["id"] . "', 1, cotiz_id_empresa, cotiz_fecha_propuesta FROM comercial_cotizaciones WHERE cotiz_id='" . $_GET["id"] . "'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }
    $idInsert = mysqli_insert_id($conexionBdComercial);

    try{
        $productos = $conexionBdComercial->query("SELECT * FROM comercial_relacion_productos WHERE czpp_cotizacion='" . $_GET["id"] . "' AND czpp_tipo=1");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    while ($prod = mysqli_fetch_array($productos, MYSQLI_BOTH)) {
        if (empty($prod['czpp_orden'])) $prod['czpp_orden'] = 1;
        if (empty($prod['czpp_cantidad'])) $prod['czpp_cantidad'] = 1;

        try{
            $conexionBdComercial->query("INSERT INTO comercial_relacion_productos(czpp_cotizacion, czpp_producto, czpp_valor, czpp_orden, czpp_cantidad, czpp_impuesto, czpp_tipo, czpp_servicio, czpp_combo, czpp_descuento)VALUES('" . $idInsert . "','" . $prod['czpp_producto'] . "', '" . $prod['czpp_valor'] . "', '" . $prod['czpp_orden'] . "', '" . $prod['czpp_cantidad'] . "', '" . $prod['czpp_impuesto'] . "', 2, '" . $prod['czpp_servicio'] . "', '" . $prod['czpp_combo'] . "', '" . $prod['czpp_descuento'] . "')");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }

    }
    
    $dia=date("d");
    $mes=date("M");
    try{
        mysqli_query($conexionBdComercial,"INSERT INTO comercial_pedidos_novedades(pednov_dia, pednov_mes, pednov_estado, pednov_novedad, pednov_pedido, pednov_usuario)VALUES('" . $dia . "', '" . $mes . "', 1, 'Hemos recibido su pedido,  lo estamos preparando para su envío', '" . $idInsert . "', '" . $_SESSION["id"] . "')");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    try{
        $conexionBdComercial->query("UPDATE comercial_cotizaciones SET cotiz_vendida=1, cotiz_fecha_vendida=now() WHERE cotiz_id='" . $_GET["id"] . "'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/pedidos.php?q=' . $idInsert . '";</script>';
    exit();