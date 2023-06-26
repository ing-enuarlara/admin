<?php
    require_once("../../sesion.php");

	$idPagina = 25;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	$conexionBdComercial->query("DELETE FROM comercial_productos WHERE cprod_id='" . $_GET["id"] . "'");
	$conexionBdComercial->query("DELETE FROM comercial_productos_fotos WHERE cpf_id_producto='" . $_GET["id"] . "'");

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
	exit();