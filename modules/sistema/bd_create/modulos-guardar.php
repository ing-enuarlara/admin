<?php
    require_once("../../sesion.php");

    $idPagina = 11;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    $conexionBdAdmin->query("INSERT INTO modulos(mod_nombre)VALUES('" . $_POST["nombre"] . "')");

    $idInsertU = mysqli_insert_id($conexionBdAdmin);

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/modulos-editar.php?id=' . $idInsertU . '";</script>';
    exit();