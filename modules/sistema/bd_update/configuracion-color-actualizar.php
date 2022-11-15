<?php
    require_once("../../sesion.php");

    $idPagina = 41;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    $conexionBdGeneral->query("UPDATE general_color_store SET gcs_primario='" . $_POST["colorP"] . "', gcs_primarioOscuro='" . $_POST["colorPO"] . "', gcs_secundario='" . $_POST["colorS"] . "', gcs_secundarioOscuro='" . $_POST["colorSO"] . "', gcs_blanco='" . $_POST["colorC"] . "', gcs_negro='" . $_POST["colorO"] . "' WHERE gcs_id_empresa='" . $_POST["id"] . "'");

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/configuracion-color-store.php";</script>';
    exit();