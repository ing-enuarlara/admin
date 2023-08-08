<?php
    require_once("../../sesion.php");

    $idPagina = 5;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        $conexionBdSistema->query("INSERT INTO sistema_paginas(pag_nombre, pag_tipo_crud, pag_id_modulo, pag_ruta)VALUES('" . $_POST["nombre"] . "','" . $_POST["crud"] . "','" . $_POST["modulo"] . "','". $_POST["ruta"] . "')");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    $idInsertU = mysqli_insert_id($conexionBdSistema);

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/paginas-editar.php?id=' . $idInsertU . '";</script>';
    exit();