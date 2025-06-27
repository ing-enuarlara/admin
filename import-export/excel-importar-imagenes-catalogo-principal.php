<?php
include("../modules/sesion.php");
require(RUTA_PROYECTO.'dist/librerias/Excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

$archivoZip = $_FILES['plantilla']['tmp_name'];
$nombreZip = $_FILES['plantilla']['name'];
$pathDescomprimido = RUTA_PROYECTO . 'files/temp_import_' . uniqid();
mkdir($pathDescomprimido, 0777, true);

$zip = new ZipArchive;
if ($zip->open($archivoZip) === TRUE) {
	$zip->extractTo($pathDescomprimido);
	$zip->close();
} else {
	die("No se pudo descomprimir el archivo ZIP");
}

$excelFile = null;
foreach (scandir($pathDescomprimido) as $file) {
	if (pathinfo($file, PATHINFO_EXTENSION) === 'xlsx') {
		$excelFile = $pathDescomprimido . '/' . $file;
		break;
	}
}
if (!$excelFile) {
	die("No se encontró archivo .xlsx dentro del zip.");
}

$carpetaImagenes = $pathDescomprimido . '/imagenes';
if (!is_dir($carpetaImagenes)) {
	$carpetaImagenes = $pathDescomprimido;
}

$documento = IOFactory::load($excelFile);
$totalHojas = $documento->getSheetCount();

$hojaActual = $documento->getSheet(0);
$numFilas = $_POST["filaFinal"] > 0 ? $_POST["filaFinal"] : $hojaActual->getHighestDataRow();
$idEmpresa = $_POST['idEmpresa'] ?? $_SESSION['idEmpresa'];
$letraColumnas = $hojaActual->getHighestDataColumn();
$f = $_POST["filaInicial"] > 0 ? $_POST["filaInicial"] : 2;
$arrayTodos = [];
$claves_validar = array('cpf_id_producto', 'cpf_tipo');
$sql = "INSERT INTO comercial_productos_fotos(cpf_id_producto, cpf_fotos, cpf_tipo, cpf_principal, cpf_id_empresa, cpf_fotos_prin) VALUES";

$validarProducto       = array();
$fotosCreadas      = array();
$fotosNoCreadas    = array();

if (!is_writable(RUTA_PROYECTO . 'files/productos/')) {
	error_log("ERROR: No se puede escribir en la carpeta de productos.");
}

$contFilas = 0;
while ($f <= $numFilas) {

	$todoBien = true;

	$arrayIndividual = [
		'cpf_id_producto'	=> $hojaActual->getCell('A' . $f)->getValue(),
		'cpf_fotos'			=> $hojaActual->getCell('B' . $f)->getValue(),
		'cpf_tipo'			=> $hojaActual->getCell('C' . $f)->getValue(),
	];

	foreach ($claves_validar as $clave) {
		if (empty($arrayIndividual[$clave])) {
			$todoBien = false;
		}
	}

	if ($todoBien) {
		$productoExistenteKey = array_search($arrayIndividual['cpf_id_producto'], $validarProducto);

		if ($productoExistenteKey !== false) {
			$principal = 0;
			$idProducto = $productoExistenteKey;
		} else {
			// Buscar si el producto ya existe
			$stmt = $conexionBdComercial->prepare("SELECT cprin_id FROM comercial_catalogo_principal WHERE cprin_id_empresa = ? AND (cprin_id = ? OR cprin_cod_ref = ?)");
			$stmt->bind_param("iss", $idEmpresa, $arrayIndividual['cpf_id_producto'], $arrayIndividual['cpf_id_producto']);
			$stmt->execute();
			$resultado = $stmt->get_result();
			$datosProductoExistente = $resultado->fetch_assoc();

			$idProducto = $datosProductoExistente['cprin_id'];
			$stmt->close();

			$principal = 1;
			$validarProducto[$datosProductoExistente['cprin_id']] = $arrayIndividual['cpf_id_producto'];
		}

		if (!empty($idProducto)) {
			$arrayTodos[$f] = $arrayIndividual;

			$fileName = '';
			if ($arrayIndividual['cpf_tipo'] == TIPO_URL) {
				$fileName = $arrayIndividual['cpf_fotos'];
			} elseif ($arrayIndividual['cpf_tipo'] == TIPO_IMG) {
				$nombreImg = $arrayIndividual['cpf_fotos'];
				$rutaCompleta = $carpetaImagenes . '/' . $nombreImg;

				if (file_exists($rutaCompleta)) {
					$destinoFinal = RUTA_PROYECTO . 'files/productos/' . uniqid('ftp_') . '.' . pathinfo($nombreImg, PATHINFO_EXTENSION);
					copy($rutaCompleta, $destinoFinal);
					$fileName = basename($destinoFinal);
				}
			}

			if (!empty($fileName)) {
				$sql .= "('" . $idProducto . "', '" . $fileName . "', '" . $arrayIndividual['cpf_tipo'] . "', '" . $principal . "', {$idEmpresa}, 'SI'),";
				$fotosCreadas["FILA_" . $f] = $arrayIndividual['cpf_id_producto'];
			} else {
				$fotosNoCreadas[] = "FILA " . $f . " (imagen no encontrada)";
			}
		} else {
			$fotosNoCreadas[] = "FILA " . $f;
		}
	} else {
		$fotosNoCreadas[] = "FILA " . $f;
	}

	$f++;
	$contFilas++;
}

$numeroFotosCreadas = 0;
if (!empty($fotosCreadas)) {
	$numeroFotosCreadas = count($fotosCreadas);
}

$numeroFotosNoCreadas = 0;
if (!empty($fotosNoCreadas)) {
	$numeroFotosNoCreadas = count($fotosNoCreadas);
}

$respuesta = [
	"summary" => "Resumen del proceso:<br>
					- Total filas leidas: {$contFilas}<br><br>
					
					- Fotos creadas nuevas: {$numeroFotosCreadas}<br>
					- Fotos que les faltó algun campo obligatorio o no se encontro su producto: {$numeroFotosNoCreadas}
				"
];

$summary = http_build_query($respuesta);

if (!empty($fotosCreadas) && $numeroFotosCreadas > 0) {
	$sql = substr($sql, 0, -1);
	try {
		mysqli_query($conexionBdComercial, $sql);
	} catch (Exception $e) {
		print_r($sql);
		echo "<br>Hubo un error al guardar todo los datos: " . $e->getMessage();
		exit();
	}
}
echo '<script type="text/javascript">window.location.href="../modules/comercial/bd_read/catalogo-principal-importar-fotos.php?success=SC_11&' . $summary . '";</script>';
exit();