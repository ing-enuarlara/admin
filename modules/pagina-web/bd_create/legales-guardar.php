<?php
    require_once("../../sesion.php");

    $idPagina = 53;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        $conexionBdPaginaWeb->query("INSERT INTO pagina_legales(pal_nombre, pal_contenido, pal_modificacion, pal_id_empresa)VALUES('" . $_POST["nombre"] . "', '" . $_POST["contenido"] . "', now(), '".$configuracion['conf_id_empresa']."')");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    $idInsertU = mysqli_insert_id($conexionBdPaginaWeb);

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/legales-editar.php?id=' . $idInsertU . '";</script>';
    exit();