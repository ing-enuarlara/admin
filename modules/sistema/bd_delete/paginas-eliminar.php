<?php
    require_once("../../sesion.php");

	$idPagina = 7;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	$conexionBdAdmin->query("DELETE FROM paginas WHERE pag_id='" . $_GET["id"] . "'");

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="../bd_read/paginas.php";</script>';
	exit();