<?php
$tiempo_final = microtime(true);
$tiempo = $tiempo_final - $tiempo_inicial;
$tiempoMostrar = round($tiempo,3);

if(isset($_SERVER['HTTP_REFERER'])) {
	try{
		$conexionBdAdmin->query("INSERT INTO historial_acciones(hil_usuario, hil_url, hil_id_pagina, hil_fecha, hil_pagina_anterior, hil_empresa, hil_tiempo_carga)VALUES('" . $_SESSION["id"] . "', '" . $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] . "', '" . $idPagina . "', now(),'" . $_SERVER['HTTP_REFERER'] . "', '".$_SESSION["idEmpresa"]."', '".$tiempoMostrar."')");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}
}else{
	try{
		$conexionBdAdmin->query("INSERT INTO historial_acciones(hil_usuario, hil_url, hil_id_pagina, hil_fecha, hil_pagina_anterior, hil_empresa, hil_tiempo_carga)VALUES('" . $_SESSION["id"] . "', '" . $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] . "', '" . $idPagina . "', now(),'Sin referencia', '".$_SESSION["idEmpresa"]."', '".$tiempoMostrar."')");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}
}