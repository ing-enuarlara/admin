<?php
    require_once("../../sesion.php");

	$idPagina = 47;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    $autoId=($_GET["id"] - 1);
	$conexionBdAdministrativo->query("DELETE FROM administrativo_roles WHERE utipo_id='" . $_GET["id"] . "'");
	$conexionBdAdministrativo->query("ALTER TABLE administrativo_roles AUTO_INCREMENT = " . $autoId);

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
	exit();