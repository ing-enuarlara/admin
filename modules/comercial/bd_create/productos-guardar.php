<?php
    require_once("../../sesion.php");

    $idPagina = 22;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	if ($_FILES['foto']['name'] != "") {
		$destino = RUTA_PROYECTO."files/productos";
		$fileName = subirArchivosAlServidor($_FILES['foto'], 'pro', $destino);
	}
    
    $conexionBdComercial->query("INSERT INTO comercial_productos(cprod_nombre, cprod_costo, cprod_detalles, cprod_exitencia, cprod_categoria, cprod_foto, cprod_id_empresa)VALUES('" . $_POST["nombre"] . "', '" . $_POST["costo"] . "', '" . $_POST["detalles"] . "', '" . $_POST["existencia"] . "', '" . $_POST["categoria"] . "', '" . $fileName . "', '" . $datosUsuarioActual['usr_id_empresa'] . "')");

    $idInsertU = mysqli_insert_id($conexionBdComercial);

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/productos-editar.php?id=' . $idInsertU . '";</script>';
    exit();