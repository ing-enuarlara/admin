<?php
    require_once("../../sesion.php");

    $idPagina = 44;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");
    
    try{
        $conexionBdAdministrativo->query("INSERT INTO administrativo_roles(utipo_nombre,utipo_id_empresa)VALUES('" . $_POST["nombre"] . "','" . $_SESSION["idEmpresa"] . "')");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    $idInsertU = mysqli_insert_id($conexionBdAdministrativo);

    if(!empty($_POST["modulo"])){
        $numero = (count($_POST["modulo"]));
        $contador = 0;
        while ($contador < $numero) {

            try{
                $conexionBdAdministrativo->query("INSERT INTO administrativo_permisos_rol(perol_id_entidad, perol_id_rol)VALUES('" . $_POST["modulo"][$contador] . "','" . $idInsertU . "')");
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
                    $conexionBdAdministrativo->query("INSERT INTO administrativo_permisos_rol(perol_id_entidad, perol_id_rol)VALUES('" . $_POST["subModulos"][$contador] . "','" . $idInsertU . "')");
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
                        $conexionBdAdministrativo->query("INSERT INTO administrativo_permisos_rol(perol_id_entidad, perol_id_rol)VALUES('" . $_POST["itemSubModulos"][$contador] . "','" . $idInsertU . "')");
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
                    $conexionBdAdministrativo->query("INSERT INTO administrativo_permisos_rol(perol_id_entidad, perol_id_rol, perol_tipo)VALUES('" . $_POST["paginas"][$contador] . "','" . $idInsertU . "','PAG')");
                } catch (Exception $e) {
                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                }
                
                $contador++;
            }
        }
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/roles-editar.php?id=' . $idInsertU . '";</script>';
    exit();