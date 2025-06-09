<?php
    require_once("../../sesion.php");
	require_once(RUTA_PROYECTO . 'class/Categorias_Catalogo_Principal.php');

	$idPagina = 177;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
		Categorias_Catalogo_Principal::Delete([ "ccatp_id" => $_GET["id"]]);
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
	exit();