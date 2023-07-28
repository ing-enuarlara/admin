<?php
    require_once("../../sesion.php");

    $idPagina = 89;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    if($_POST["estado"]==3){

        $dia=date("d");
        $mes=date("M");
        mysqli_query($conexionBdComercial,"INSERT INTO comercial_pedidos_novedades(pednov_dia, pednov_mes, pednov_estado, pednov_novedad, pednov_pedido, pednov_usuario)VALUES('" . $dia . "', '" . $mes . "', 3, 'Su pedido fue entregado', '" . $_POST["id"] . "', '" . $_SESSION["id"] . "')");

    }

    mysqli_query($conexionBdComercial,"UPDATE comercial_pedidos SET pedid_fecha_propuesta='" . $_POST["fecha"] . "', pedid_estado='" . $_POST["estado"] . "', pedid_empresa_envio='" . $_POST["empresaEnvio"] . "', pedid_codigo_seguimiento='" . $_POST["codigoSeguimiento"] . "', pedid_ultima_modificacion=now(), pedid_usuario_modificacion='" . $_SESSION["id"] . "' WHERE pedid_id='" . $_POST["id"] . "'");

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");
        
    echo '<script type="text/javascript">window.location.href="../bd_read/pedidos-estado.php?id='.$_POST["id"].'";</script>';
    exit();