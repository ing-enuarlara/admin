<?php
    require_once("../../sesion.php");

	$idPagina = 55;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
		$conexionBdPaginaWeb->query("DELETE FROM pagina_legales WHERE pal_id='" . $_GET["id"] . "'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
	exit();