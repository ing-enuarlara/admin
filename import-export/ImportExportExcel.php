<?php
require_once($_SERVER['DOCUMENT_ROOT']."/admin/constantes.php");
require RUTA_PROYECTO.'dist/librerias/excel/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportExportExcel {

	public static function importar(
		string $rutaArchivo, 
		string $tablaDestino, 
		mysqli $conexion, 
		array $mapaColumnas = [], 
		array $camposActualizar = [], 
		int $idEmpresa = null
	) {

		try {
			$documento = IOFactory::load($rutaArchivo);
			$hoja = $documento->getActiveSheet();
			$filas = $hoja->toArray();

			// Si hay encabezado, quitarlo
			$encabezado = array_shift($filas);

			foreach ($filas as $fila) {
				$datos = [];
				
				foreach ($encabezado as $index => $nombreColumna) {
					$nombreColumna = strtolower(trim($nombreColumna));
					
					// Si se proporciona mapa de columnas, lo usa, si no, usa el nombre de la columna del Excel
					$columnaBD = $mapaColumnas[$nombreColumna] ?? $nombreColumna;
					$datos[$columnaBD] = mysqli_real_escape_string($conexion, $fila[$index]);
				}

				if (!empty($mapaColumnas['id_empresa']) && $idEmpresa !== null) {
					$datos[$mapaColumnas['id_empresa']] = $idEmpresa;
				}

				$columnas = implode(", ", array_keys($datos));
				$valores = "'" . implode("', '", $datos) . "'";

				$query = "INSERT INTO $tablaDestino ($columnas) VALUES ($valores)";
				mysqli_query($conexion, $query);
			}

			return true;

		} catch (Exception $e) {
			self::logError($e->getMessage(), $rutaArchivo);
			return false;
		}
	}

	private static function logError($mensaje, $archivo)
	{
		$rutaLog = RUTA_PROYECTO . "logs/errores_importacion.log";
		$fecha = date('Y-m-d H:i:s');
		file_put_contents($rutaLog, "[$fecha] Error en $archivo: $mensaje\n", FILE_APPEND);
	}
}