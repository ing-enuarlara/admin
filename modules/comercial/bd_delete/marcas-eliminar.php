<?php
require_once("../../sesion.php");
require_once(RUTA_PROYECTO . 'class/SubCategorias.php');
require_once(RUTA_PROYECTO . 'class/Sub_Categorias.php');

$idPagina = 37;
include(RUTA_PROYECTO . "includes/verificar-paginas.php");

SubCategorias::Delete(["cmar_id" => $_GET["id"]]);
Sub_Categorias::Delete(
	[
		"subca_marca" => $_GET["id"],
		"subca_prin" => NO
	]
);

include(RUTA_PROYECTO . "includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
exit();
