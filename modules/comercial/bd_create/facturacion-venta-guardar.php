<?php
    require_once("../../sesion.php");
    require('../../../apis/apis-dolar.php');

    $idPagina = 106;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    $conexionBdComercial->query("INSERT INTO comercial_facturas(factura_fecha_propuesta, factura_cliente, factura_fecha_vencimiento, factura_vendedor, factura_creador, factura_forma_pago, factura_fecha_creacion, factura_moneda, factura_observaciones, factura_tipo, factura_id_empresa)VALUES('" . $_POST["fechaPropuesta"] . "','" . $_POST["cliente"] . "','" . $_POST["fechaVencimiento"] . "','" . $_POST["vendedor"] . "','" . $_SESSION["id"] . "','" . $_POST["formaPago"] . "',now(),'" . $_POST["moneda"] . "','" . $_POST["notas"] . "', 1, '" . $datosUsuarioActual['usr_id_empresa'] . "')");

    $idInsertU = mysqli_insert_id($conexionBdComercial);

    $tipo = 4;
    require("cotizaciones-guardar-productos.php");

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/facturacion-venta-editar.php?id=' . $idInsertU . '#productos";</script>';
    exit();