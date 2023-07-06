<?php
    require_once("../../sesion.php");

    $idPagina = 63;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    $conexionBdComercial->query("UPDATE comercial_tipo_productos SET ctipo_nombre='" . $_POST["nombre"] . "', ctipo_estado='" . $_POST["estado"] . "' WHERE ctipo_id='" . $_POST["id"] . "'");

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/tipo-producto.php";</script>';
    exit();