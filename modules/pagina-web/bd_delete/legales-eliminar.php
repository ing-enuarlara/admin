<?php
    require_once("../../sesion.php");

	$idPagina = 55;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	$conexionBdPaginaWeb->query("DELETE FROM pagina_legales WHERE pal_id='" . $_GET["id"] . "' AND pal_id_empresa='".$configuracion['conf_id_empresa']."'");

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
	exit();