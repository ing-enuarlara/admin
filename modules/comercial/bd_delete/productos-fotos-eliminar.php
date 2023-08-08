<?php
    require_once("../../sesion.php");

	$idPagina = 58;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
		$conexionBdComercial->query("DELETE FROM comercial_productos_fotos WHERE cpf_id='" . $_GET["idPf"] . "'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="../bd_read/productos-fotos.php?id='.$_GET['id'].'&success=SC_2";</script>';
	exit();