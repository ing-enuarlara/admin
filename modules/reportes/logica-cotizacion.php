<?php
if(!empty($_GET['cte'])){
	if ($_GET["cte"] == 1) {
		$_GET["id"] = base64_decode($_GET["id"]);
	} else {
		if ($_SESSION["id"] == "")
			header("Location:".RUTA_PROYECTO."/salir.php");
	}
}

$resultado = mysqli_fetch_array($conexionBdComercial->query("SELECT * FROM comercial_cotizaciones
INNER JOIN comercial_clientes ON cli_id=cotiz_cliente
INNER JOIN ".BDMODADMINISTRATIVO.".administrativo_usuarios ON usr_id=cotiz_vendedor
WHERE cotiz_id='" . $_GET["id"] . "'"), MYSQLI_BOTH);

$envio=0;
if(!empty($resultado['cotiz_envio'])){
	$envio=$resultado['cotiz_envio'];
}