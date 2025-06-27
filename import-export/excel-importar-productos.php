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
			$f = $_POST["filaInicial"] > 0 ? $_POST["filaInicial"] : 3;
			$arrayTodos = [];
			$claves_validar = array('cprod_cod_ref', 'cprod_nombre');
			$sql = "INSERT INTO comercial_productos(cprod_nombre, cprod_costo, cprod_detalles, cprod_exitencia, cprod_marca, cprod_categoria, cprod_tipo, cprod_palabras_claves, cprod_cod_ref, cprod_ean_code, cprod_id_empresa) VALUES";
			
			$productosCreados      = array();
			$productosActualizados = array();
			$productosNoCreados    = array();

			$validarCategorias       = array();
			$categoriasCreados       = array();
			$categoriasExistentes    = array();
			$categoriasNoCreados     = array();

			$validarMarcas       = array();
			$marcasCreados       = array();
			$marcasExistentes    = array();
			$marcasNoCreados     = array();

			$validarTipos       = array();
			$tiposCreados       = array();
			$tiposExistentes    = array();
			$tiposNoCreados     = array();

			$contFilas = 0;
			while($f<=$numFilas){

				/*
				***************PRODUCTO********************
				*/
				$todoBien = true;

				$arrayIndividual = [
					'cprod_cod_ref'			=> $hojaActual->getCell('A'.$f)->getValue(),
					'cprod_nombre'			=> $hojaActual->getCell('B'.$f)->getValue(),
					'cprod_costo'			=> $hojaActual->getCell('C'.$f)->getValue(),
					'cprod_detalles'		=> $hojaActual->getCell('D'.$f)->getValue(),
					'cprod_exitencia'		=> $hojaActual->getCell('E'.$f)->getValue(),
					'cprod_categoria'		=> NULL,
					'cprod_marca'			=> NULL,
					'cprod_tipo'			=> NULL,
					'cprod_palabras_claves'	=> $hojaActual->getCell('I'.$f)->getValue(),
					'cprod_ean_code'		=> $hojaActual->getCell('J'.$f)->getValue(),
					
				];

				//Validamos que los campos más importantes no vengan vacios
				foreach ($claves_validar as $clave) {
					if (empty($arrayIndividual[$clave])) {
						$todoBien = false;
					}
				}

				//Si los campos están completos entonces ordenamos los datos del producto
				if($todoBien) {

					/*
					**************CATEGORIAS*******************
					*/
					$categoriaNombre = $hojaActual->getCell('F' . $f)->getValue();
					if (!empty($categoriaNombre)) {
						// Verificar si la categoría ya existe en el array $validarCategorias
						$categoriaExistenteKey = array_search($categoriaNombre, $validarCategorias);

						if ($categoriaExistenteKey !== false) {
							// Si ya existe en el array, asignar el ID correspondiente
							$arrayIndividual['cprod_categoria'] = $categoriaExistenteKey;
							$categoriasExistentes["FILA_" . $f] = $categoriaNombre;
						} else {
							// Buscar si la categoría ya existe en la base de datos
							$stmt = $conexionBdComercial->prepare("SELECT ccat_id, ccat_nombre FROM comercial_categorias WHERE ccat_nombre = ? AND ccat_id_empresa = ?");
							$stmt->bind_param("si", $categoriaNombre, $idEmpresa);
							$stmt->execute();
							$resultado = $stmt->get_result();

							if ($resultado->num_rows > 0) {
								$datosCategoriaExistente = $resultado->fetch_assoc();
								$arrayIndividual['cprod_categoria'] = $datosCategoriaExistente['ccat_id'];
								$categoriasExistentes["FILA_" . $f] = $datosCategoriaExistente['ccat_nombre'];
							} else {
								// Insertar la nueva categoría
								$stmtInsert = $conexionBdComercial->prepare("INSERT INTO comercial_categorias (ccat_nombre, ccat_id_empresa) VALUES (?, ?)");
								$stmtInsert->bind_param("si", $categoriaNombre, $idEmpresa);
								$stmtInsert->execute();
								$arrayIndividual['cprod_categoria'] = $stmtInsert->insert_id;

								$categoriasCreados["FILA_" . $f] = $categoriaNombre;
							}

							$stmt->close();

							// Agregar la categoría al array para futuras referencias
							$validarCategorias[$arrayIndividual['cprod_categoria']] = $categoriaNombre;
						}
					} else {
						$categoriasNoCreados[] = "FILA " . $f;
					}
					
					/*
					***************MARCAS********************
					*/
					$marcaNombre = $hojaActual->getCell('G' . $f)->getValue();
					if (!empty($marcaNombre)) {
						// Verificar si la marca ya existe en el array $validarMarcas
						$marcaExistenteKey = array_search($marcaNombre, $validarMarcas);

						if ($marcaExistenteKey !== false) {
							// Si ya existe en el array, asignar el ID correspondiente
							$arrayIndividual['cprod_marca'] = $marcaExistenteKey;
							$marcasExistentes["FILA_" . $f] = $marcaNombre;
						} else {
							// Buscar si la marca ya existe
							$stmt = $conexionBdComercial->prepare("SELECT cmar_id, cmar_nombre FROM comercial_marcas WHERE cmar_nombre = ? AND cmar_id_empresa = ?");
							$stmt->bind_param("si", $marcaNombre, $idEmpresa);
							$stmt->execute();
							$resultado = $stmt->get_result();
		
							if ($resultado->num_rows > 0) {
								$datosMarcaExistente = $resultado->fetch_assoc();
								$arrayIndividual['cprod_marca'] = $datosMarcaExistente['cmar_id'];
								$marcasExistentes["FILA_" . $f] = $datosMarcaExistente['cmar_nombre'];
							} else {
								// Insertar la nueva marca
								$stmtInsert = $conexionBdComercial->prepare("INSERT INTO comercial_marcas (cmar_nombre, cmar_id_empresa) VALUES (?, ?)");
								$stmtInsert->bind_param("si", $marcaNombre, $idEmpresa);
								$stmtInsert->execute();
								$arrayIndividual['cprod_marca'] = $stmtInsert->insert_id;
		
								$marcasCreados["FILA_" . $f] = $marcaNombre;
							}
		
							$stmt->close();

							// Agregar la marca al array para futuras referencias
							$validarMarcas[$arrayIndividual['cprod_marca']] = $marcaNombre;
						}
					} else {
						$marcasNoCreados[] = "FILA " . $f;
					}
					
					/*
					***************TIPO********************
					*/
					$tipoNombre = $hojaActual->getCell('H' . $f)->getValue();
					if (!empty($tipoNombre)) {
						// Verificar si el tipo ya existe en el array $validarTipos
						$tipoExistenteKey = array_search($tipoNombre, $validarTipos);

						if ($tipoExistenteKey !== false) {
							// Si ya existe en el array, asignar el ID correspondiente
							$arrayIndividual['cprod_tipo'] = $tipoExistenteKey;
							$tiposExistentes["FILA_" . $f] = $tipoNombre;
						} else {
							// Buscar si el tipo ya existe
							$stmt = $conexionBdComercial->prepare("SELECT ctipo_id, ctipo_nombre FROM comercial_marca_productos WHERE ctipo_nombre = ? AND ctipo_id_empresa = ?");
							$stmt->bind_param("si", $tipoNombre, $idEmpresa);
							$stmt->execute();
							$resultado = $stmt->get_result();
		
							if ($resultado->num_rows > 0) {
								$datosTipoExistente = $resultado->fetch_assoc();
								$arrayIndividual['cprod_tipo'] = $datosTipoExistente['ctipo_id'];
								$tiposExistentes["FILA_" . $f] = $datosTipoExistente['ctipo_nombre'];
							} else {
								// Insertar el nuevo tipo
								$stmtInsert = $conexionBdComercial->prepare("INSERT INTO comercial_marca_productos (ctipo_nombre, ctipo_id_empresa) VALUES (?, ?)");
								$stmtInsert->bind_param("si", $tipoNombre, $idEmpresa);
								$stmtInsert->execute();
								$arrayIndividual['cprod_tipo'] = $stmtInsert->insert_id;
		
								$tiposCreados["FILA_" . $f] = $tipoNombre;
							}
		
							$stmt->close();

							// Agregar el tipo al array para futuras referencias
							$validarTipos[$arrayIndividual['cprod_tipo']] = $tipoNombre;
						}
					} else {
						$tiposNoCreados[] = "FILA " . $f;
					}

					// Buscar si el producto ya existe
					$stmt = $conexionBdComercial->prepare("SELECT cprod_id, cprod_cod_ref FROM comercial_productos WHERE cprod_id_empresa = ? AND (cprod_id = ? OR cprod_cod_ref = ?)");
					$stmt->bind_param("iss", $idEmpresa, $arrayIndividual['cprod_cod_ref'], $arrayIndividual['cprod_cod_ref']);
					$stmt->execute();
					$resultado = $stmt->get_result();

					if($resultado->num_rows > 0) {

						$datosProductoExistente = $resultado->fetch_assoc();
					
						try {
							$update = [];
							$camposSet = [];
					
							if(!empty($_POST['actualizarCampo'])) {
								foreach($_POST['actualizarCampo'] as $campo) {
									switch($campo) {
										case 1:
											$update[] = $arrayIndividual['cprod_nombre'];
											$camposSet[] = "cprod_nombre = ?";
											break;
										case 2:
											$update[] = $arrayIndividual['cprod_costo'];
											$camposSet[] = "cprod_costo = ?";
											break;
										case 3:
											$update[] = $arrayIndividual['cprod_exitencia'];
											$camposSet[] = "cprod_exitencia = ?";
											break;
										case 4:
											$update[] = $arrayIndividual['cprod_categoria'];
											$camposSet[] = "cprod_categoria = ?";
											break;
										case 5:
											$update[] = $arrayIndividual['cprod_marca'];
											$camposSet[] = "cprod_marca = ?";
											break;
										case 6:
											$update[] = $arrayIndividual['cprod_tipo'];
											$camposSet[] = "cprod_tipo = ?";
											break;
										case 7:
											$update[] = $arrayIndividual['cprod_palabras_claves'];
											$camposSet[] = "cprod_palabras_claves = ?";
											break;
										case 8:
											$update[] = $arrayIndividual['cprod_detalles'];
											$camposSet[] = "cprod_detalles = ?";
											break;
									}
								}
							}
					
							if (count($camposSet) > 0) {
								// Añadimos el ID al final
								$update[] = $datosProductoExistente['cprod_id'];
					
								$sqlUpdate = "UPDATE comercial_productos SET ".implode(", ", $camposSet)." WHERE cprod_id = ?";
								$stmtUpdate = $conexionBdComercial->prepare($sqlUpdate);
								$stmtUpdate->bind_param(str_repeat("s", count($camposSet)) . "i", ...$update);
								$stmtUpdate->execute();
								$stmtUpdate->close();
					
								$productosActualizados["FILA_".$f] = $datosProductoExistente['cprod_cod_ref'];
							}
					
							$stmt->close();
					
						} catch (Exception $e) {
							echo "Excepción capturada: ".$e->getMessage();
							exit();
						}
					} else {

						$arrayTodos[$f] = $arrayIndividual;

						$existencia = !empty($arrayIndividual['cprod_exitencia']) && $arrayIndividual['cprod_exitencia'] > 0 ? $arrayIndividual['cprod_exitencia'] : 1;

						$sql .= "('".mysqli_real_escape_string($conexionBdComercial, $arrayIndividual['cprod_nombre'])."', '".$arrayIndividual['cprod_costo']."', '".mysqli_real_escape_string($conexionBdComercial, $arrayIndividual['cprod_detalles'])."', '".$existencia."', '".$arrayIndividual['cprod_marca']."', '".$arrayIndividual['cprod_categoria']."', '".$arrayIndividual['cprod_tipo']."', '".$arrayIndividual['cprod_palabras_claves']."', '".$arrayIndividual['cprod_cod_ref']."', '".$arrayIndividual['cprod_ean_code']."', {$idEmpresa}),";

						$productosCreados["FILA_".$f] = $arrayIndividual['cprod_cod_ref'];

					}
				} else {
					$productosNoCreados[] = "FILA ".$f;
				}

				$f++;
				$contFilas++;
			}
			
			$numeroProductosCreados = 0;
			if(!empty($productosCreados)){
				$numeroProductosCreados = count($productosCreados);
			}

			$numeroProductosActualizados = 0;
			if(!empty($productosActualizados)){
				$numeroProductosActualizados = count($productosActualizados);
			}

			$numeroProductosNoCreados = 0;
			if(!empty($productosNoCreados)){
				$numeroProductosNoCreados = count($productosNoCreados);
			}

			$numeroCategoriasCreados = 0;
			if(!empty($categoriasCreados)){
				$numeroCategoriasCreados = count($categoriasCreados);
			}

			$numeroCategoriasExistentes = 0;
			if(!empty($categoriasExistentes)){
				$numeroCategoriasExistentes = count($categoriasExistentes);
			}

			$numeroCategoriasNoCreados = 0;
			if(!empty($categoriasNoCreados)){
				$numeroCategoriasNoCreados = count($categoriasNoCreados);
			}

			$numeroMarcasCreados = 0;
			if(!empty($marcasCreados)){
				$numeroMarcasCreados = count($marcasCreados);
			}

			$numeroMarcasExistentes = 0;
			if(!empty($marcasExistentes)){
				$numeroMarcasExistentes = count($marcasExistentes);
			}

			$numeroMarcasNoCreados = 0;
			if(!empty($marcasNoCreados)){
				$numeroMarcasNoCreados = count($marcasNoCreados);
			}

			$numeroTiposCreados = 0;
			if(!empty($tiposCreados)){
				$numeroTiposCreados = count($tiposCreados);
			}

			$numeroTiposExistentes = 0;
			if(!empty($tiposExistentes)){
				$numeroTiposExistentes = count($tiposExistentes);
			}

			$numeroTiposNoCreados = 0;
			if(!empty($tiposNoCreados)){
				$numeroTiposNoCreados = count($tiposNoCreados);
			}

			$respuesta = [
				"summary" => "Resumen del proceso:<br>
					- Total filas leidas: {$contFilas}<br><br>
					
					- Productos creados nuevos: {$numeroProductosCreados}<br>
					- Productos que ya estaban creados y se les actualizó alguna información seleccionada: {$numeroProductosActualizados}<br>
					- Productos que les faltó algun campo obligatorio: {$numeroProductosNoCreados}<br><br>

					- Categorias creadas nuevas: {$numeroCategoriasCreados}<br>
					- Marcas creadas nuevas: {$numeroMarcasCreados}<br>
					- Tipos de productos creados nuevos: {$numeroTiposCreados}<br>
				"
			];

			$summary = http_build_query($respuesta);

			if(!empty($productosCreados) && $numeroProductosCreados > 0) {
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
			
			echo '<script type="text/javascript">window.location.href="../modules/comercial/bd_read/productos-importar.php?success=SC_11&'.$summary.'";</script>';
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
			echo '<script type="text/javascript">window.location.href="../modules/comercial/bd_read/productos-importar.php?error=ER_6&msj='.$message.'";</script>';
			exit();
		}
	}else{
		$message = "Hubo un error al cargar el archivo, porfavor intente nuevamente.";
		echo '<script type="text/javascript">window.location.href="../modules/comercial/bd_read/productos-importar.php?error=ER_6&msj=' . $message . '";</script>';
		exit();
	}	
}else{
	$message = "Este archivo no es admitido, por favor verifique que el archivo a importar sea un excel (.xlsx)";
	echo '<script type="text/javascript">window.location.href="../modules/comercial/bd_read/productos-importar.php?error=ER_6&msj='.$message.'";</script>';
	exit();
}