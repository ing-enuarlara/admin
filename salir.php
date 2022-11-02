<?php
session_start();
include("conexion.php");

if(isset($_SESSION["id"])){
	$query = $conexionBdGeneral->query("UPDATE usuarios SET usr_sesion=0, usr_ultima_salida=now() WHERE usr_id='".$_SESSION["id"]."'");
	if (!$query) {
		printf("Error message: %s\n", $conexionBdGeneral->error);
		exit();
	}
}

session_destroy();
header("Location:".REDIRECT_ROUTE."/index.php");
?>