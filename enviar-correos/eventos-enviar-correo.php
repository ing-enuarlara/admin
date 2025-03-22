<?php
require_once(RUTA_PROYECTO."enviar-correos/EnviarEmail.php");

//PARA USUARIOS CUANDO YA SE TIENE SU ID
if($operacion==1){
	try{
		$consulta= $conexionBdAdministrativo->query("SELECT * FROM administrativo_usuarios WHERE usr_id='" . $idUsuarioEvento . "'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}
	$resultado = mysqli_fetch_array($consulta, MYSQLI_BOTH);

	if(!empty($resultado)){

		$data = [
			'usuario_email'		=> $resultado['usr_email'],
			'usuario_nombre'	=> $resultado['usr_nombre'],
			'evento_texto'		=> $texto,
			'evento_nombre'		=> $_POST["asunto"],
			'evento_fecha'		=> $_POST["fechaEvento"],
			'evento_lugar'		=> $_POST["lugarEvento"],
			'evento_duracion'	=> $duracion,
			'evento_nota'		=> $_POST["observacion"],
			'evento_enlace'		=> $_POST["enlaceEvento"],
			'evento_estado'		=> $estado,
			'id_empresa'            => $_SESSION["datosUsuarioActual"]["usr_id_empresa"]
		];
		$asunto = $asuntoEvento;
		$bodyTemplateRoute = RUTA_PROYECTO.'enviar-correos/template-enviar-eventos.php';

		EnviarEmail::enviar($data, $asunto, $bodyTemplateRoute);

	}
}

//PARA NOTIFICAR A USUARIOS CUANDO NO SE TIENE SU ID
if($operacion==2){
	try{
		$agendaUsuarios = mysqli_query($conexionBdMicuenta, "SELECT * FROM micuenta_agenda_usuarios 
		INNER JOIN micuenta_agenda ON age_id=agus_id_agenda 
		WHERE agus_id_agenda='" . $_REQUEST["id"] . "' AND agus_id_usuario!='" . $_SESSION["id"] . "'");

	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}
	$numAgenda=mysqli_num_rows($agendaUsuarios);

	if($numAgenda>0){
		while($resultadoAgenda=mysqli_fetch_array($agendaUsuarios, MYSQLI_BOTH)){

            $duracion="<b>Hora inicio:</b>".$resultadoAgenda['age_inicio']."<br><b>Hora fin:</b>".$resultadoAgenda["age_fin"]."<br>";
            if($resultadoAgenda["age_todo_dia"]==1){
                $duracion="<b>Duración:</b> Todo el dia<br>";
            }
			switch($tipoOpcion){
				case 0:
					$texto="Te notificamos que <b>".$_SESSION["datosUsuarioActual"]['usr_nombre']."</b> a cancelado tu invitación al evento <b>".$resultadoAgenda["age_evento"]."</b>";
				break;
				
				case 1:
					$texto="Te notificamos que <b>".$_SESSION["datosUsuarioActual"]['usr_nombre']."</b> a cancelado el evento <b>".$resultadoAgenda["age_evento"]."</b> al que estabas invitado.";
				break;
			}

			try{
				$consulta= $conexionBdAdministrativo->query("SELECT * FROM administrativo_usuarios WHERE usr_id='" . $resultadoAgenda['agus_id_usuario'] . "'");
			} catch (Exception $e) {
				include(RUTA_PROYECTO."includes/error-catch-to-report.php");
			}
			$resultado = mysqli_fetch_array($consulta, MYSQLI_BOTH);

			if(!empty($resultado)){

				$data = [
					'usuario_email'		=> $resultado['usr_email'],
					'usuario_nombre'	=> $resultado['usr_nombre'],
					'evento_texto'		=> $texto,
					'evento_nombre'		=> $resultadoAgenda["age_evento"],
					'evento_fecha'		=> $resultadoAgenda["age_fecha"],
					'evento_lugar'		=> $resultadoAgenda["age_lugar"],
					'evento_duracion'	=> $duracion,
					'evento_nota'		=> $resultadoAgenda["age_notas"],
					'evento_enlace'		=> $resultadoAgenda["age_enlace"],
					'evento_estado'		=> $estado,
					'id_empresa'            => $_SESSION["datosUsuarioActual"]["usr_id_empresa"]
				];
				$asunto = $asuntoEvento;
				$bodyTemplateRoute = RUTA_PROYECTO.'enviar-correos/template-enviar-eventos.php';

				EnviarEmail::enviar($data, $asunto, $bodyTemplateRoute);

			}
		}
	}
}