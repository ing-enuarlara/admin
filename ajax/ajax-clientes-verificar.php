<?php
include("../modules/sesion.php");

if($_POST["opcion"]==1){
	try{
		$consulta=$conexionBdComercial->query("SELECT * FROM comercial_clientes WHERE cli_usuario='".trim($_POST["usuario"])."' OR cli_documento='".trim($_POST["usuario"])."'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}
	$numCliente=mysqli_num_rows($consulta);
	if($numCliente>0){
?>
<script>
	document.getElementById("btnEnviar").style.display = 'none';
</script>
<?php
		$clienteV = mysqli_fetch_array($consulta, MYSQLI_BOTH);
		echo "<span style='font-family:arial; text-align:center; color:red;'>Ya existe un cliente con este número de documento: <b><a href='clientes-editar.php?id=".$clienteV['cli_id']."'>".$clienteV['cli_nombre']."</a></b></div>";
		exit();
	}else{
?>
<script>
	document.getElementById("btnEnviar").style.display = 'block';
</script>
<?php
		echo "<span style='font-family:arial; text-align:center; color:green;'>Este documento esta disponible, puedes continuar.</div>";
		exit();
	}
}

if($_POST["opcion"]==2){
	try{
		$consulta=$conexionBdComercial->query("SELECT * FROM comercial_clientes WHERE cli_id!='".$_POST["idCliente"]."' AND (cli_usuario='".trim($_POST["usuario"])."' OR cli_documento='".trim($_POST["usuario"])."')");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}
	$numCliente=mysqli_num_rows($consulta);
	if($numCliente>0){
?>
<script>
	document.getElementById("btnEnviar").style.display = 'none';
</script>
<?php
		$clienteV = mysqli_fetch_array($consulta, MYSQLI_BOTH);
		echo "<span style='font-family:arial; text-align:center; color:red;'>Ya existe un cliente con este número de documento: <b><a href='clientes-editar.php?id=".$clienteV['cli_id']."'>".$clienteV['cli_nombre']."</a></b></div>";
		exit();
	}else{
?>
<script>
	document.getElementById("btnEnviar").style.display = 'block';
</script>
<?php
		echo "<span style='font-family:arial; text-align:center; color:green;'>Este documento esta disponible, puedes continuar.</div>";
		exit();
	}
}

if($_POST["opcion"]==3){
	try{
		$consulta=$conexionBdPrincipal->query("SELECT * FROM productos WHERE prod_referencia='".trim($_POST["idUnico"])."'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}
	$datos = mysqli_fetch_array($consulta, MYSQLI_BOTH);
	if(!empty($datos[0])){
		echo "<span style='font-family:arial; text-align:center; color:red;'>Ya existe un registro con esta Referencia: <b><a href='productos-editar.php?id=".$datos[0]."'>".$datos['prod_nombre']."</a></b></div>";
		exit();
	}else{
		echo "<span style='font-family:arial; text-align:center; color:blue;'>REFERENCIA disponible, puedes continuar.</div>";
		exit();
	}
}
?>