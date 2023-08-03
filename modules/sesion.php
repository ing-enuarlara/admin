<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT']."/ing-enuarlara.co/admin/constantes.php");
$rutaSalidaS= REDIRECT_ROUTE."salir.php";

if( $_SESSION["id"]=="" || !is_numeric($_SESSION["id"]) ){
	header("Location:".$rutaSalidaS);
}
	
$tiempo_inicial = microtime(true);
	
require_once(RUTA_PROYECTO."conexion.php");
require_once(RUTA_PROYECTO."includes/sesion-usuario-actual.php");
require_once(RUTA_PROYECTO."config/config.php");
require_once(RUTA_PROYECTO."includes/funciones-para-el-sistema.php");