<?php   
    require_once("../../sesion.php");

    $idPagina = 86;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    $consulta= $conexionBdComercial->query("INSERT INTO comercial_cotizaciones (cotiz_fecha_propuesta, cotiz_descripcion, cotiz_valor, cotiz_observaciones, cotiz_cliente, cotiz_fecha_vencimiento, cotiz_vendedor, cotiz_creador, cotiz_sucursal, cotiz_contacto, cotiz_forma_pago, cotiz_fecha_creacion, cotiz_moneda, cotiz_id_empresa) SELECT cotiz_fecha_propuesta, cotiz_descripcion, cotiz_valor, cotiz_observaciones, cotiz_cliente, cotiz_fecha_vencimiento, cotiz_vendedor, '" . $_SESSION["id"] . "', cotiz_sucursal, cotiz_contacto, cotiz_forma_pago, now(), cotiz_moneda, cotiz_id_empresa FROM comercial_cotizaciones WHERE cotiz_id='" . $_GET["id"] . "'");
    $idInsert = mysqli_insert_id($conexionBdComercial);


    $productos = $conexionBdComercial->query("SELECT * FROM comercial_relacion_productos WHERE czpp_cotizacion='" . $_GET["id"] . "'");

    while ($prod = mysqli_fetch_array($productos, MYSQLI_BOTH)) {
        $conexionBdComercial->query("INSERT INTO comercial_relacion_productos(czpp_cotizacion, czpp_producto, czpp_valor, czpp_orden, czpp_cantidad, czpp_impuesto, czpp_tipo, czpp_observacion, czpp_servicio, czpp_combo)VALUES('" . $idInsert . "','" . $prod['czpp_producto'] . "', '" . $prod['czpp_valor'] . "', '" . $prod['czpp_orden'] . "', '" . $prod['czpp_cantidad'] . "', '" . $prod['czpp_impuesto'] . "', '" . $prod['czpp_tipo'] . "', '" . $prod['czpp_observacion'] . "', '" . $prod['czpp_servicio'] . "', '" . $prod['czpp_combo'] . "')");
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/cotizaciones-editar.php?id=' . $idInsert . '";</script>';
    exit();