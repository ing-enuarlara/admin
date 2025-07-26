<?php
include("../modules/sesion.php");

if ( $_POST['opcion'] == 1 ) {
    if (!empty($_POST['modulos'])) {
        try{
            $consultaSubModulos = $conexionBdSistema->query("SELECT * FROM sistema_modulos WHERE mod_padre IN (".$_POST['modulos'].") AND mod_estado = 'ACTIVO'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }

        $numM = $consultaSubModulos->num_rows;
        if ($numM > 0) {
?>
            <script type="application/javascript">
                document.getElementById('mensajeM').style.display = "none";
                document.getElementById('subModulos-container').style.display = "block";
            </script>
<?php
            while($subModulos = mysqli_fetch_array($consultaSubModulos, MYSQLI_BOTH)){
                try{
                    $consultaModulos=$conexionBdAdmin->query("SELECT * FROM modulos_clien_admin WHERE mxca_id_cliAdmin='".$_POST['idEmpresa']."' AND mxca_id_modulo='".$subModulos['mod_id']."'");
                } catch (Exception $e) {
                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                }
                $numZ = $consultaModulos->num_rows;
                $selected = $numZ > 0 ? 'selected' : '';

                echo '<option value="' . $subModulos['mod_id'] . '" ' . $selected . '>' . $subModulos['mod_nombre'] . '</option>';
            }
            exit();
        } else {
?>
            <script type="application/javascript">
                document.getElementById('mensajeM').style.display = "none";
                document.getElementById('subModulos-container').style.display = "none";
                document.getElementById('subModulos').value = "0";
            </script>
<?php
        }
    } else {
?>
        <script type="application/javascript">
            document.getElementById('mensajeM').style.display = "none";
            document.getElementById('subModulos-container').style.display = "none";
            document.getElementById('subModulos').value = "0";
        </script>
<?php
    }
}

if ( $_POST['opcion'] == 2 ) {
    if (!empty($_POST['subModulos'])) {
        try{
            $consultaItemSubModulos = $conexionBdSistema->query("SELECT * FROM sistema_modulos WHERE mod_padre IN (".$_POST['subModulos'].") AND mod_estado = 'ACTIVO'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }

        $numSM = $consultaItemSubModulos->num_rows;
        if ($numSM > 0) {
?>
            <script type="application/javascript">
                document.getElementById('mensajeSM').style.display = "none";
                document.getElementById('itemSubModulos-container').style.display = "block";
            </script>
<?php
            while($itemSubModulos = mysqli_fetch_array($consultaItemSubModulos, MYSQLI_BOTH)){
                try{
                    $consultaModulos=$conexionBdAdmin->query("SELECT * FROM modulos_clien_admin WHERE mxca_id_cliAdmin='".$_POST['idEmpresa']."' AND mxca_id_modulo='".$itemSubModulos['mod_id']."'");
                } catch (Exception $e) {
                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                }
                $numZ = $consultaModulos->num_rows;
                $selected = $numZ > 0 ? 'selected' : '';

                echo '<option value="' . $itemSubModulos['mod_id'] . '" ' . $selected . '>' . $itemSubModulos['mod_nombre'] . '</option>';
            }
            exit();
        } else {
?>
            <script type="application/javascript">
                document.getElementById('mensajeSM').style.display = "none";
                document.getElementById('itemSubModulos-container').style.display = "none";
                document.getElementById('itemSubModulos').value = "0";
            </script>
<?php
        }
    } else {
?>
        <script type="application/javascript">
            document.getElementById('mensajeSM').style.display = "none";
            document.getElementById('itemSubModulos-container').style.display = "none";
            document.getElementById('itemSubModulos').value = "0";
        </script>
<?php
    }
}

if ( $_POST['opcion'] == 3 ) {
    if (!empty($_POST['modulos'])) {
        try{
            $consultaSubModulos = $conexionBdSistema->query("SELECT * FROM sistema_modulos WHERE mod_padre IN (".$_POST['modulos'].") AND mod_estado = 'ACTIVO'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }

        $numM = $consultaSubModulos->num_rows;
        if ($numM > 0) {
?>
            <script type="application/javascript">
                document.getElementById('mensajeM').style.display = "none";
                document.getElementById('subModulos-container').style.display = "block";
            </script>
<?php
            while($subModulos = mysqli_fetch_array($consultaSubModulos, MYSQLI_BOTH)){
                try{
                    $consultaModulos=$conexionBdAdministrativo->query("SELECT * FROM administrativo_permisos_rol WHERE perol_id_rol='".$_POST['idRol']."' AND perol_id_entidad='".$subModulos['mod_id']."' AND perol_tipo='MOD'");
                } catch (Exception $e) {
                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                }
                $numZ = $consultaModulos->num_rows;
                $selected = $numZ > 0 ? 'selected' : '';

                echo '<option value="' . $subModulos['mod_id'] . '" ' . $selected . '>' . $subModulos['mod_nombre'] . '</option>';
            }
            exit();
        } else {
?>
            <script type="application/javascript">
                document.getElementById('mensajeM').style.display = "none";
                document.getElementById('subModulos-container').style.display = "none";
                document.getElementById('subModulos').value = "0";
            </script>
<?php
        }
    } else {
?>
        <script type="application/javascript">
            document.getElementById('mensajeM').style.display = "none";
            document.getElementById('subModulos-container').style.display = "none";
            document.getElementById('subModulos').value = "0";
        </script>
<?php
    }
}

if ( $_POST['opcion'] == 4 ) {
    if (!empty($_POST['subModulos'])) {
        try{
            $consultaItemSubModulos = $conexionBdSistema->query("SELECT * FROM sistema_modulos WHERE mod_padre IN (".$_POST['subModulos'].") AND mod_estado = 'ACTIVO'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }

        $numSM = $consultaItemSubModulos->num_rows;
        if ($numSM > 0) {
?>
            <script type="application/javascript">
                document.getElementById('mensajeSM').style.display = "none";
                document.getElementById('itemSubModulos-container').style.display = "block";
            </script>
<?php
            while($itemSubModulos = mysqli_fetch_array($consultaItemSubModulos, MYSQLI_BOTH)){
                try{
                    $consultaModulos=$conexionBdAdministrativo->query("SELECT * FROM administrativo_permisos_rol WHERE perol_id_rol='".$_POST['idRol']."' AND perol_id_entidad='".$itemSubModulos['mod_id']."' AND perol_tipo='MOD'");
                } catch (Exception $e) {
                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                }
                $numZ = $consultaModulos->num_rows;
                $selected = $numZ > 0 ? 'selected' : '';

                echo '<option value="' . $itemSubModulos['mod_id'] . '" ' . $selected . '>' . $itemSubModulos['mod_nombre'] . '</option>';
            }
            exit();
        } else {
?>
            <script type="application/javascript">
                document.getElementById('mensajeSM').style.display = "none";
                document.getElementById('itemSubModulos-container').style.display = "none";
                document.getElementById('itemSubModulos').value = "0";
            </script>
<?php
        }
    } else {
?>
        <script type="application/javascript">
            document.getElementById('mensajeSM').style.display = "none";
            document.getElementById('itemSubModulos-container').style.display = "none";
            document.getElementById('itemSubModulos').value = "0";
        </script>
<?php
    }
}

if ( $_POST['opcion'] == 5 ) {
    if (!empty($_POST['modulos'])) {
        $modulos = $_POST['modulos'];
        if (!empty($_POST['subModulos'])) { $modulos = $modulos . "," . $_POST['subModulos']; }
        if (!empty($_POST['itemSubModulos'])) { $modulos = $modulos . "," . $_POST['itemSubModulos']; }

        try{
            $consultaVistas = $conexionBdSistema->query("SELECT * FROM sistema_paginas WHERE pag_id_modulo IN (".$modulos.") AND (pag_tipo_crud=2 OR pag_tipo_crud=4)");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }

        $numSM = $consultaVistas->num_rows;
        if ($numSM > 0) {
?>
            <script type="application/javascript">
                document.getElementById('mensajeP').style.display = "none";
                document.getElementById('paginas-container').style.display = "block";
            </script>
<?php
            while($paginas = mysqli_fetch_array($consultaVistas, MYSQLI_BOTH)){
                try{
                    $consultaModulos=$conexionBdAdministrativo->query("SELECT * FROM administrativo_permisos_rol WHERE perol_id_rol='".$_POST['idRol']."' AND perol_id_entidad='".$paginas['pag_id']."' AND perol_tipo='PAG'");
                } catch (Exception $e) {
                    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
                }
                $numZ = $consultaModulos->num_rows;
                $selected = $numZ > 0 ? 'selected' : '';

                echo '<option value="' . $paginas['pag_id'] . '" ' . $selected . '>' . $paginas['pag_nombre'] . '</option>';
            }
            exit();
        } else {
?>
            <script type="application/javascript">
                document.getElementById('mensajeP').style.display = "none";
                document.getElementById('paginas-container').style.display = "none";
                document.getElementById('paginas').value = "0";
            </script>
<?php
        }
    } else {
?>
        <script type="application/javascript">
            document.getElementById('mensajeP').style.display = "none";
            document.getElementById('paginas-container').style.display = "none";
            document.getElementById('paginas').value = "0";
        </script>
<?php
    }
}