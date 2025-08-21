<?php
    require_once("../../sesion.php");

    $idPagina = 39;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	if (!empty($_FILES['foto']['name'])) {
		$destino = RUTA_PROYECTO."files/logo";
		$fileName = subirArchivosAlServidor($_FILES['foto'], 'lg', $destino);

		try{
			$conexionBdPaginaWeb->query("UPDATE pagina_configuracion SET conf_logo='" . $fileName . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
		} catch (Exception $e) {
			include(RUTA_PROYECTO."includes/error-catch-to-report.php");
		}

        try{
            $conexionBdGeneral->query("UPDATE configuracion SET conf_logo='" . $fileName . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
	}

	if (!empty($_FILES['favicon']['name'])) {
		$destino = RUTA_PROYECTO."files/favicons";
		$fileFavicon = subirArchivosAlServidor($_FILES['favicon'], 'ico', $destino);

		try{
			$conexionBdPaginaWeb->query("UPDATE pagina_configuracion SET conf_favicon='" . $fileFavicon . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
		} catch (Exception $e) {
			include(RUTA_PROYECTO."includes/error-catch-to-report.php");
		}
	}

	$whatsapp='';
	if (!empty($_POST["whatsapp"])) {
		$whatsapp='https://api.whatsapp.com/send?phone=34'.$_POST["whatsapp"];
	}

	try{
		$conexionBdPaginaWeb->query("UPDATE pagina_configuracion SET conf_empresa='" . $_POST["nombre"] . "', conf_descripcion_pagina='" . $_POST["descripcionPagina"] . "', conf_descripcion_corta='" . $_POST["descripcionCorta"] . "', conf_palabras_claves='" . $_POST["palabrasClaves"] . "', conf_email='" . trim($_POST["email"]) . "', conf_telefono='" . trim($_POST["telefono"]) . "', conf_web='" . $_POST["web"] . "', conf_direccion='" . $_POST["direccion"] . "', conf_envios='" . $_POST["envios"] . "', conf_text_encabezado='" . $_POST["textEncabezado"] . "', conf_facebook='" . $_POST["facebook"] . "', conf_instagram='" . $_POST["instagram"] . "', conf_tiktok='" . $_POST["tiktok"] . "', conf_whatsapp='" . $whatsapp . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}

    try{
		$conexionBdGeneral->query("UPDATE configuracion SET conf_empresa='" . $_POST["nombre"] . "', conf_email='" . $_POST["email"] . "', conf_telefono='" . $_POST["telefono"] . "', conf_web='" . $_POST["web"] . "', conf_direccion='" . $_POST["direccion"] . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}
	
	try{
		$consultaConfig = $conexionBdGeneral->query("SELECT * FROM configuracion
		LEFT JOIN ".BDADMIN.".localidad_ciudades ON ciu_id=conf_ciudad
		LEFT JOIN ".BDADMIN.".localidad_departamentos ON dep_id=ciu_departamento 
		WHERE conf_id_empresa='".$_SESSION["idEmpresa"]."'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}
	$_SESSION["configuracion"] = mysqli_fetch_array($consultaConfig, MYSQLI_BOTH);

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/configuracion.php";</script>';
    exit();