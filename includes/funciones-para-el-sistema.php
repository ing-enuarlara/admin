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

function generarCodigo($longitud = 10)
{
    // Caracteres permitidos para la clave
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+=-[]{}|:;"<>,.?/';

    $clave = '';
    $num_caracteres = strlen($caracteres);

    for ($i = 0; $i < $longitud; $i++) {
        // Generar un índice aleatorio dentro del rango de caracteres permitidos
        $indice_aleatorio = rand(0, $num_caracteres - 1);

        // Agregar el carácter seleccionado a la clave
        $clave .= $caracteres[$indice_aleatorio];
    }

    return $clave;
}

function validarAccesoModulo($empresa, $modulo)
{

	global $conexionBdAdmin, $datosUsuarioActual;

	if ($datosUsuarioActual['usr_tipo']==DEV) {
		return true;
	}

	try{
		$consulta = $conexionBdAdmin->query("SELECT * FROM modulos_clien_admin WHERE mxca_id_cliAdmin='" . $empresa . "' AND mxca_id_modulo='" . $modulo . "'");
	} catch (Exception $e) {
		echo "Excepción catpurada: ".$e->getMessage();
		exit();
	}
	$numRegistros = $consulta->num_rows;

	if ($numRegistros > 0) {
		return true;
	}

	return false;
}

function validarAccesoDirectoPaginas(){
	if(empty($_SERVER['HTTP_REFERER'])){
		return false;
	}
	return true;
}