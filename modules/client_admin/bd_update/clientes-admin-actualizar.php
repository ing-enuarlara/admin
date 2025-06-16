<?php
    require_once("../../sesion.php");

    $idPagina = 18;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        $conexionBdAdmin->query("UPDATE clientes_admin SET 
        cliAdmi_nombre='" . $_POST["nombre"] . "', 
        cliAdmi_email='" . $_POST["email"] . "', 
        cliAdmi_telefono='" . $_POST["telefono"] . "', 
        cliAdmi_contacto_principal='" . $_POST["contacto"] . "', 
        cliAdmi_fecha_inicio='" . $_POST["fechaIni"] . "', 
        cliAdmi_fecha_fin='" . $_POST["fechaFin"] . "', 
        cliAdmi_aviso_previo='" . $_POST["aviPrev"] . "' , 
        cliAdmi_documento='" . $_POST["cedula"] . "' 
        WHERE cliAdmi_id='" . $_POST["id"] . "'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    if(isset($_POST["modulo"])){
        try{
            $conexionBdAdmin->query("DELETE FROM modulos_clien_admin WHERE mxca_id_cliAdmin='" . $_POST["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
    
        $numero = (count($_POST["modulo"]));
        $contador = 0;        
        while ($contador < $numero) {

            try{
                $conexionBdAdmin->query("INSERT INTO modulos_clien_admin(mxca_id_modulo, mxca_id_cliAdmin)VALUES('" . $_POST["modulo"][$contador] . "','" . $_POST["id"] . "')");
            } catch (Exception $e) {
                include(RUTA_PROYECTO."includes/error-catch-to-report.php");
            }
            
            $contador++;
        }
    }else{
        try{
            $conexionBdAdmin->query("DELETE FROM modulos_clien_admin WHERE mxca_id_cliAdmin='" . $_POST["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
    }

    try{
        $conexionBdGeneral->query("UPDATE configuracion SET conf_empresa='" . $_POST["nombre"] . "', conf_email='" . $_POST["email"] . "', conf_telefono='" . $_POST["telefono"] . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    if($_POST["ussPrincipal"]!=1){

        try{
            $conexionBdAdministrativo->query("UPDATE administrativo_usuarios SET usr_nombre='" . $_POST["contacto"] . "', usr_email='" . $_POST["email"] . "', usr_telefono='" . $_POST["telefono"] . "' WHERE usr_id='" . $_POST["ussPrincipal"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/clientes-admin.php";</script>';
    exit();