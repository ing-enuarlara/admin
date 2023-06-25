<?php
    require_once("../../sesion.php");

    $idPagina = 28;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    $conexionBdComercial->query("INSERT INTO comercial_categorias(ccat_nombre, ccat_menu, ccat_id_empresa)VALUES('" . $_POST["nombre"] . "', '" . $_POST["menu"] . "', '" . $datosUsuarioActual['usr_id_empresa'] . "')");

    $idInsertU = mysqli_insert_id($conexionBdComercial);

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/categorias-editar.php?id=' . $idInsertU . '";</script>';
    exit();