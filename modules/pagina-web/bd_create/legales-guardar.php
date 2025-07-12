<?php
    require_once("../../sesion.php");

    $idPagina = 53;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        $conexionBdPaginaWeb->query("INSERT INTO pagina_legales(pal_nombre, pal_contenido, pal_modificacion, pal_id_empresa)VALUES('" . $_POST["nombre"] . "', '" . $_POST["contenido"] . "', now(), '".$_SESSION["idEmpresa"]."')");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }

    $idInsertU = mysqli_insert_id($conexionBdPaginaWeb);
    
	if (!empty($_FILES['documento']['name'])) {
		$destino = RUTA_PROYECTO."files/documentos";
		$fileName = subirArchivosAlServidor($_FILES['documento'], 'dlg', $destino);

        try{
            $conexionBdPaginaWeb->query("UPDATE pagina_legales SET pal_documento = '" . $fileName . "' WHERE pal_id ='" . $idInsertU . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
	}

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/legales-editar.php?id=' . $idInsertU . '";</script>';
    exit();