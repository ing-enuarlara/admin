<?php
    require_once("../../sesion.php");

    $idPagina = 65;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    if(!validarClave($_POST["clave"])){
        echo '<script type="text/javascript">window.location.href="../bd_read/usuarios-agregar.php?error=ER_2";</script>';
        exit();
    }
    
    try{
        $conexionBdAdministrativo->query("INSERT INTO administrativo_usuarios(usr_login,usr_clave,usr_tipo,usr_nombre,usr_email,usr_ciudad,usr_telefono,usr_id_empresa,usr_estado,usr_documento)VALUES('" . $_POST["documento"] . "',SHA1('" . $_POST["clave"] . "'),'" . $_POST["ussTipo"] . "','" . $_POST["nombre"] . "','" . $_POST["email"] . "','" . $_POST["ciudad"] . "','" . $_POST["celular"] . "','" . $datosUsuarioActual['usr_id_empresa'] . "',0,'" . $_POST["documento"] . "')");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    $idInsertU = mysqli_insert_id($conexionBdAdministrativo);

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/usuarios-editar.php?id=' . $idInsertU . '";</script>';
    exit();