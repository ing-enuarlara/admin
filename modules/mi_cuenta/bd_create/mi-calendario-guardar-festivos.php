<?php
    require_once("../../sesion.php");

	$idPagina = 120;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	try{
		mysqli_query($conexionBdMicuenta,"DELETE FROM micuenta_agenda_festivos");
		mysqli_query($conexionBdMicuenta,"ALTER TABLE micuenta_agenda_festivos AUTO_INCREMENT=1;");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}

	$service_url = 'https://api.generadordni.es/v2/holidays/holidays?country=CO&year='.date("Y");
	$jsonObject = json_decode(file_get_contents($service_url), true);
	foreach ($jsonObject as $object) {
		$nombreFestivo = $object["name"];
		$diaFestivo = $object["date"];
		$d=date("d", strtotime($diaFestivo));
		$m=date("m", strtotime($diaFestivo));
		$y=date("Y", strtotime($diaFestivo));

		try{
			mysqli_query($conexionBdMicuenta, "INSERT INTO micuenta_agenda_festivos(agefes_nombre,agefes_years,agefes_mes,agefes_dia) VALUE ('" . $nombreFestivo . "','" . $y . "','" . $m . "','" . $d . "')");
		} catch (Exception $e) {
			include(RUTA_PROYECTO."includes/error-catch-to-report.php");
		}
	}

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="../bd_read/mi-calendario.php?success=SC_9";</script>';
	exit();