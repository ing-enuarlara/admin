<?php
    require_once("../../sesion.php");

	$idPagina = 159;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
		$conexionBdComercial->query("DELETE FROM comercial_ofertas WHERE ofer_id='" . $_GET["id"] . "'");
		$conexionBdComercial->query("DELETE FROM comercial_ofertas_productos WHERE cop_id_oferta='" . $_GET["id"] . "'");
	} catch (Exception $e) {
	include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="../bd_read/ofertas.php?success=SC_2";</script>';
	exit();