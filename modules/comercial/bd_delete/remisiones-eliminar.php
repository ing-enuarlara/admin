<?php
    require_once("../../sesion.php");

	$idPagina = 100;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	$conexionBdComercial->query("DELETE FROM comercial_remisiones WHERE remi_id='" . $_GET["id"] . "'");
	$conexionBdComercial->query("DELETE FROM comercial_relacion_productos WHERE czpp_cotizacion='" . $_GET["id"] . "' AND czpp_tipo=3");

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
	exit();