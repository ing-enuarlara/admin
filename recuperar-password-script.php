<?php
include("conexion.php");
require_once(RUTA_PROYECTO."enviar-correos/EnviarEmail.php");

$consulta= $conexionBdAdministrativo->query("SELECT * FROM administrativo_usuarios WHERE (usr_email='".$_POST["usuario"]."' || usr_login='".$_POST["usuario"]."' || usr_documento='".$_POST["usuario"]."')");
$resultado = mysqli_fetch_array($consulta, MYSQLI_BOTH);

if(!empty($resultado)){

	$data = [
		'usuario_id'         => $resultado["usr_id"],
		'usuario_email'        => $resultado['usr_email'],
		'usuario_nombre'       => $resultado['usr_nombre'],
		'id_empresa'            => $resultado["usr_id_empresa"]
	];
	$asunto = 'RECUPERA TU CONTRASEÑA';
	$bodyTemplateRoute = RUTA_PROYECTO.'enviar-correos/template-recuperar-password.php';

	EnviarEmail::enviar($data, $asunto, $bodyTemplateRoute);

  echo '<script type="text/javascript">window.location.href="index.php?RC=1";</script>';
  exit();

}else{

  echo '<script type="text/javascript">window.location.href="recuperar-password.php?RC=1";</script>';
  exit();

}