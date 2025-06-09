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
			$claves_validar = array('cprin_cod_ref', 'cprin_nombre');
			$sql = "INSERT INTO comercial_catalogo_principal(cprin_nombre, cprin_costo, cprin_detalles, cprin_exitencia, cprin_marca, cprin_categoria, cprin_tipo, cprin_palabras_claves, cprin_cod_ref, cprin_ean_code, cprin_id_empresa) VALUES";
			
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
					'cprin_cod_ref'			=> $hojaActual->getCell('A'.$f)->getValue(),
					'cprin_nombre'			=> $hojaActual->getCell('B'.$f)->getValue(),
					'cprin_costo'			=> $hojaActual->getCell('C'.$f)->getValue(),
					'cprin_detalles'		=> $hojaActual->getCell('D'.$f)->getValue(),
					'cprin_exitencia'		=> $hojaActual->getCell('E'.$f)->getValue(),
					'cprin_categoria'		=> NULL,
					'cprin_marca'			=> NULL,
					'cprin_tipo'			=> NULL,
					'cprin_palabras_claves'	=> $hojaActual->getCell('I'.$f)->getValue(),
					'cprin_ean_code'		=> $hojaActual->getCell('J'.$f)->getValue(),
					
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
							$arrayIndividual['cprin_categoria'] = $categoriaExistenteKey;
							$categoriasExistentes["FILA_" . $f] = $categoriaNombre;
						} else {
							// Buscar si la categoría ya existe en la base de datos
							$stmt = $conexionBdComercial->prepare("SELECT ccatp_id, ccatp_nombre FROM comercial_categoria_catalogo_principal WHERE ccatp_nombre = ? AND ccatp_id_empresa = ?");
							$stmt->bind_param("si", $categoriaNombre, $idEmpresa);
							$stmt->execute();
							$resultado = $stmt->get_result();

							if ($resultado->num_rows > 0) {
								$datosCategoriaExistente = $resultado->fetch_assoc();
								$arrayIndividual['cprin_categoria'] = $datosCategoriaExistente['ccatp_id'];
								$categoriasExistentes["FILA_" . $f] = $datosCategoriaExistente['ccatp_nombre'];
							} else {
								// Insertar la nueva categoría
								$stmtInsert = $conexionBdComercial->prepare("INSERT INTO comercial_categoria_catalogo_principal (ccatp_nombre, ccatp_id_empresa) VALUES (?, ?)");
								$stmtInsert->bind_param("si", $categoriaNombre, $idEmpresa);
								$stmtInsert->execute();
								$arrayIndividual['cprin_categoria'] = $stmtInsert->insert_id;

								$categoriasCreados["FILA_" . $f] = $categoriaNombre;
							}

							$stmt->close();

							// Agregar la categoría al array para futuras referencias
							$validarCategorias[$arrayIndividual['cprin_categoria']] = $categoriaNombre;
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
							$arrayIndividual['cprin_marca'] = $marcaExistenteKey;
							$marcasExistentes["FILA_" . $f] = $marcaNombre;
						} else {
							// Buscar si la marca ya existe
							$stmt = $conexionBdComercial->prepare("SELECT cmarp_id, cmarp_nombre FROM comercial_marca_catalogo_principal WHERE cmarp_nombre = ? AND cmarp_id_empresa = ?");
							$stmt->bind_param("si", $marcaNombre, $idEmpresa);
							$stmt->execute();
							$resultado = $stmt->get_result();
		
							if ($resultado->num_rows > 0) {
								$datosMarcaExistente = $resultado->fetch_assoc();
								$arrayIndividual['cprin_marca'] = $datosMarcaExistente['cmarp_id'];
								$marcasExistentes["FILA_" . $f] = $datosMarcaExistente['cmarp_nombre'];
							} else {
								// Insertar la nueva marca
								$stmtInsert = $conexionBdComercial->prepare("INSERT INTO comercial_marca_catalogo_principal (cmarp_nombre, cmarp_id_empresa) VALUES (?, ?)");
								$stmtInsert->bind_param("si", $marcaNombre, $idEmpresa);
								$stmtInsert->execute();
								$arrayIndividual['cprin_marca'] = $stmtInsert->insert_id;
		
								$marcasCreados["FILA_" . $f] = $marcaNombre;
							}
		
							$stmt->close();

							// Agregar la marca al array para futuras referencias
							$validarMarcas[$arrayIndividual['cprin_marca']] = $marcaNombre;
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
							$arrayIndividual['cprin_tipo'] = $tipoExistenteKey;
							$tiposExistentes["FILA_" . $f] = $tipoNombre;
						} else {
							// Buscar si el tipo ya existe
							$stmt = $conexionBdComercial->prepare("SELECT ctipop_id, ctipop_nombre FROM comercial_tipo_catalogo_principal WHERE ctipop_nombre = ? AND ctipop_id_empresa = ?");
							$stmt->bind_param("si", $tipoNombre, $idEmpresa);
							$stmt->execute();
							$resultado = $stmt->get_result();
		
							if ($resultado->num_rows > 0) {
								$datosTipoExistente = $resultado->fetch_assoc();
								$arrayIndividual['cprin_tipo'] = $datosTipoExistente['ctipop_id'];
								$tiposExistentes["FILA_" . $f] = $datosTipoExistente['ctipop_nombre'];
							} else {
								// Insertar el nuevo tipo
								$stmtInsert = $conexionBdComercial->prepare("INSERT INTO comercial_tipo_catalogo_principal (ctipop_nombre, ctipop_id_empresa) VALUES (?, ?)");
								$stmtInsert->bind_param("si", $tipoNombre, $idEmpresa);
								$stmtInsert->execute();
								$arrayIndividual['cprin_tipo'] = $stmtInsert->insert_id;
		
								$tiposCreados["FILA_" . $f] = $tipoNombre;
							}
		
							$stmt->close();

							// Agregar el tipo al array para futuras referencias
							$validarTipos[$arrayIndividual['cprin_tipo']] = $tipoNombre;
						}
					} else {
						$tiposNoCreados[] = "FILA " . $f;
					}

					// Buscar si el producto ya existe
					$stmt = $conexionBdComercial->prepare("SELECT cprin_id, cprin_cod_ref FROM comercial_catalogo_principal WHERE cprin_id_empresa = ? AND (cprin_id = ? OR cprin_cod_ref = ?)");
					$stmt->bind_param("iss", $idEmpresa, $arrayIndividual['cprin_cod_ref'], $arrayIndividual['cprin_cod_ref']);
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
											$update[] = $arrayIndividual['cprin_nombre'];
											$camposSet[] = "cprin_nombre = ?";
											break;
										case 2:
											$update[] = $arrayIndividual['cprin_costo'];
											$camposSet[] = "cprin_costo = ?";
											break;
										case 3:
											$update[] = $arrayIndividual['cprin_exitencia'];
											$camposSet[] = "cprin_exitencia = ?";
											break;
										case 4:
											$update[] = $arrayIndividual['cprin_categoria'];
											$camposSet[] = "cprin_categoria = ?";
											break;
										case 5:
											$update[] = $arrayIndividual['cprin_marca'];
											$camposSet[] = "cprin_marca = ?";
											break;
										case 6:
											$update[] = $arrayIndividual['cprin_tipo'];
											$camposSet[] = "cprin_tipo = ?";
											break;
										case 7:
											$update[] = $arrayIndividual['cprin_palabras_claves'];
											$camposSet[] = "cprin_palabras_claves = ?";
											break;
										case 8:
											$update[] = $arrayIndividual['cprin_detalles'];
											$camposSet[] = "cprin_detalles = ?";
											break;
									}
								}
							}
					
							if (count($camposSet) > 0) {
								// Añadimos el ID al final
								$update[] = $datosProductoExistente['cprin_id'];
					
								$sqlUpdate = "UPDATE comercial_catalogo_principal SET ".implode(", ", $camposSet)." WHERE cprin_id = ?";
								$stmtUpdate = $conexionBdComercial->prepare($sqlUpdate);
								$stmtUpdate->bind_param(str_repeat("s", count($camposSet)) . "i", ...$update);
								$stmtUpdate->execute();
								$stmtUpdate->close();
					
								$productosActualizados["FILA_".$f] = $datosProductoExistente['cprin_cod_ref'];
							}
					
							$stmt->close();
					
						} catch (Exception $e) {
							echo "Excepción capturada: ".$e->getMessage();
							exit();
						}
					} else {

						$arrayTodos[$f] = $arrayIndividual;

						$existencia = !empty($arrayIndividual['cprin_exitencia']) && $arrayIndividual['cprin_exitencia'] > 0 ? $arrayIndividual['cprin_exitencia'] : 1;

						$sql .= "('".mysqli_real_escape_string($conexionBdComercial, $arrayIndividual['cprin_nombre'])."', '".$arrayIndividual['cprin_costo']."', '".$arrayIndividual['cprin_detalles']."', '".$existencia."', '".$arrayIndividual['cprin_marca']."', '".$arrayIndividual['cprin_categoria']."', '".$arrayIndividual['cprin_tipo']."', '".$arrayIndividual['cprin_palabras_claves']."', '".$arrayIndividual['cprin_cod_ref']."', '".$arrayIndividual['cprin_ean_code']."', {$idEmpresa}),";

						$productosCreados["FILA_".$f] = $arrayIndividual['cprin_cod_ref'];

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
			
			echo '<script type="text/javascript">window.location.href="../modules/comercial/bd_read/catalogo-principal-importar.php?success=SC_11&'.$summary.'";</script>';
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
			echo '<script type="text/javascript">window.location.href="../modules/comercial/bd_read/catalogo-principal-importar.php?error=ER_6&msj='.$message.'";</script>';
			exit();
		}
	}else{
		$message = "Hubo un error al cargar el archivo, porfavor intente nuevamente.";
		echo '<script type="text/javascript">window.location.href="../modules/comercial/bd_read/catalogo-principal-importar.php?error=ER_6&msj=' . $message . '";</script>';
		exit();
	}	
}else{
	$message = "Este archivo no es admitido, por favor verifique que el archivo a importar sea un excel (.xlsx)";
	echo '<script type="text/javascript">window.location.href="../modules/comercial/bd_read/catalogo-principal-importar.php?error=ER_6&msj='.$message.'";</script>';
	exit();
}