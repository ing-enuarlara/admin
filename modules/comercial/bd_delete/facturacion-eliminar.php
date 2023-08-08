<?php
    require_once("../../sesion.php");

	$idPagina = 104;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
		$conexionBdComercial->query("DELETE FROM comercial_facturas WHERE factura_id='" . $_GET["id"] . "'");
		$conexionBdComercial->query("DELETE FROM comercial_relacion_productos WHERE czpp_cotizacion='" . $_GET["id"] . "' AND czpp_tipo=4");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
	exit();