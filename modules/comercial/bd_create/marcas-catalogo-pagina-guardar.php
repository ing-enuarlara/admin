<?php
require_once("../../sesion.php");
require_once(RUTA_PROYECTO . 'class/Catalogo_Marca_pagina.php');

$idPagina = 191;
include(RUTA_PROYECTO . "includes/verificar-paginas.php");

$idMarca = $_POST['id'];
foreach ($_POST['data'] as $idCategoria => $datos) {
	$tipoImg   = trim($datos['tipoImg'] ?? '');
	$urlImg    = trim($datos['urlMarca'] ?? '');
	$concepto  = trim($datos['concepto'] ?? '');

	$tieneArchivo = !empty($_FILES['data']['name'][$idCategoria]['imgMarca']);
	$hayContenido = $tipoImg || $urlImg || $concepto || $tieneArchivo;

	if (!$hayContenido) continue;

	$registroExistente = Catalogo_Marca_pagina::Select([
		'cpmc_marca' => $idMarca,
		'cpmc_cate'  => $idCategoria
	])->fetch(PDO::FETCH_ASSOC);

	$datosGuardar = [
		'cpmc_marca'     => $idMarca,
		'cpmc_cate'      => $idCategoria,
		'cpmc_concepto'  => $concepto,
		'cpmc_tipo_img'  => $tipoImg,
		'cpmc_imagen'       => ''
	];

	if ($tipoImg === TIPO_IMG && $tieneArchivo) {
		// Procesar imagen subida
		$nombreTmp = $_FILES['data']['tmp_name'][$idCategoria]['imgMarca'];
		$nombreOriginal = $_FILES['data']['name'][$idCategoria]['imgMarca'];
		$ext = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
		$nombreFinal = uniqid("psub_") . "." . strtolower($ext);
		$rutaDestino = RUTA_PROYECTO . "files/pagina-subcate/" . $nombreFinal;

		if (move_uploaded_file($nombreTmp, $rutaDestino)) {
			$datosGuardar['cpmc_imagen'] = "files/pagina-subcate/" . $nombreFinal;
		}
	} elseif ($tipoImg === TIPO_URL && $urlImg) {
		$datosGuardar['cpmc_imagen'] = $urlImg;
	}

	if ($registroExistente) {
		Catalogo_Marca_pagina::Update($datosGuardar, [
			'cpmc_marca' => $idMarca,
			'cpmc_cate' => $idCategoria
		]);
	} else {
		Catalogo_Marca_pagina::Insert($datosGuardar);
	}
}

include(RUTA_PROYECTO . "includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="../bd_read/marcas-catalogo-pagina.php?id=' . $_POST['id'] . '&success=SC_1";</script>';
exit();