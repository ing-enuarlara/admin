<?php
    require_once("../../sesion.php");

    $idPagina = 110;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    try{
        $conexionBdAdministrativo->query("UPDATE administrativo_usuarios SET 
        usr_nombre='" . $_POST["nombre"] . "', 
        usr_documento='" . $_POST["documento"] . "', 
        usr_email='" . $_POST["email"] . "', 
        usr_telefono='" . $_POST["celular"] . "', 
        usr_direccion='" . $_POST["direccion"] . "', 
        usr_ciudad='" . $_POST["ciudad"] . "', 
        usr_ocupacion='" . $_POST["ocupacion"] . "', 
        usr_genero='" . $_POST["genero"] . "' 
        
        WHERE usr_id='" . $_POST["id"] . "'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }
    
	if ($_FILES['ftPerfil']['name'] != "") {
		$destino = RUTA_PROYECTO."files/perfil";
		$fileName = subirArchivosAlServidor($_FILES['ftPerfil'], 'ftp', $destino);

        try{
            $conexionBdAdministrativo->query("UPDATE administrativo_usuarios SET usr_foto= '" . $fileName . "' WHERE usr_id='" . $_POST["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
	}

    if (!empty($_POST["usuario"]) && !empty($_POST["cambiarUser"])) {

        try{
            $usuario= $conexionBdAdministrativo->query("SELECT usr_login FROM administrativo_usuarios WHERE usr_login='" . $_POST["usuario"] . "' AND usr_id!='" . $_POST["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
        $numUss= $usuario->num_rows;
        if($numUss>0){
            echo '<script type="text/javascript">window.location.href="../bd_read/perfil-editar.php?error=ER_3";</script>';
            exit();
        }

        try{
            $conexionBdAdministrativo->query("UPDATE administrativo_usuarios SET usr_login='" . $_POST["usuario"] . "' WHERE usr_id='" . $_POST["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
    
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/perfil-editar.php?success=SC_3";</script>';
    exit();