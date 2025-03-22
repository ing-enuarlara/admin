<?php
    require_once("../../sesion.php");

    $idPagina = 141;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        $conexionBdPaginaWeb->query("INSERT INTO categorias_blogs(catblo_nombre, catblo_id_empresa)VALUES('" . $_POST["nomCategoria"] . "', '".$_SESSION["idEmpresa"]."')");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/categorias-blogs.php";</script>';
    exit();