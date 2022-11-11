<?php
    require_once("../../sesion.php");

	$idPagina = 13;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	$conexionBdSistema->query("DELETE FROM sistema_modulos WHERE mod_id='" . $_GET["id"] . "'");

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="../bd_read/modulos.php";</script>';
	exit();