<?php
    require_once("../../sesion.php");

	$idPagina = 192;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
		$conexionBdComercial->query("UPDATE comercial_productos_fotos SET cpf_principal=0 WHERE cpf_id_producto='" . $_GET["id"] . "'");
		$conexionBdComercial->query("UPDATE comercial_productos_fotos SET cpf_principal=1 WHERE cpf_id='" . $_GET["idPf"] . "'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="../bd_read/productos-fotos.php?id='.$_GET['id'].'&success=SC_2";</script>';
	exit();