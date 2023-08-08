<?php
    require_once("../../sesion.php");

	$idPagina = 119;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	$operacion=2;
	$tipoOpcion=1;
	$asuntoEvento="CANCELACIÓN DE EVENTO";
	$estado=0;
	include(RUTA_PROYECTO."enviar-correos/eventos-enviar-correo.php");

	try{
		mysqli_query($conexionBdMicuenta,"DELETE FROM micuenta_agenda WHERE age_id='" . $_GET["id"] . "'");
		mysqli_query($conexionBdMicuenta,"DELETE FROM micuenta_agenda_usuarios WHERE agus_id_agenda='" . $_GET["id"] . "'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="../bd_read/mi-calendario.php?success=SC_8";</script>';
	exit();