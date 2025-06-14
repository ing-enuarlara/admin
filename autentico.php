<?php
include("conexion.php");

$urlRed = REDIRECT_ROUTE;

try{
	$rst_usrE = $conexionBdAdministrativo->query("SELECT usr_login, usr_id, usr_intentos_fallidos, usr_bloqueado FROM administrativo_usuarios WHERE (usr_login='".trim(mysqli_real_escape_string($conexionBdAdministrativo, $_POST["Usuario"]))."' AND TRIM(usr_login)!='' AND usr_login IS NOT NULL) OR (usr_email='".trim(mysqli_real_escape_string($conexionBdAdministrativo, $_POST["Usuario"]))."' AND TRIM(usr_email)!='' AND usr_email IS NOT NULL)");
} catch (Exception $e) {
    echo "Excepción catpurada: ".$e->getMessage();
    exit();
}

$numE = $rst_usrE->num_rows;
if($numE ==0 ){
	header("Location:".$urlRed."index.php?error=1&u=".$_POST["Usuario"]);
	exit();
}
$usrE = mysqli_fetch_array($rst_usrE, MYSQLI_BOTH);

if($usrE['usr_intentos_fallidos']>=3 and md5($_POST["suma"])<>$_POST["sumaReal"]){

	if($usrE['usr_bloqueado']==1){header("Location:".$urlRed."index.php?error=4");exit();}

    try{
		$conexionBdAdministrativo->query("UPDATE administrativo_usuarios SET usr_bloqueado=1 WHERE usr_id='".$usrE['usr_id']."'");
	} catch (Exception $e) {
		echo "Excepción catpurada: ".$e->getMessage();
		exit();
	}
	header("Location:".$urlRed."index.php?error=3");
	exit();
}

try{
	$rst_usr = $conexionBdAdministrativo->query("SELECT * FROM administrativo_usuarios WHERE (usr_login='".trim($_POST["Usuario"])."' OR usr_email='".trim($_POST["Usuario"])."') AND usr_clave=SHA1('".$_POST["Clave"]."')");
} catch (Exception $e) {
    echo "Excepción catpurada: ".$e->getMessage();
    exit();
}
$num = $rst_usr->num_rows;
$fila = mysqli_fetch_array($rst_usr, MYSQLI_BOTH);
if($num>0)
{
	//VERIFICAR SI EL USUARIO ESTÁ BLOQUEADO
	if($fila[6]==1){header("Location:".$urlRed."index.php?error=4");exit();}
	//INICIO SESION
	session_start();
	$_SESSION["id"] = $fila['usr_id'];
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
	if(!isset($_POST["idseg"]) or !is_numeric($_POST["idseg"])){$url = 'modules/';}
	else{$url = $urlRed.'index.php';}

    try{
		$conexionBdAdministrativo->query("UPDATE administrativo_usuarios SET usr_sesion=1, usr_ultimo_ingreso=now(), usr_intentos_fallidos=0 WHERE usr_id='".$fila[0]."'");
	} catch (Exception $e) {
		echo "Excepción catpurada: ".$e->getMessage();
		exit();
	}
	
	header("Location:".$url);	
	exit();
}else{
    try{
		$conexionBdAdministrativo->query("UPDATE administrativo_usuarios SET usr_intentos_fallidos=usr_intentos_fallidos+1 WHERE usr_id='".$usrE['usr_id']."'");
	} catch (Exception $e) {
		echo "Excepción catpurada: ".$e->getMessage();
		exit();
	}

	header("Location:".$urlRed."index.php?error=2&idseg=".$_POST["idseg"]);
	exit();
}
