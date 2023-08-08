<?php
    require_once("../../sesion.php");

    $idPagina = 11;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        $conexionBdSistema->query("INSERT INTO sistema_modulos(mod_nombre)VALUES('" . $_POST["nombre"] . "')");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    $idInsertU = mysqli_insert_id($conexionBdSistema);

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/modulos-editar.php?id=' . $idInsertU . '";</script>';
    exit();