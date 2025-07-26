<?php
    require_once("../../sesion.php");

    $idPagina = 46;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    try{
        $conexionBdAdministrativo->query("UPDATE administrativo_roles SET utipo_nombre='" . $_POST["nombre"] . "' WHERE utipo_id='" . $_POST["id"] . "'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    if(!empty($_POST["modulo"])){
        try{
            $conexionBdAdministrativo->query("DELETE FROM administrativo_permisos_rol WHERE perol_id_rol='" . $_POST["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
    
        $numero = (count($_POST["modulo"]));
        $contador = 0;        
        while ($contador < $numero) {

            try{
                $conexionBdAdministrativo->query("INSERT INTO administrativo_permisos_rol(perol_id_entidad, perol_id_rol)VALUES('" . $_POST["modulo"][$contador] . "','" . $_POST["id"] . "')");
            } catch (Exception $e) {
                include(RUTA_PROYECTO."includes/error-catch-to-report.php");
            }
            
            $contador++;
        }

        if(!empty($_POST["subModulos"])){
            $numero = (count($_POST["subModulos"]));
            $contador = 0;        
            while ($contador < $numero) {

                try{
                    $conexionBdAdministrativo->query("INSERT INTO administrativo_permisos_rol(perol_id_entidad, perol_id_rol)VALUES('" . $_POST["subModulos"][$contador] . "','" . $_POST["id"] . "')");
                } catch (Exception $e) {
                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                }
                
                $contador++;
            }

            if(!empty($_POST["itemSubModulos"])){
                $numero = (count($_POST["itemSubModulos"]));
                $contador = 0;        
                while ($contador < $numero) {

                    try{
                        $conexionBdAdministrativo->query("INSERT INTO administrativo_permisos_rol(perol_id_entidad, perol_id_rol)VALUES('" . $_POST["itemSubModulos"][$contador] . "','" . $_POST["id"] . "')");
                    } catch (Exception $e) {
                        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                    }
                    
                    $contador++;
                }
            }
        }

        if(!empty($_POST["paginas"])){
            $numero = (count($_POST["paginas"]));
            $contador = 0;        
            while ($contador < $numero) {

                try{
                    $conexionBdAdministrativo->query("INSERT INTO administrativo_permisos_rol(perol_id_entidad, perol_id_rol, perol_tipo)VALUES('" . $_POST["paginas"][$contador] . "','" . $_POST["id"] . "','PAG')");
                } catch (Exception $e) {
                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                }
                
                $contador++;
            }
        }
    }else{
        try{
            $conexionBdAdministrativo->query("DELETE FROM administrativo_permisos_rol WHERE perol_id_rol='" . $_POST["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/roles.php";</script>';
    exit();