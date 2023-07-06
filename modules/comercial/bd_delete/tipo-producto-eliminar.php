<?php
    require_once("../../sesion.php");

	$idPagina = 64;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	$conexionBdComercial->query("DELETE FROM comercial_tipo_productos WHERE ctipo_id='" . $_GET["id"] . "'");

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
	exit();