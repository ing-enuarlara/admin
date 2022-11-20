<?php
    require_once("../../sesion.php");

    $idPagina = 46;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    $conexionBdAdministrativo->query("UPDATE administrativo_roles SET utipo_nombre='" . $_POST["nombre"] . "' WHERE utipo_id='" . $_POST["id"] . "'");

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/roles.php";</script>';
    exit();