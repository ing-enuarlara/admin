<?php
function subirArchivosAlServidor($archivoCargado, $prefijo, $destino)
{
	$extensionParte1 = explode(".", $archivoCargado['name']);
	$extension = end($extensionParte1);
	$nombreArchivoFinal = uniqid($prefijo . "_") . "." . $extension;
	$rutaCompleta = $destino . "/" . $nombreArchivoFinal;
	move_uploaded_file($archivoCargado['tmp_name'], $rutaCompleta);

	return $nombreArchivoFinal;
}

function validarClave($clave)
{
	$regex = "/^[a-zA-Z0-9\.\*]{8,20}$/";
	return preg_match($regex, $clave);
}

function generarClaves()
{
	return rand(10000, 99999);
}

function validarAccesoModulo($empresa, $modulo)
{

	global $conexionBdAdmin, $datosUsuarioActual;

	$consulta = $conexionBdAdmin->query("SELECT * FROM modulos_clien_admin WHERE mxca_id_cliAdmin='" . $empresa . "' AND mxca_id_modulo='" . $modulo . "'");
	$numRegistros = $consulta->num_rows;

	if ($numRegistros > 0) {
		return true;
	}

	return false;
}
