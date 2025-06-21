<?php
require_once("../../sesion.php");
require_once(RUTA_PROYECTO . 'class/Catalogo_Principal.php');
require_once(RUTA_PROYECTO . 'class/Productos_Fotos.php');
require_once(RUTA_PROYECTO . 'class/Productos_Especificaciones.php');

$idPagina = 165;
include(RUTA_PROYECTO . "includes/verificar-paginas.php");

try {
	Catalogo_Principal::Delete(['cprin_id' => $_GET["id"]]);
	Productos_Fotos::Delete(['cpf_id_producto' => $_GET["id"], 'cpt_fotos_prin' => SI]);
	Productos_Especificaciones::Delete(
		[
			'cpt_id_producto' => $_GET["id"],
			'cpt_tech_prin' => SI
		]
	);
} catch (Exception $e) {
	include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
}

include(RUTA_PROYECTO . "includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
exit();
