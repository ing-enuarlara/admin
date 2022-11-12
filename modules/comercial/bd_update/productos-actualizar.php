<?php
    require_once("../../sesion.php");

    $idPagina = 24;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	if ($_FILES['foto']['name'] != "") {
		$destino = RUTA_PROYECTO."files/productos";
		$fileName = subirArchivosAlServidor($_FILES['foto'], 'pro', $destino);
    
        $conexionBdComercial->query("UPDATE comercial_productos SET cprod_foto='" . $fileName . "' WHERE cprod_id='" . $_POST["id"] . "'");
	}
    
    $conexionBdComercial->query("UPDATE comercial_productos SET cprod_nombre='" . $_POST["nombre"] . "', cprod_costo='" . $_POST["costo"] . "', cprod_detalles='" . $_POST["detalles"] . "', cprod_exitencia='" . $_POST["existencia"] . "', cprod_categoria='" . $_POST["categoria"] . "', cprod_id_empresa='" . $datosUsuarioActual['usr_id_empresa'] . "' WHERE cprod_id='" . $_POST["id"] . "'");

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/productos.php";</script>';
    exit();