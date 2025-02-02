<?php
    require_once("../../sesion.php");

    $idPagina = 143;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    try{
        $conexionBdPaginaWeb->query("UPDATE categorias_blogs SET catblo_nombre='" . $_POST["nomCategoria"] . "' WHERE catblo_id='" . $_POST["id"] . "'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/categorias-blogs.php";</script>';
    exit();