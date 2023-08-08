<?php
    require_once("../../sesion.php");

    $idPagina = 44;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    try{
        $conexionBdAdministrativo->query("INSERT INTO administrativo_roles(utipo_nombre)VALUES('" . $_POST["nombre"] . "')");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    $idInsertU = mysqli_insert_id($conexionBdAdministrativo);

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/roles-editar.php?id=' . $idInsertU . '";</script>';
    exit();