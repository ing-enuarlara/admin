<?php
    require_once("../../sesion.php");

    $idPagina = 112;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    if ($datosUsuarioActual['usr_clave'] != SHA1($_POST['claveActual'])) {
        echo '<script type="text/javascript">window.location.href="../bd_read/clave-editar.php?error=ER_4";</script>';
        exit();
    }

    if(!validarClave($_POST["claveNueva"])){
        echo '<script type="text/javascript">window.location.href="../bd_read/clave-editar.php?error=ER_2";</script>';
        exit();
    }
    
    if ($_POST['claveNueva'] != $_POST['confirmarClaveNueva']) {
        echo '<script type="text/javascript">window.location.href="../bd_read/clave-editar.php?error=ER_5";</script>';
        exit();
    }

    $conexionBdAdministrativo->query("UPDATE administrativo_usuarios SET usr_clave=SHA1('" . $_POST["claveNueva"] . "') WHERE usr_id='" . $_POST["id"] . "'");

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/clave-editar.php?success=SC_4";</script>';
    exit();