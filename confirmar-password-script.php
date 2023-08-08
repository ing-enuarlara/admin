<?php
    include("conexion.php");
    require_once(RUTA_PROYECTO."includes/funciones-para-el-sistema.php");

    if(!validarClave($_POST["claveNueva"])){
        echo '<script type="text/javascript">window.location.href="confirmar-password.php?error=1&idU='.base64_encode($_POST["idUsuario"]).'&idE='.base64_encode($_POST["idEmpresa"]).'";</script>';
        exit();
    }
    
    if ($_POST['claveNueva'] != $_POST['confirmarClaveNueva']) {
        echo '<script type="text/javascript">window.location.href="confirmar-password.php?error=2&idU='.base64_encode($_POST["idUsuario"]).'&idE='.base64_encode($_POST["idEmpresa"]).'";</script>';
        exit();
    }

    try{
        $conexionBdAdministrativo->query("UPDATE administrativo_usuarios SET usr_clave=SHA1('" . $_POST["claveNueva"] . "') WHERE usr_id='" . $_POST["idUsuario"] . "' AND usr_id_empresa='" . $_POST["idEmpresa"] . "'");
    } catch (Exception $e) {
        echo "Excepción catpurada: ".$e->getMessage();
        exit();
    }

    echo '<script type="text/javascript">window.location.href="index.php?RC=2";</script>';
    exit();