<?php
    require_once("../../sesion.php");

    $idPagina = 84;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	if (!empty($_FILES['foto']['name'])) {
		$destino = RUTA_PROYECTO."files/logo";
		$fileName = subirArchivosAlServidor($_FILES['foto'], 'lg', $destino);

        try{
            $conexionBdGeneral->query("UPDATE configuracion SET conf_logo='" . $fileName . "' WHERE conf_id_empresa='" . $_POST["id"] . "'");
        } catch (Exception $e) {
            include(RUTA_PROYECTO."includes/error-catch-to-report.php");
        }
	}

    try{
        $conexionBdGeneral->query("UPDATE configuracion SET 
        conf_empresa='" . $_POST["nombre"] . "', 
        conf_email='" . $_POST["email"] . "', 
        conf_telefono='" . $_POST["telefono"] . "', 
        conf_ciudad='" . $_POST["ciudad"] . "', 
        conf_direccion='" . $_POST["direccion"] . "', 
        conf_observaciones_cotizaciones='" . $_POST["notaCotiz"] . "', 
        conf_observaciones_pedidos='" . $_POST["notaPedid"] . "', 
        conf_observaciones_remisiones='" . $_POST["notaRemi"] . "', 
        conf_observaciones_facturas='" . $_POST["notaFacturas"] . "', 
        conf_comision_vendedores='" . $_POST["ComisiónVendedores"] . "', 
        conf_porcentaje_clientes='" . $_POST["comisionCliente"] . "'  
        WHERE conf_id_empresa='" . $_POST["id"] . "'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }
	
	try{
		$consultaConfig = $conexionBdGeneral->query("SELECT * FROM configuracion
		LEFT JOIN ".BDADMIN.".localidad_ciudades ON ciu_id=conf_ciudad
		LEFT JOIN ".BDADMIN.".localidad_departamentos ON dep_id=ciu_departamento 
		WHERE conf_id_empresa='".$_SESSION["idEmpresa"]."'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}
	$_SESSION["configuracion"] = mysqli_fetch_array($consultaConfig, MYSQLI_BOTH);

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/configuracion-sistema.php";</script>';
    exit();