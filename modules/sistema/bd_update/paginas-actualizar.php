<?php
    require_once("../../sesion.php");

    $idPagina = 6;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    $conexionBdAdmin->query("UPDATE paginas SET pag_nombre='" . $_POST["nombre"] . "', pag_tipo_crud='" . $_POST["crud"] . "', pag_id_modulo='" . $_POST["modulo"] . "', pag_ruta='" . $_POST["ruta"] ."' WHERE pag_id='" . $_POST["id"] . "'");

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/paginas-editar.php?id=' . $_POST["id"] . '";</script>';
    exit();