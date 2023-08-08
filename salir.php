<?php
session_start();
include("conexion.php");

if(isset($_SESSION["id"])){
    try{
		$query = $conexionBdAdministrativo->query("UPDATE administrativo_usuarios SET usr_sesion=0, usr_ultima_salida=now() WHERE usr_id='".$_SESSION["id"]."'");
	} catch (Exception $e) {
		echo "Excepción catpurada: ".$e->getMessage();
		exit();
	}
	if (!$query) {
		printf("Error message: %s\n", $conexionBdAdministrativo->error);
		exit();
	}
}

session_destroy();
header("Location:".REDIRECT_ROUTE."index.php");