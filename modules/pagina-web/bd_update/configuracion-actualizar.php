<?php
    require_once("../../sesion.php");

    $idPagina = 39;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	if ($_FILES['foto']['name'] != "") {
		$destino = RUTA_PROYECTO."files/logo";
		$fileName = subirArchivosAlServidor($_FILES['foto'], 'lg', $destino);
    
        $conexionBdPaginaWeb->query("UPDATE configuracion SET conf_logo='" . $fileName . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
	}

	if ($_FILES['imgMenu']['name'] != "") {
		$destino = RUTA_PROYECTO."files/";
		$fileName = subirArchivosAlServidor($_FILES['imgMenu'], 'bnr', $destino);
    
        $conexionBdPaginaWeb->query("UPDATE configuracion SET conf_imgMenu='" . $fileName . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
	}

	if ($_FILES['bannerP1']['name'] != "") {
		$destino = RUTA_PROYECTO."files/banner";
		$fileName = subirArchivosAlServidor($_FILES['bannerP1'], 'bnr', $destino);
    
        $conexionBdPaginaWeb->query("UPDATE configuracion SET conf_banner_p1='" . $fileName . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
	}

	if ($_FILES['bannerP2']['name'] != "") {
		$destino = RUTA_PROYECTO."files/banner";
		$fileName = subirArchivosAlServidor($_FILES['bannerP2'], 'bnr', $destino);
    
        $conexionBdPaginaWeb->query("UPDATE configuracion SET conf_banner_p2='" . $fileName . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
	}

	if ($_FILES['bannerP3']['name'] != "") {
		$destino = RUTA_PROYECTO."files/banner";
		$fileName = subirArchivosAlServidor($_FILES['bannerP3'], 'bnr', $destino);
    
        $conexionBdPaginaWeb->query("UPDATE configuracion SET conf_banner_p3='" . $fileName . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
	}

	if ($_FILES['bannerP4']['name'] != "") {
		$destino = RUTA_PROYECTO."files/banner";
		$fileName = subirArchivosAlServidor($_FILES['bannerP4'], 'bnr', $destino);
    
        $conexionBdPaginaWeb->query("UPDATE configuracion SET conf_banner_p4='" . $fileName . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
	}

	if ($_FILES['bannerP5']['name'] != "") {
		$destino = RUTA_PROYECTO."files/banner";
		$fileName = subirArchivosAlServidor($_FILES['bannerP5'], 'bnr', $destino);
    
        $conexionBdPaginaWeb->query("UPDATE configuracion SET conf_banner_p5='" . $fileName . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
	}

	if ($_FILES['bannerP6']['name'] != "") {
		$destino = RUTA_PROYECTO."files/banner";
		$fileName = subirArchivosAlServidor($_FILES['bannerP6'], 'bnr', $destino);
    
        $conexionBdPaginaWeb->query("UPDATE configuracion SET conf_banner_p6='" . $fileName . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
	}

	if ($_FILES['bannerG1']['name'] != "") {
		$destino = RUTA_PROYECTO."files/banner";
		$fileName = subirArchivosAlServidor($_FILES['bannerG1'], 'bnr', $destino);
    
        $conexionBdPaginaWeb->query("UPDATE configuracion SET conf_banner_g1='" . $fileName . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
	}

	if ($_FILES['slider1']['name'] != "") {
		$destino = RUTA_PROYECTO."files/slider";
		$fileName = subirArchivosAlServidor($_FILES['slider1'], 'sld', $destino);
    
        $conexionBdPaginaWeb->query("UPDATE configuracion SET conf_slider1='" . $fileName . "', conf_textSlider1='" . $_POST["textSlider1"] . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
	}

	if ($_FILES['slider2']['name'] != "") {
		$destino = RUTA_PROYECTO."files/slider";
		$fileName = subirArchivosAlServidor($_FILES['slider2'], 'sld', $destino);
    
        $conexionBdPaginaWeb->query("UPDATE configuracion SET conf_slider2='" . $fileName . "', conf_textSlider2='" . $_POST["textSlider2"] . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
	}

	$whatsapp='';
	if (!empty($_POST["whatsapp"])) {
		$whatsapp='https://api.whatsapp.com/send?phone=57'.$_POST["whatsapp"];
	}

    $conexionBdPaginaWeb->query("UPDATE configuracion SET conf_empresa='" . $_POST["nombre"] . "', conf_descripcion_pagina='" . $_POST["descripcionPagina"] . "', conf_descripcion_corta='" . $_POST["descripcionCorta"] . "', conf_palabras_claves='" . $_POST["palabrasClaves"] . "', conf_email='" . $_POST["email"] . "', conf_telefono='" . $_POST["telefono"] . "', conf_web='" . $_POST["web"] . "', conf_direccion='" . $_POST["direccion"] . "', conf_envios='" . $_POST["envios"] . "', conf_text_encabezado='" . $_POST["textEncabezado"] . "', conf_facebook='" . $_POST["facebook"] . "', conf_instagram='" . $_POST["instagram"] . "', conf_tiktok='" . $_POST["tiktok"] . "', conf_whatsapp='" . $whatsapp . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/configuracion.php";</script>';
    exit();