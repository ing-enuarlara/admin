<?php
    require_once("../../sesion.php");

	$idPagina = 66;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	$conexionBdAdministrativo->query("DELETE FROM administrativo_usuarios WHERE usr_id='" . $_GET["id"] . "'");

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
	exit();