<?php
    require_once("../../sesion.php");

    $idPagina = 152;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    try{
        $conexionBdPaginaWeb->query("UPDATE sliders_paginas SET slp_title='" . $_POST["titulo"] . "', slp_text='" . $_POST["contenido"] . "', slp_activo='" . $_POST["activo"] . "' WHERE slp_id='" . $_POST["id"] . "'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

	if (!empty($_POST['tipoImg']) && (!empty($_FILES['imgSlider']['name']) || !empty($_POST['urlImg']))) {
        if (!empty($_FILES['imgSlider']['name'])) {
            $destino = RUTA_PROYECTO."files/slider";
            $fileName = subirArchivosAlServidor($_FILES['imgSlider'], 'sld', $destino);
        }
        
        if (!empty($_POST['urlImg'])) {
            $fileName = $_POST['urlImg'];
        }

        try{
            $conexionBdPaginaWeb->query("UPDATE sliders_paginas SET slp_imagen = '" . $fileName . "', slp_tipo_img = '" . $_POST["tipoImg"] . "' WHERE slp_id ='" . $_POST["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
	}

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/sliders.php";</script>';
    exit();