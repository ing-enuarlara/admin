<?php
    require_once("../../sesion.php");

    $idPagina = 17;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    $conexionBdAdministrativo->query("INSERT INTO administrativo_usuarios (usr_login, usr_clave, usr_tipo, usr_nombre, usr_email, usr_telefono)VALUES('" . $_POST["cedula"] . "', SHA1(12345678), 2, '" . $_POST["contacto"] . "', '" . $_POST["email"] . "', '" . $_POST["telefono"] . "')");
    $idUsuario = mysqli_insert_id($conexionBdAdministrativo);
    
    $conexionBdAdmin->query("INSERT INTO clientes_admin (cliAdmi_nombre, cliAdmi_email, cliAdmi_telefono, cliAdmi_contacto_principal, cliAdmi_fecha_inicio, cliAdmi_fecha_fin, cliAdmi_aviso_previo, cliAdmi_documento, cliAdmi_id_uss_principal)VALUES('" . $_POST["nombre"] . "', '" . $_POST["email"] . "', '" . $_POST["telefono"] . "', '" . $_POST["contacto"] . "', '" . $_POST["fechaIni"] . "', '" . $_POST["fechaFin"] . "', '" . $_POST["aviPrev"] . "', '" . $_POST["cedula"] . "', '" . $idUsuario . "')");
    $idInsert = mysqli_insert_id($conexionBdAdmin);
    
    $conexionBdAdministrativo->query("UPDATE administrativo_usuarios SET usr_id_empresa='" . $idInsert . "' WHERE usr_id='" . $idUsuario . "'");

    if(isset($_POST["modulo"])){
        $numero = (count($_POST["modulo"]));
        if ($numero > 0) {
            $contador = 0;
            while ($contador < $numero) {
        
                $conexionBdAdmin->query("INSERT INTO modulos_clien_admin(mxca_id_modulo, mxca_id_cliAdmin)VALUES('" . $_POST["modulo"][$contador] . "','" . $idInsert . "')");
        
                $contador++;
            }
        }
    }

    $conexionBdGeneral->query("INSERT INTO configuracion (conf_empresa, conf_email, conf_telefono, conf_id_empresa)VALUES('" . $_POST["nombre"] . "', '" . $_POST["email"] . "', '" . $_POST["telefono"] . "', '" . $idInsert . "')");

    $conexionBdPaginaWeb->query("INSERT INTO configuracion (conf_empresa, conf_email, conf_telefono, conf_id_empresa)VALUES('" . $_POST["nombre"] . "', '" . $_POST["email"] . "', '" . $_POST["telefono"] . "', '" . $idInsert . "')");

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/clientes-admin-editar.php?id=' . $idInsert . '";</script>';
    exit();