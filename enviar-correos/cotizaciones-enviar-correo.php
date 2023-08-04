<?php
include("../modules/sesion.php");
require_once(RUTA_PROYECTO."enviar-correos/EnviarEmail.php");

$idPagina = 82;
include(RUTA_PROYECTO."includes/verificar-paginas.php");

$consulta= $conexionBdComercial->query("SELECT * FROM comercial_cotizaciones INNER JOIN comercial_clientes ON cli_id=cotiz_cliente INNER JOIN ".BDMODADMINISTRATIVO.".administrativo_usuarios ON usr_id=cotiz_vendedor WHERE cotiz_id='" . $_POST["id"] . "'");
$resultado = mysqli_fetch_array($consulta, MYSQLI_BOTH);

if(!empty($resultado)){

	$data = [
		'usuario_email'         => $resultado['cli_email'],
		'usuario_nombre'        => $resultado['cli_nombre'],
		'usuario2_email'        => $resultado['usr_email'],
		'usuario2_nombre'       => $resultado['usr_nombre'],
		'usuario2_nombre'       => $resultado['usr_nombre'],
		'id_cotizacion'         => $_POST["id"],
		'mensaje_cotizacion'    => $_POST['mensaje'],
		'numero_cotizacion'     => date("dmy", strtotime($resultado['cotiz_fecha_propuesta']))."-".$resultado['cotiz_id'],
		'id_empresa'            => $datosUsuarioActual["usr_id_empresa"]
	];
	$asunto = $_POST['asunto'];
	$bodyTemplateRoute = RUTA_PROYECTO.'enviar-correos/template-enviar-cotizaciones.php';

	EnviarEmail::enviar($data, $asunto, $bodyTemplateRoute);

}

include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="' . $_SERVER['HTTP_REFERER'] . '&success=SC_5";</script>';
exit();