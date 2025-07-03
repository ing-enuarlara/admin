<?php
require_once("../../sesion.php");

$idPagina = 25;
include(RUTA_PROYECTO . "includes/verificar-paginas.php");
require_once(RUTA_PROYECTO . 'class/Productos_Especificaciones.php');
require_once(RUTA_PROYECTO . 'class/Productos_Tallas.php');

try {
	$conexionBdComercial->query("DELETE FROM comercial_productos WHERE cprod_id='" . $_GET["id"] . "'");
	$conexionBdComercial->query("DELETE FROM comercial_productos_fotos WHERE cpf_id_producto='" . $_GET["id"] . "' AND cpf_fotos_prin = 'NO'");
	Productos_Especificaciones::Delete(
		[
			'cpt_id_producto' => $_GET["id"],
			'cpt_tech_prin' => NO
		]
	);
	Productos_Tallas::Delete(
		[
			'cpta_producto' => $_GET["id"],
			'cpta_prin' => NO
		]
	);
} catch (Exception $e) {
	include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
}

include(RUTA_PROYECTO . "includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
exit();
