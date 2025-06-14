<?php
    require_once("../../sesion.php");

    $idPagina = 57;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	if (!empty($_POST['tipoImg']) && (!empty($_FILES['ftProducto']['name']) || !empty($_POST['urlProducto']))) {
        if (!empty($_FILES['ftProducto']['name'])) {
            $destino = RUTA_PROYECTO."files/productos";
            $fileName = subirArchivosAlServidor($_FILES['ftProducto'], 'ftp', $destino);
        }
        
	    if (!empty($_POST['urlProducto'])) {
            $fileName = $_POST['urlProducto'];
        }
    
        try{
            $conexionBdComercial->query("INSERT INTO comercial_productos_fotos(cpf_id_producto, cpf_fotos, cpf_id_empresa, cpf_fecha_creacion, cpf_tipo)VALUES('" . $_POST['id'] . "', '" . $fileName . "', '" . $_SESSION["idEmpresa"] . "', now(), '" . $_POST['tipoImg'] . "')");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
	} else{
        echo '<script type="text/javascript">window.location.href="../bd_read/productos-fotos.php?id='.$_POST['id'].'&warning=WN_1";</script>';
        exit();
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/productos-fotos.php?id='.$_POST['id'].'&idInsertU='.$idInsertU.'&success=SC_1";</script>';
    exit();