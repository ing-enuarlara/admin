<?php
    require_once("../../sesion.php");

    $idPagina = 57;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	if ($_FILES['ftProducto']['name'] != "") {
		$destino = RUTA_PROYECTO."files/productos";
		$fileName = subirArchivosAlServidor($_FILES['ftProducto'], 'ftp', $destino);
    
        $conexionBdComercial->query("INSERT INTO comercial_productos_fotos(cpf_id_producto, cpf_fotos, cpf_id_empresa, cpf_fecha_creacion)VALUES('" . $_POST['id'] . "', '" . $fileName . "', '" . $datosUsuarioActual['usr_id_empresa'] . "', now())");

        $idInsertU = mysqli_insert_id($conexionBdComercial);
	}else{
        echo '<script type="text/javascript">window.location.href="../bd_read/productos-fotos.php?id='.$_POST['id'].'&warning=WN_1";</script>';
        exit();
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/productos-fotos.php?id='.$_POST['id'].'&idInsertU='.$idInsertU.'&success=SC_1";</script>';
    exit();