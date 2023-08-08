<?php
    require_once("../../sesion.php");

    $idPagina = 41;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        $consultaConfigColor = $conexionBdPaginaWeb->query("SELECT * FROM general_color_store WHERE gcs_id_empresa='".$configuracion['conf_id_empresa']."'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }
    $numDatos= $consultaConfigColor->num_rows;

    if($numDatos>0){

        try{
            $conexionBdPaginaWeb->query("UPDATE general_color_store SET 
            gcs_encaPrimario='" . $_POST["encaPrimario"] . "', 
            gcs_encaSecundario='" . $_POST["encaSecundario"] . "', 
            gcs_encaLetras='" . $_POST["encaLetras"] . "', 
            gcs_encaBorder='" . $_POST["encaBorder"] . "', 
            gcs_bodyFondo='" . $_POST["bodyFondo"] . "', 
            gcs_bodyLetras='" . $_POST["bodyLetras"] . "', 
            gcs_bodyLineas='" . $_POST["bodyLineas"] . "', 
            gcs_bodyIconos='" . $_POST["bodyIconos"] . "', 
            gcs_bottonPrimario='" . $_POST["bottonPrimario"] . "', 
            gcs_bottonSecundario='" . $_POST["bottonSecundario"] . "', 
            gcs_suscripcionFondo='" . $_POST["suscripcionFondo"] . "', 
            gcs_suscripcionLetras='" . $_POST["suscripcionLetras"] . "', 
            gcs_footerPrimario='" . $_POST["footerPrimario"] . "', 
            gcs_footerSecundario='" . $_POST["footerSecundario"] . "', 
            gcs_footerLetras='" . $_POST["footerLetras"] . "', 
            gcs_paginaFondo='" . $_POST["paginaFondo"] . "', 
            gcs_paginaLetras='" . $_POST["paginaLetras"] . "'
            WHERE gcs_id_empresa='" . $_POST["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
    }else{

        try{
            $conexionBdPaginaWeb->query("INSERT INTO general_color_store 
            (gcs_encaPrimario, gcs_encaSecundario, gcs_encaLetras, gcs_encaBorder, gcs_bodyFondo, gcs_bodyLetras, gcs_bodyLineas, gcs_bodyIconos, gcs_bottonPrimario, gcs_bottonSecundario, gcs_suscripcionFondo, gcs_suscripcionLetras, gcs_footerPrimario, gcs_footerSecundario, gcs_footerLetras, gcs_paginaFondo, gcs_paginaLetras, gcs_id_empresa) 
            VALUES 
            ('" . $_POST["encaPrimario"] . "', '" . $_POST["encaSecundario"] . "', '" . $_POST["encaLetras"] . "', '" . $_POST["encaBorder"] . "', '" . $_POST["bodyFondo"] . "', '" . $_POST["bodyLetras"] . "', '" . $_POST["bodyLineas"] . "', '" . $_POST["bodyIconos"] . "', '" . $_POST["bottonPrimario"] . "', '" . $_POST["bottonSecundario"] . "', '" . $_POST["suscripcionFondo"] . "', '" . $_POST["suscripcionLetras"] . "', '" . $_POST["footerPrimario"] . "', '" . $_POST["footerSecundario"] . "', '" . $_POST["footerLetras"] . "', '" . $_POST["paginaFondo"] . "', '" . $_POST["paginaLetras"] . "', '" . $_POST["id"] . "')");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/configuracion-color-store.php";</script>';
    exit();