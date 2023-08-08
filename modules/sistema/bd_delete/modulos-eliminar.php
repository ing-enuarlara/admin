<?php
    require_once("../../sesion.php");

	$idPagina = 13;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
		$conexionBdSistema->query("DELETE FROM sistema_modulos WHERE mod_id='" . $_GET["id"] . "'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="../bd_read/modulos.php";</script>';
	exit();