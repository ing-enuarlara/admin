<?php   
    require_once("../../sesion.php");

    $idPagina = 19;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    $conexionBdAdmin->query("DELETE FROM modulos_clien_admin WHERE mxca_id_cliAdmin='" . $_GET["id"] . "'");
    $conexionBdAdmin->query("DELETE FROM clientes_admin WHERE cliAdmi_id='" . $_GET["id"] . "'");

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/clientes-admin.php";</script>';
    exit();