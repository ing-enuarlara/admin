<?php
    require_once("../../sesion.php");
require_once(RUTA_PROYECTO . 'class/Tipos_Catalogo_Principal.php');

	$idPagina = 189;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
		Tipos_Catalogo_Principal::Delete(
			[
				"ctipop_id" => $_GET["id"]
			]
		);
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
	exit();