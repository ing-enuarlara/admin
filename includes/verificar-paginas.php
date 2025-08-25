<?php
$paso=true;
if (!validarAccesoDirectoPaginas()) {
	$rutaSalida= REDIRECT_ROUTE."modules";
	$mensaje= "Estás intentando a acceder de manera incorrecta.";
	$paso=false;
}
if (!isset($idPagina)) {
	$rutaSalida= REDIRECT_ROUTE."modules";
	$mensaje= "Falta el ID de esta página.";
	$paso=false;
}else{
    try{
		$consultaPaginaActual = $conexionBdSistema->query("SELECT * FROM sistema_paginas WHERE pag_id='" . $idPagina . "'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}
	$paginaActual = mysqli_fetch_array($consultaPaginaActual, MYSQLI_BOTH);

	if (!validarAccesoModulo($_SESSION["idEmpresa"], $paginaActual['pag_id_modulo']) || !validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], $paginaActual['pag_id_modulo']) || !validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], $idPagina, 'PAG')) {
		$rutaSalida= REDIRECT_ROUTE."modules";
		$mensaje= "La empresa NO tiene permiso a este modulo.";
		$paso=false;
	}
}
/*
PAGINAS A LAS QUE TIENE PERMISO EL ROL DEL USUARIO
$consultaPaginaUsuario = $conexionBdGeneral->query("SELECT * FROM paginas_perfiles WHERE pper_tipo_usuario='" . $_SESSION["datosUsuarioActual"][3] . "' AND pper_pagina='" . $idPagina . "'");
$numPaginaUsuario = $consultaPaginaUsuario->num_rows;


La segunda parte de la condición es para darle permiso a los administradores 
a todas las paginas del sistema.
if ($numPaginaUsuario == 0 and $_SESSION["datosUsuarioActual"][3] != 1) {
?>
	<span style='font-family:Arial; color:red;'>No tienes permiso para acceder a este pagina. Ser&aacute;s redireccionado al inicio...</samp>
		<script type="text/javascript">
			function sacar() {
				window.location.href = "../index.php";
			}
			setInterval('sacar()', 3000);
		</script>
	<?php
	exit();
}*/
if ($paso!=true) {
?>
	<!DOCTYPE html>
	<html lang="es">
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="refresh" content="2;url=<?= $rutaSalida ?>">
			<title>Redireccionando...</title>
			<style>
				html, body {
					height: 100%;
					margin: 0;
					display: flex;
					justify-content: center;
					align-items: center;
					background-color: #FAFAFA;
					/* font-family: Arial, sans-serif; */
				}

				.mensaje {
					text-align: center;
				}
			</style>
		</head>
		<body>
			<div class="mensaje">
				<img src="<?=REDIRECT_ROUTE?>files/logo/logo3.png" alt="AdminOCBLogo" width="100">
				<p><span style='font-family:Arial; font-weight:bold;'><?= $mensaje ?></samp></p>
				<p>Redireccionando en 2 segundos...</p>
			</div>
			<script>
				setTimeout(function() {
					window.location.href = '<?= $rutaSalida ?>';
				}, 2000);
			</script>
		</body>
	</html>
<?php
	exit;
}
?>