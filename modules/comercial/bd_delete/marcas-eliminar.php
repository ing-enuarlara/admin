<?php
    require_once("../../sesion.php");

	$idPagina = 37;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	$conexionBdComercial->query("DELETE FROM comercial_marcas WHERE cmar_id='" . $_GET["id"] . "'");

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
	exit();