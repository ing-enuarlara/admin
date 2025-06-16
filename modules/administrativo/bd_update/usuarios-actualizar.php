<?php
    require_once("../../sesion.php");

    $idPagina = 68;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    try{
        $conexionBdAdministrativo->query("UPDATE administrativo_usuarios SET 
        usr_tipo='" . $_POST["ussTipo"] . "', 
        usr_nombre='" . $_POST["nombre"] . "', 
        usr_documento='" . $_POST["documento"] . "', 
        usr_email='" . $_POST["email"] . "', 
        usr_telefono='" . $_POST["celular"] . "', 
        usr_direccion='" . $_POST["direccion"] . "', 
        usr_ciudad='" . $_POST["ciudad"] . "', 
        usr_ocupacion='" . $_POST["ocupacion"] . "', 
        usr_genero='" . $_POST["genero"] . "', 
        usr_intentos_fallidos='" . $_POST["fallidos"] . "'
        
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

    if (!empty($_POST["usuario"]) && $_POST["cambiarUser"] == 1) {

        try{
            $conexionBdAdministrativo->query("UPDATE administrativo_usuarios SET usr_login='" . $_POST["usuario"] . "' WHERE usr_id='" . $_POST["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
    
    }

    if (!empty($_POST["clave"]) && $_POST["cambiarClave"] == 1) {
    
        $validarClave=validarClave($_POST["clave"]);
        if($validarClave!=true){
            echo '<script type="text/javascript">window.location.href="../bd_read/usuarios-editar.php?error=ER_2";</script>';
            exit();
        }

        try{
            $conexionBdAdministrativo->query("UPDATE administrativo_usuarios SET usr_clave= SHA1('" . $_POST["clave"] . "') WHERE usr_id='" . $_POST["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
    
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/usuarios.php";</script>';
    exit();