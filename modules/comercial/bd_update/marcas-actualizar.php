<?php
    require_once("../../sesion.php");

    $idPagina = 36;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        $conexionBdComercial->query("UPDATE comercial_marcas SET cmar_nombre='" . $_POST["nombre"] . "', cmar_categoria='" . $_POST["categoria"] . "', cmar_menu='" . $_POST["menu"] . "', cmar_mas_productos='" . $_POST["masJoyas"] . "' WHERE cmar_id='" . $_POST["id"] . "'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/marcas.php";</script>';
    exit();