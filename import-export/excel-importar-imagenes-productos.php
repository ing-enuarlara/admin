<?php
include("../modules/sesion.php");
require(RUTA_PROYECTO.'dist/librerias/Excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

$temName=$_FILES['plantilla']['tmp_name'];
$archivo = $_FILES['plantilla']['name'];
$destino = "../files/excel/";
$explode = explode(".", $archivo);
$extension = end($explode);
$fullArchivo = uniqid('importado_').".".$extension;
$nombreArchivo= $destino.$fullArchivo;

if($extension == 'xlsx'){

	if (move_uploaded_file($temName, $nombreArchivo)) {		
		
		if ($_FILES['plantilla']['error'] === UPLOAD_ERR_OK){

			$documento= IOFactory::load($nombreArchivo);
			$totalHojas= $documento->getSheetCount();

			$hojaActual = $documento->getSheet(0);
			$numFilas = $_POST["filaFinal"] > 0 ? $_POST["filaFinal"] : $hojaActual->getHighestDataRow();
			$idEmpresa = $_POST['idEmpresa'] ?? $_SESSION['idEmpresa'];
			$letraColumnas= $hojaActual->getHighestDataColumn();
			$f = $_POST["filaInicial"] > 0 ? $_POST["filaInicial"] : 2;
			$arrayTodos = [];
			$claves_validar = array('cpf_id_producto', 'cpf_fotos');
			$sql = "INSERT INTO comercial_productos_fotos(cpf_id_producto, cpf_fotos, cpf_tipo, cpf_principal, cpf_id_empresa) VALUES";

			$validarProducto       = array();
			$fotosCreadas      = array();
			$fotosNoCreadas    = array();

			while($f<=$numFilas){

				/*
				***************FOTOS********************
				*/
				$todoBien = true;

				$arrayIndividual = [
					'cpf_id_producto'	=> $hojaActual->getCell('A'.$f)->getValue(),
					'cpf_fotos'			=> $hojaActual->getCell('B'.$f)->getValue(),
					'cpf_tipo'			=> $hojaActual->getCell('C'.$f)->getValue(),
				];

				//Validamos que los campos más importantes no vengan vacios
				foreach ($claves_validar as $clave) {
					if (empty($arrayIndividual[$clave])) {
						$todoBien = false;
					}
				}

				//Si los campos están completos entonces ordenamos los datos del producto
				if($todoBien) {
					$productoExistenteKey = array_search($arrayIndividual['cpf_id_producto'], $validarProducto);

					
					if ($productoExistenteKey !== false) {
						$principal = 0;
						$idProducto = $productoExistenteKey;
					} else {
						// Buscar si el producto ya existe
						$stmt = $conexionBdComercial->prepare("SELECT cprod_id FROM comercial_productos WHERE cprod_id_empresa = ? AND (cprod_id = ? OR cprod_cod_ref = ?)");
						$stmt->bind_param("iss", $idEmpresa, $arrayIndividual['cpf_id_producto'], $arrayIndividual['cpf_id_producto']);
						$stmt->execute();
						$resultado = $stmt->get_result();
						$datosProductoExistente = $resultado->fetch_assoc();

						$idProducto = $datosProductoExistente['cprod_id'];
						$stmt->close();

						$principal = 1;
						$validarProducto[$datosProductoExistente['cprod_id']] = $arrayIndividual['cpf_id_producto'];
					}

					$arrayTodos[$f] = $arrayIndividual;

					$sql .= "('".$idProducto."', '".$arrayIndividual['cpf_fotos']."', '".$arrayIndividual['cpf_tipo']."', '".$principal."', {$idEmpresa}),";

					$fotosCreadas["FILA_".$f] = $arrayIndividual['cpf_id_producto'];

				} else {
					$fotosNoCreadas[] = "FILA ".$f;
				}

				$f++;
			}
			
			$numeroFotosCreadas = 0;
			if(!empty($fotosCreadas)){
				$numeroFotosCreadas = count($fotosCreadas);
			}

			$numeroFotosNoCreadas = 0;
			if(!empty($fotosNoCreadas)){
				$numeroFotosNoCreadas = count($fotosNoCreadas);
			}

			$respuesta = [
				"summary" => "Resumen del proceso:<br>
					- Total filas leidas: {$numFilas}<br><br>
					
					- Fotos creadas nuevas: {$numeroFotosCreadas}<br>
					- Fotos que les faltó algun campo obligatorio: {$numeroFotosNoCreadas}
				"
			];

			$summary = http_build_query($respuesta);

			if(!empty($fotosCreadas) && $numeroFotosCreadas > 0) {
				$sql = substr($sql, 0, -1);
				try {
					mysqli_query($conexionBdComercial, $sql);
				} catch(Exception $e){
					print_r($sql);
					echo "<br>Hubo un error al guardar todo los datos: ".$e->getMessage();
					exit();
				}
			}

			if(file_exists($nombreArchivo)){
				unlink($nombreArchivo);
			}
			
			echo '<script type="text/javascript">window.location.href="../modules/comercial/bd_read/productos-importar-fotos.php?success=SC_11&'.$summary.'";</script>';
			exit();

		}else{
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
			echo '<script type="text/javascript">window.location.href="../modules/comercial/bd_read/productos-importar-fotos.php?error=ER_6&msj='.$message.'";</script>';
			exit();
		}
	}else{
		$message = "Hubo un error al cargar el archivo, porfavor intente nuevamente.";
		echo '<script type="text/javascript">window.location.href="../modules/comercial/bd_read/productos-importar-fotos.php?error=ER_6&msj=' . $message . '";</script>';
		exit();
	}	
}else{
	$message = "Este archivo no es admitido, por favor verifique que el archivo a importar sea un excel (.xlsx)";
	echo '<script type="text/javascript">window.location.href="../modules/comercial/bd_read/productos-importar-fotos.php?error=ER_6&msj='.$message.'";</script>';
	exit();
}