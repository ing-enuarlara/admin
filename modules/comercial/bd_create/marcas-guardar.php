<?php
    require_once("../../sesion.php");

    $idPagina = 34;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    $conexionBdComercial->query("INSERT INTO comercial_marcas(cmar_nombre, cmar_categoria, cmar_menu, cmar_mas_joyas, cmar_id_empresa)VALUES('" . $_POST["nombre"] . "', '" . $_POST["categoria"] . "', '" . $_POST["menu"] . "', '" . $_POST["masJoyas"] . "', '" . $datosUsuarioActual['usr_id_empresa'] . "')");

    $idInsertU = mysqli_insert_id($conexionBdComercial);

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/marcas-editar.php?id=' . $idInsertU . '";</script>';
    exit();