<?php
require_once("../../sesion.php");
require_once(RUTA_PROYECTO . 'class/Productos_Fotos.php');

$idPagina = 168;
include(RUTA_PROYECTO . "includes/verificar-paginas.php");

try {
	Productos_Fotos::Delete(['cpf_id' => $_GET["idPf"]]);
} catch (Exception $e) {
	include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
}

include(RUTA_PROYECTO . "includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="../bd_read/catalogo-principal-fotos.php?id=' . $_GET['id'] . '&success=SC_2";</script>';
exit();
