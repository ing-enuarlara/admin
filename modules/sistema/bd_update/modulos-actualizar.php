<?php
    require_once("../../sesion.php");

    $idPagina = 12;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    $conexionBdAdmin->query("UPDATE modulos SET mod_nombre='" . $_POST["nombre"] . "'  WHERE mod_id='" . $_POST["id"] . "'");

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/modulos.php";</script>';
    exit();