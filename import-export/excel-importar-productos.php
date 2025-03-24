<?php
include("../modules/sesion.php");
require_once(RUTA_PROYECTO . "import-export/ImportExportExcel.php");

if (!empty($_FILES['plantilla'])) {

	$temName		= $_FILES['plantilla']['tmp_name'];
	$archivo		= $_FILES['plantilla']['name'];
	$destino		= "../files/excel/";
	$explode		= explode(".", $archivo);
	$extension		= end($explode);
	$fullArchivo	= uniqid('importado_') . "." . $extension;
	$archivo		= $destino . $fullArchivo;

	if ($extension == 'xlsx') {

		if (move_uploaded_file($temName, $archivo)) {

			if ($_FILES['plantilla']['error'] === UPLOAD_ERR_OK) {

				$idEmpresa			= $_POST['idEmpresa'] ?? $_SESSION['idEmpresa'];
				$camposActualizar	= $_POST['actualizarCampo'] ?? [];

				// Mapa de columnas si quieres renombrar encabezados del excel hacia columnas de la BD
				$mapaColumnas = [
					'nombre'				=> 'cprod_nombre',
					'costo'					=> 'cprod_costo',
					'detallesdelproducto'	=> 'cprod_detalles',
					'existencia'			=> 'cprod_exitencia',
					'marca'					=> 'cprod_marca',
					'categoria'				=> 'cprod_categoria',
					'tipo'					=> 'cprod_tipo',
					'palabrasclaves'		=> 'cprod_palabras_claves',
					'cod/referencia'		=> 'cprod_cod_ref',
					'id_empresa'			=> 'cprod_id_empresa',
				];

				$resultado = ImportExportExcel::importar($archivo, 'comercial_productos', $conexionBdComercial, $mapaColumnas, $camposActualizar, $idEmpresa);

				if ($resultado) {
					echo '<script>window.location.href="../modules/comercial/bd_read/productos-importar.php?success=SC_11";</script>';
				} else {
					echo '<script>window.location.href="../modules/comercial/bd_read/productos-importar.php?error=ER_7";</script>';
				}
			} else {
				switch ($_FILES['plantilla']['error']) {
					case UPLOAD_ERR_INI_SIZE:
						$message = "El fichero subido excede la directiva upload_max_filesize de php.ini.";
						break;
					case UPLOAD_ERR_FORM_SIZE:
						$message = "El fichero subido excede la directiva MAX_FILE_SIZE especificada en el formulario HTML.";
						break;

					case UPLOAD_ERR_PARTIAL:
						$message = "El fichero fue sólo parcialmente subido.";
						break;

					case UPLOAD_ERR_NO_FILE:
						$message = "No se subió ningún fichero.";
						break;

					case UPLOAD_ERR_NO_TMP_DIR:
						$message = "Falta la carpeta temporal.";
						break;

					case UPLOAD_ERR_CANT_WRITE:
						$message = "No se pudo escribir el fichero en el disco.";
						break;
					case UPLOAD_ERR_EXTENSION:
						$message = "Una extensión de PHP detuvo la subida de ficheros. PHP no proporciona una forma de determinar la extensión que causó la parada de la subida de ficheros; el examen de la lista de extensiones cargadas con phpinfo() puede ayudar.";
						break;
				}
				echo '<script type="text/javascript">window.location.href="../modules/comercial/bd_read/productos-importar.php?error=ER_6&msj=' . $message . '";</script>';
				exit();
			}
		} else {
			$message = "Hubo un error al cargar el archivo, porfavor intente nuevamente.";
			echo '<script type="text/javascript">window.location.href="../modules/comercial/bd_read/productos-importar.php?error=ER_6&msj=' . $message . '";</script>';
			exit();
		}
	} else {
		$message = "Este archivo no es admitido, por favor verifique que el archivo a importar sea un excel (.xlsx)";
		echo '<script type="text/javascript">window.location.href="../modules/comercial/bd_read/productos-importar.php?error=ER_6&msj=' . $message . '";</script>';
		exit();
	}
} else {
	$message = "No se recibió ningún archivo.";
	echo '<script type="text/javascript">window.location.href="../modules/comercial/bd_read/productos-importar.php?error=ER_6&msj=' . $message . '";</script>';
	exit();
}
