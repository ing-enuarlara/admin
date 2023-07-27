<?php 
include("../modules/sesion.php");
//PRODUCTOS DE LA COTIZACIÓN
if($_POST["proceso"]==1){
	$consultaProducto=mysqli_query($conexionBdComercial,"SELECT * FROM comercial_relacion_productos INNER JOIN comercial_productos ON cprod_id=czpp_producto WHERE czpp_id='".$_POST["producto"]."' ");
	$datosProducto = mysqli_fetch_array($consultaProducto, MYSQLI_BOTH);

	if($_POST["campo"]=='czpp_valor'){
		
		if($_POST["valor"]<$datosProducto['cprod_costo']){
			echo '<script type="text/javascript">alert("El precio que está otorgando es menor al registrado para este producto, el cual es de $'.number_format($datosProducto['cprod_costo'],0,".",".").'.");</script>';
			exit();	
		}
	}

	mysqli_query($conexionBdComercial,"UPDATE comercial_relacion_productos SET ".$_POST["campo"]."='".mysqli_real_escape_string($conexionBdComercial,$_POST["valor"])."' WHERE czpp_id='".$_POST["producto"]."'");
	
	//echo '<script type="text/javascript">location.reload();</script>';
}
?>

<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<i class="icon-exclamation-sign"></i><strong>Exito!</strong> Los cambios ya se guardaron y todo está bien.
</div>