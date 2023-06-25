<?php
    require_once("../../sesion.php");

    $idPagina = 54;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    $conexionBdPaginaWeb->query("UPDATE pagina_legales SET pal_nombre='" . $_POST["nombre"] . "', pal_contenido='" . $_POST["contenido"] . "', pal_modificacion=now() WHERE pal_id='" . $_POST["id"] . "'");

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/legales.php";</script>';
    exit();