<?php
    require_once("../../sesion.php");

    $idPagina = 39;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	if ($_FILES['foto']['name'] != "") {
		$destino = RUTA_PROYECTO."files/logo";
		$fileName = subirArchivosAlServidor($_FILES['foto'], 'lg', $destino);
    
        $conexionBdPaginaWeb->query("UPDATE configuracion SET conf_logo='" . $fileName . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
	}

	if ($_FILES['banner1']['name'] != "") {
		$destino = RUTA_PROYECTO."files/banner";
		$fileName = subirArchivosAlServidor($_FILES['banner1'], 'bnr', $destino);
    
        $conexionBdPaginaWeb->query("UPDATE configuracion SET conf_primerBanner='" . $fileName . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
	}

	if ($_FILES['banner2']['name'] != "") {
		$destino = RUTA_PROYECTO."files/banner";
		$fileName = subirArchivosAlServidor($_FILES['banner2'], 'bnr', $destino);
    
        $conexionBdPaginaWeb->query("UPDATE configuracion SET conf_segundoBanner='" . $fileName . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
	}

    $conexionBdPaginaWeb->query("UPDATE configuracion SET conf_empresa='" . $_POST["nombre"] . "', conf_email='" . $_POST["email"] . "', conf_telefono='" . $_POST["telefono"] . "', conf_web='" . $_POST["web"] . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/configuracion.php";</script>';
    exit();