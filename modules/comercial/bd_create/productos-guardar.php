<?php
    require_once("../../sesion.php");

    $idPagina = 22;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    $subCategoria=0;
    if(!empty($_POST["marca"])){
        $subCategoria=$_POST["marca"];
    }

    try{
        $conexionBdComercial->query("INSERT INTO comercial_productos(cprod_nombre, cprod_costo, cprod_detalles, cprod_exitencia, cprod_marca, cprod_categoria, cprod_tipo, cprod_palabras_claves, cprod_id_empresa, cprod_fecha_creacion)VALUES('" . $_POST["nombre"] . "', '" . $_POST["costo"] . "', '" . $_POST["detalles"] . "', '" . $_POST["existencia"] . "', '" . $subCategoria . "', '" . $_POST["categoria"] . "', '" . $_POST["tipo"] . "', '" . $_POST["paClave"] . "', '" . $datosUsuarioActual['usr_id_empresa'] . "', now())");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    $idInsertU = mysqli_insert_id($conexionBdComercial);

	if ($_FILES['ftProducto']['name'] != "") {
		$destino = RUTA_PROYECTO."files/productos";
		$fileName = subirArchivosAlServidor($_FILES['ftProducto'], 'ftp', $destino);

        try{
            $conexionBdComercial->query("INSERT INTO comercial_productos_fotos(cpf_id_producto, cpf_fotos, cpf_id_empresa, cpf_fecha_creacion, cpf_principal)VALUES('" . $idInsertU . "', '" . $fileName . "', '" . $datosUsuarioActual['usr_id_empresa'] . "', now(), 1)");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
	}

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/productos-editar.php?id=' . $idInsertU . '";</script>';
    exit();