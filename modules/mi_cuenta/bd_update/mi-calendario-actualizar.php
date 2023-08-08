<?php 
    require_once("../../sesion.php");

    $idPagina = 118;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        mysqli_query($conexionBdMicuenta,"UPDATE micuenta_agenda SET 
        age_evento      ='" . $_POST["asunto"] . "', 
        age_fecha       ='" . $_POST["fechaEvento"] . "', 
        age_lugar       ='" . $_POST["lugarEvento"] . "', 
        age_notas       ='" . $_POST["observacion"] . "', 
        age_inicio      ='" . $_POST["horaInicio"] . "', 
        age_fin         ='" . $_POST["horaFin"] . "', 
        age_color       ='" . $_POST["colorEvento"] . "', 
        age_todo_dia    ='" . $_POST["todoDia"] . "', 
        age_enlace      ='" . $_POST["enlaceEvento"] . "' 
        WHERE age_id='" . $_POST["id"] . "'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

	if(!empty($_POST["usuarios"])){
		try{
            $consulta = mysqli_query($conexionBdMicuenta, "SELECT * FROM micuenta_agenda_usuarios WHERE agus_id_agenda='" . $_POST["id"] . "' AND agus_id_usuario!='" . $_SESSION["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
		$idUsuariosConsulta = array();
		foreach ($consulta as $subarreglo) {
			$idUsuariosConsulta[] = $subarreglo['agus_id_usuario'];
		}

		//Notificamos a los usuarios que ya estan registrados en el evento
		$resultadoNotificar= array_intersect($_POST["usuarios"],$idUsuariosConsulta);
		if($resultadoNotificar){

            $operacion=1;
            $texto="Te notificamos que <b>".$datosUsuarioActual['usr_nombre']."</b> a modificado un evento al que estas invitado. A continuación los nuevos detalles:";
            $duracion="<b>Hora inicio:</b>".$_POST['horaInicio']."<br><b>Hora fin:</b>".$_POST["horaFin"]."<br>";
            if($_POST["todoDia"]==1){
                $duracion="<b>Duración:</b> Todo el dia<br>";
            }
            $asuntoEvento="EVENTO MODIFICADO";
            $estado=1;
			foreach ($resultadoNotificar as $idUsuariosNotificar) {
                $idUsuarioEvento=$idUsuariosNotificar;
                include(RUTA_PROYECTO."enviar-correos/eventos-enviar-correo.php");
			}
		}

		//Agregamos los usuarios que no esten en registrados en la BD
		$resultadoAgregar= array_diff($_POST["usuarios"],$idUsuariosConsulta);
		if($resultadoAgregar){

            $operacion=1;
            $texto="Te notificamos que <b>".$datosUsuarioActual['usr_nombre']."</b> te está haciendo una invitación para un evento. A continuación los detalles:";
            $duracion="<b>Hora inicio:</b>".$_POST['horaInicio']."<br><b>Hora fin:</b>".$_POST["horaFin"]."<br>";
            if($_POST["todoDia"]==1){
                $duracion="<b>Duración:</b> Todo el dia<br>";
            }
            $asuntoEvento="INVITACIÓN A EVENTO";
            $estado=1;
			foreach ($resultadoAgregar as $idUsuariosGuardar) {
				try{
                    mysqli_query($conexionBdMicuenta, "INSERT INTO micuenta_agenda_usuarios(agus_id_usuario, agus_id_agenda, agus_creador) VALUE ('" . $idUsuariosGuardar . "','" . $_POST["id"] . "',0)");
				} catch (Exception $e) {
                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
				}

                $idUsuarioEvento=$idUsuariosGuardar;
                include(RUTA_PROYECTO."enviar-correos/eventos-enviar-correo.php");
			}
		}

		//Eliminamos los usuarios que ya no vayan a estar invitados
		$resultadoEliminar= array_diff($idUsuariosConsulta,$_POST["usuarios"]);
		if($resultadoEliminar){

            $operacion=1;
            $texto="Te notificamos que <b>".$datosUsuarioActual['usr_nombre']."</b> a cancelado tu invitación al evento <b>".$_POST["asunto"]."</b>";
            $duracion="";
            $asuntoEvento="CANCELACIÓN DE EVENTO";
            $estado=0;
			foreach ($resultadoEliminar as $idUsuariosEliminar) {
				try{
					mysqli_query($conexionBdMicuenta,"DELETE FROM micuenta_agenda_usuarios WHERE agus_id_usuario='" . $idUsuariosEliminar . "' AND agus_id_agenda='" . $_POST["id"] . "'");
				} catch (Exception $e) {
                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
				}

                $idUsuarioEvento=$idUsuariosEliminar;
                include(RUTA_PROYECTO."enviar-correos/eventos-enviar-correo.php");
			}
		}

	}else{

        $operacion=2;
        $tipoOpcion=0;
        $asuntoEvento="CANCELACIÓN DE EVENTO";
        $estado=0;
        include(RUTA_PROYECTO."enviar-correos/eventos-enviar-correo.php");

		try{
            mysqli_query($conexionBdMicuenta,"DELETE FROM micuenta_agenda_usuarios WHERE agus_id_agenda='" . $_POST["id"] . "' AND agus_id_usuario!='" . $_SESSION["id"] . "'");
		} catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
		}
	}

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/mi-calendario.php?success=SC_7";</script>';
    exit();