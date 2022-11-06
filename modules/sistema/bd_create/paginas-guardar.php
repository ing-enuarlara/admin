<?php
    require_once("../../sesion.php");

    $idPagina = 5;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    $conexionBdAdmin->query("INSERT INTO paginas(pag_nombre, pag_tipo_crud, pag_id_modulo, pag_ruta)VALUES('" . $_POST["nombre"] . "','" . $_POST["crud"] . "','" . $_POST["modulo"] . "','". $_POST["ruta"] . "')");

    $idInsertU = mysqli_insert_id($conexionBdAdmin);

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/paginas-editar.php?id=' . $idInsertU . '";</script>';
    exit();