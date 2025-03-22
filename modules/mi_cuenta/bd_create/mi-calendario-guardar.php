<?php 
    require_once("../../sesion.php");

    $idPagina = 116;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        mysqli_query($conexionBdMicuenta, "INSERT INTO micuenta_agenda(age_evento, age_fecha, age_inicio, age_fin, age_lugar, age_notas, age_color, age_id_empresa, age_todo_dia, age_enlace) VALUE ('" . $_POST["asunto"] . "','" . $_POST["fechaEvento"] . "','" . $_POST["horaInicio"] . "','" . $_POST["horaFin"] . "','" . $_POST["lugarEvento"] . "','" . $_POST["observacion"] . "','" . $_POST["colorEvento"] . "','" . $_SESSION["idEmpresa"] . "','" . $_POST["todoDia"] . "','" . $_POST["enlaceEvento"] . "')");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }
    $idInsertU = mysqli_insert_id($conexionBdMicuenta);

	$sql="INSERT INTO micuenta_agenda_usuarios(agus_id_usuario, agus_id_agenda, agus_creador) VALUE ('" . $_SESSION["id"] . "', '" . $idInsertU . "', 1),";

    if(!empty($_POST['usuarios'])){
        $numero = (count($_POST["usuarios"]));

        $operacion=1;
        $texto="Te notificamos que <b>".$_SESSION["datosUsuarioActual"]['usr_nombre']."</b> te está haciendo una invitación para un evento. A continuación los detalles:";
        $duracion="<b>Hora inicio:</b>".$_POST['horaInicio']."<br><b>Hora fin:</b>".$_POST["horaFin"]."<br>";
        if($_POST["todoDia"]==1){
            $duracion="<b>Duración:</b> Todo el dia<br>";
        }
        $asuntoEvento="INVITACIÓN A EVENTO";
        $estado=1;
        $contador = 0;
        while ($contador < $numero):
            $sql.="('" . $_POST["usuarios"][$contador] . "','" . $idInsertU . "',0),";
            
            $idUsuarioEvento=$_POST["usuarios"][$contador];
            include(RUTA_PROYECTO."enviar-correos/eventos-enviar-correo.php");
            $contador++;
        endwhile;
    }

    $sql = substr($sql,0,-1);

    try{
        mysqli_query($conexionBdMicuenta, $sql);
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/mi-calendario.php?success=SC_6";</script>';
    exit();