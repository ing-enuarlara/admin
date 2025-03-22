<?php
include("../modules/sesion.php");

$_SESSION['id'] = $_SESSION['admin'];
$_SESSION['admin'] = '';
unset( $_SESSION["admin"] );

try{
	$rst_usr = $conexionBdAdministrativo->query("SELECT * FROM administrativo_usuarios WHERE usr_id='".$_SESSION['id']."'");
} catch (Exception $e) {
    echo "Excepción catpurada: ".$e->getMessage();
    exit();
}
$fila = mysqli_fetch_array($rst_usr, MYSQLI_BOTH);
$_SESSION["idEmpresa"] = $fila['usr_id_empresa'];
$_SESSION["datosUsuarioActual"] = $fila;

try{
	$consultaConfig = $conexionBdGeneral->query("SELECT * FROM configuracion
	LEFT JOIN ".BDADMIN.".localidad_ciudades ON ciu_id=conf_ciudad
	LEFT JOIN ".BDADMIN.".localidad_departamentos ON dep_id=ciu_departamento 
	WHERE conf_id_empresa='".$_SESSION["idEmpresa"]."'");
} catch (Exception $e) {
	include(RUTA_PROYECTO."includes/error-catch-to-report.php");
}
$_SESSION["configuracion"] = mysqli_fetch_array($consultaConfig, MYSQLI_BOTH);

header("Location:../modules/administrativo/bd_read/usuarios.php");