<?php
include("../modules/sesion.php");

$mensajeNot = 'Hubo un error al guardar las cambios';
//Bloquear y desbloquear usuarios
if($_POST["operacion"]==1){
	try{
		$conexionBdAdministrativo->query("UPDATE administrativo_usuarios SET usr_bloqueado='".$_POST["valor"]."' WHERE usr_id='".$_POST["idR"]."'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}
	$mensajeNot = 'El usuario ha cambiado de estado correctamente.';
}
//Bloquear y desbloquear clientes
if($_POST["operacion"]==2){
	try{
		$conexionBdComercial->query("UPDATE comercial_clientes SET cli_bloqueado='".$_POST["valor"]."' WHERE cli_id='".$_POST["idR"]."'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}
	$mensajeNot = 'El cliente ha cambiado de estado correctamente.';
}
?>

<script type="text/javascript">
	function notifica(){
		$.toast({
			heading: 'Cambios guardados',  
			text: '<?=$mensajeNot;?>',
			position: 'botom-left',
			loaderBg:'#ff6849',
			icon: 'success',
			hideAfter: 3000, 
			stack: 6
		});
	}
	setTimeout ("notifica()", 100);
</script>

<?php 
if($_POST["operacion"]<3){
?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<i class="icon-exclamation-sign"></i><strong>INFORMACI&Oacute;N:</strong> <?=$mensajeNot;?>
	</div>
<?php
}

if($_POST["operacion"]==3){
?>
	<script type="text/javascript">
	setTimeout('document.location.reload()',2000);
	</script>
<?php
}
?>