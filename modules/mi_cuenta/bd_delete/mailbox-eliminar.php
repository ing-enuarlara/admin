<?php
    require_once("../../sesion.php");

	$idPagina = 127;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	if($_REQUEST["operacion"]==1){
		$values = json_decode($_REQUEST["values"]);
		$counValues=(count($values));

		$contador = 0;
		while ($contador < $counValues):

			try{
				mysqli_query($conexionBdMicuenta, "UPDATE micuenta_mensajes SET men_eliminado_para=1 WHERE men_id ='".$values[$contador]."'");
			} catch (Exception $e) {
				include(RUTA_PROYECTO."includes/error-catch-to-report.php");
			}

			$contador++;
		endwhile;

		include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");
	}

	if($_REQUEST["operacion"]==2){
		$values = json_decode($_REQUEST["values"]);
		$counValues=(count($values));

		$contador = 0;
		while ($contador < $counValues):

			try{
				mysqli_query($conexionBdMicuenta, "UPDATE micuenta_mensajes SET men_eliminado_de=1 WHERE men_id ='".$values[$contador]."'");
			} catch (Exception $e) {
				include(RUTA_PROYECTO."includes/error-catch-to-report.php");
			}

			$contador++;
		endwhile;
		
		include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");
	}

	// if($_REQUEST["operacion"]==3){
	// 	$values = json_decode($_REQUEST["values"]);
	// 	$counValues=(count($values));

	// 	$contador = 0;
	// 	while ($contador < $counValues):

	// 		try{
	// 			mysqli_query($conexionBdMicuenta, "DELETE FROM micuenta_mensajes WHERE men_id ='".$values[$contador]."'");
	// 		} catch (Exception $e) {
	// 			include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	// 		}

	// 		$contador++;
	// 	endwhile;
		
	// 	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");
	// }

	if($_REQUEST["operacion"]==4){
		if($_REQUEST["opc"]==1){
			try{
				mysqli_query($conexionBdMicuenta, "UPDATE micuenta_mensajes SET men_eliminado_de=1 WHERE men_id ='".$_REQUEST["id"]."'");
			} catch (Exception $e) {
				include(RUTA_PROYECTO."includes/error-catch-to-report.php");
			}
		}
		
		if($_REQUEST["opc"]==2){
			try{
				mysqli_query($conexionBdMicuenta, "UPDATE micuenta_mensajes SET men_eliminado_para=1 WHERE men_id ='".$_REQUEST["id"]."'");
			} catch (Exception $e) {
				include(RUTA_PROYECTO."includes/error-catch-to-report.php");
			}
		}
		
		// if($_REQUEST["opc"]==3){
		// 	try{
		// 		mysqli_query($conexionBdMicuenta, "DELETE FROM micuenta_mensajes WHERE men_id ='".$_REQUEST["id"]."'");
		// 	} catch (Exception $e) {
		// 		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
		// 	}
		// }

		include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

		echo '<script type="text/javascript">window.location.href="../bd_read/mailbox.php?success=SC_2";</script>';
		exit();
	}
?>
	<div class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h5><i class="icon fas fa-check"></i> Alert!</h5>
		Mensaje eliminado correctamente, la pagina se actualizara en un instante.
	</div>
<?php
	exit();