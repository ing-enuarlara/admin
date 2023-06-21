<?php
    require_once("../../sesion.php");

    $idPagina = 41;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    $consultaConfigColor = $conexionBdGeneral->query("SELECT * FROM general_color_store WHERE gcs_id_empresa='".$configuracion['conf_id_empresa']."'");
    $numDatos= $consultaConfigColor->num_rows;

    if($numDatos>0){
        
        $conexionBdGeneral->query("UPDATE general_color_store SET gcs_primario='" . $_POST["colorP"] . "', gcs_primarioOscuro='" . $_POST["colorPO"] . "', gcs_secundario='" . $_POST["colorS"] . "', gcs_secundarioOscuro='" . $_POST["colorSO"] . "', gcs_blanco='" . $_POST["colorC"] . "', gcs_negro='" . $_POST["colorO"] . "' WHERE gcs_id_empresa='" . $_POST["id"] . "'");
    }else{

        $conexionBdGeneral->query("INSERT INTO general_color_store (gcs_primario, gcs_primarioOscuro, gcs_secundario, gcs_secundarioOscuro, gcs_blanco, gcs_negro, gcs_id_empresa) VALUES ('" . $_POST["colorP"] . "', '" . $_POST["colorPO"] . "', '" . $_POST["colorS"] . "', '" . $_POST["colorSO"] . "', '" . $_POST["colorC"] . "', '" . $_POST["colorO"] . "', '" . $_POST["id"] . "')");
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/configuracion-color-store.php";</script>';
    exit();