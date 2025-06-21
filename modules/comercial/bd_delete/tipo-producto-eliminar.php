<?php
    require_once("../../sesion.php");

	$idPagina = 64;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
		$conexionBdComercial->query("DELETE FROM comercial_marca_productos WHERE ctipo_id='" . $_GET["id"] . "'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
	exit();