<?php
    require_once("../../sesion.php");

    $idPagina = 61;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        $conexionBdComercial->query("INSERT INTO comercial_tipo_productos(ctipo_nombre, ctipo_estado, ctipo_id_empresa)VALUES('" . $_POST["nombre"] . "', 1, '" . $_SESSION["idEmpresa"] . "')");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    $idInsertU = mysqli_insert_id($conexionBdComercial);

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/tipo-producto-editar.php?id=' . $idInsertU . '";</script>';
    exit();