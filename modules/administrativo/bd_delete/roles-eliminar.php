<?php
    require_once("../../sesion.php");

	$idPagina = 47;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
		$conexionBdAdministrativo->query("DELETE FROM administrativo_roles WHERE utipo_id='" . $_GET["id"] . "'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
	exit();