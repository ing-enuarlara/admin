<?php
    require_once("../../sesion.php");

    $idPagina = 30;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        $conexionBdComercial->query("UPDATE comercial_categorias SET ccat_nombre='" . $_POST["nombre"] . "', ccat_menu='" . $_POST["menu"] . "', ccat_otros='" . $_POST["footer"] . "' WHERE ccat_id='" . $_POST["id"] . "'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/categorias.php";</script>';
    exit();