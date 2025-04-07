<?php
    require_once("../../sesion.php");

    $idPagina = 150;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        $conexionBdPaginaWeb->query("INSERT INTO sliders_paginas(slp_title, slp_text, slp_id_empresa)VALUES('" . $_POST["titulo"] . "', '" . $_POST["contenido"] . "', '".$_SESSION["idEmpresa"]."')");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    $idInsertU = mysqli_insert_id($conexionBdPaginaWeb);

	if (!empty($_POST['tipoImg']) && (!empty($_FILES['imgSlider']['name']) || !empty($_POST['urlImg']))) {
        if (!empty($_FILES['imgSlider']['name'])) {
            $destino = RUTA_PROYECTO."files/slider";
            $fileName = subirArchivosAlServidor($_FILES['imgSlider'], 'sld', $destino);
        }
        
        if (!empty($_POST['urlImg'])) {
            $fileName = $_POST['urlImg'];
        }

        try{
            $conexionBdPaginaWeb->query("UPDATE sliders_paginas SET slp_imagen = '" . $fileName . "', slp_tipo_img = '" . $_POST["tipoImg"] . "' WHERE slp_id ='" . $idInsertU . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
	}

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/sliders.php";</script>';
    exit();