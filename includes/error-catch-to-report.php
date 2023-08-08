<?php
$numError     = $e->getCode();
$lineaError   = $e->getLine();
$aRemplezar   = array("'", '"', "#", "´");
$enRemplezo   = array("\'", "|", "\#", "\´");
$detalleError = str_replace($aRemplezar, $enRemplezo, $e->getMessage());
$request_data = json_encode($_REQUEST);
$request_data_sanitizado = mysqli_real_escape_string($conexionBdAdmin, $request_data);
$year=date("Y");
$idEmpresa=0;
if(!empty($configuracion['conf_id_empresa'])){
	$idEmpresa=$configuracion['conf_id_empresa'];
}

try {
	mysqli_query($conexionBdAdmin, "INSERT INTO reporte_errores(rperr_numero, rperr_fecha, rperr_ip, rperr_usuario, rperr_pagina_referencia, rperr_pagina_actual, rperr_so, rperr_linea, rperr_id_empresa, rperr_error, rerr_request, rperr_year)
	VALUES('".$numError."', now(), '".$_SERVER["REMOTE_ADDR"]."', '".$_SESSION["id"]."', '".$_SERVER['HTTP_REFERER']."', '".$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']."', '".$_SERVER['HTTP_USER_AGENT']."', '".$lineaError."', '".$idEmpresa."','".$detalleError."', '".$request_data_sanitizado."', '".$year."')");
	$idReporteError = mysqli_insert_id($conexionBdAdmin);
} catch (Exception $e) {
	echo "Hay un inconveniente al guardar el error: ".$e->getMessage();
	exit();
}

?>
	<div style="font-family: Consolas; padding: 10px; background-color: black; color:greenyellow;">
		<strong>ERROR DE EJECUCIÓN</strong><br>
		Lo sentimos, ha ocurrido un error.<br>
		Pero no se preocupe, hemos reportado este error automáticamente al personal de soporte de la plataforma SINTIA para que lo solucione lo antes posible.<br>
		
		<p>
			Si necesita ayuda urgente, comuniquese con el personal encargado de la plataforma y reporte los siguientes datos:<br>
			<b>ID del reporte del error:</b> <?=$idReporteError;?>.<br>
			<b>Número del error:</b> <?=$numError;?>.
		</p>
		
		<p>
			<a href="javascript:history.go(-1);" style="color: yellow;">Regresar a la página anterior</a>
		</p>
	</div>
<?php
exit();
