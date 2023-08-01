<?php
    require_once("../../sesion.php");

    $idPagina = 110;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
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
    
	if ($_FILES['ftPerfil']['name'] != "") {
		$destino = RUTA_PROYECTO."files/perfil";
		$fileName = subirArchivosAlServidor($_FILES['ftPerfil'], 'ftp', $destino);

        $conexionBdAdministrativo->query("UPDATE administrativo_usuarios SET usr_foto= '" . $fileName . "' WHERE usr_id='" . $_POST["id"] . "'");
	}

    if (!empty($_POST["usuario"]) && !empty($_POST["cambiarUser"])) {

        $usuario= $conexionBdAdministrativo->query("SELECT usr_login FROM administrativo_usuarios WHERE usr_login='" . $_POST["usuario"] . "' AND usr_id!='" . $_POST["id"] . "'");
        $numUss= $usuario->num_rows;
        if($numUss>0){
            echo '<script type="text/javascript">window.location.href="../bd_read/perfil-editar.php?error=ER_3";</script>';
            exit();
        }

        $conexionBdAdministrativo->query("UPDATE administrativo_usuarios SET usr_login='" . $_POST["usuario"] . "' WHERE usr_id='" . $_POST["id"] . "'");
    
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/perfil-editar.php?success=SC_3";</script>';
    exit();