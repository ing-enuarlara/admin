<?php 
    require_once("../../sesion.php");
    require_once(RUTA_PROYECTO."enviar-correos/EnviarEmail.php");

    $idPagina = 126;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    $adjunto = "";
	if ($_FILES['adjunto']['name'] != "") {
		$destino = RUTA_PROYECTO."files/mensajes";
		$adjunto = subirArchivosAlServidor($_FILES['adjunto'], 'men', $destino);
	}

    if(!empty($_POST['para'])){
        $numero = (count($_POST["para"]));

        $contador = 0;
        while ($contador < $numero):
            try{
                mysqli_query($conexionBdMicuenta, "INSERT INTO micuenta_mensajes(men_de, men_para, men_asunto, men_contenido, men_id_empresa, men_adjunto) VALUE ('" . $_SESSION['id'] . "','" . $_POST["para"][$contador] . "','" . $_POST["asunto"] . "','" . $_POST["contenido"] . "','" . $datosUsuarioActual['usr_id_empresa'] . "','" . $adjunto . "')");
            } catch (Exception $e) {
                include(RUTA_PROYECTO."includes/error-catch-to-report.php");
            }

            if($_POST["correo"]==1){
                try{
                    $consulta= $conexionBdAdministrativo->query("SELECT * FROM administrativo_usuarios WHERE usr_id='" . $_POST["para"][$contador] . "'");
                } catch (Exception $e) {
                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                }
                
                $resultado = mysqli_fetch_array($consulta, MYSQLI_BOTH);
                
                if(!empty($resultado)){
                
                    $data = [
                        'usuario_email'         => $resultado['usr_email'],
                        'usuario_nombre'        => $resultado['usr_nombre'],
                        'remitente_nombre'      => $datosUsuarioActual['usr_nombre'],
                        'mensaje_contenido'     => $_POST['contenido'],
                        'mensaje_adjunto'       => $adjunto,
                        'id_empresa'            => $datosUsuarioActual["usr_id_empresa"]
                    ];
                    $asunto = $_POST['asunto'];
                    $bodyTemplateRoute = RUTA_PROYECTO.'enviar-correos/template-enviar-mensajes.php';
                
                    EnviarEmail::enviar($data, $asunto, $bodyTemplateRoute);
                
                }
            }
            
            $contador++;
        endwhile;
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/mailbox.php?success=SC_10";</script>';
    exit();