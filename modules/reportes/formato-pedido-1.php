<?php
$idPagina = 94;
if(!empty($_GET['cte'])){
	if ($_GET["cte"] == 1) {
		$_GET["id"] = base64_decode($_GET["id"]);
		$_SESSION["datosUsuarioActual"]["usr_id_empresa"] = base64_decode($_GET["idE"]);
	}

	session_start();
	require_once($_SERVER['DOCUMENT_ROOT']."/admin/constantes.php");

	require_once(RUTA_PROYECTO."conexion.php");
	require_once(RUTA_PROYECTO."config/config.php");
}else{
	include("../sesion.php");
	include(RUTA_PROYECTO."includes/verificar-paginas.php");
}

try{
	$resultado = mysqli_fetch_array($conexionBdComercial->query("SELECT * FROM comercial_pedidos
	INNER JOIN comercial_clientes ON cli_id=pedid_cliente
	INNER JOIN ".BDMODADMINISTRATIVO.".administrativo_usuarios ON usr_id=pedid_vendedor
	WHERE pedid_id='" . $_GET["id"] . "'"), MYSQLI_BOTH);
} catch (Exception $e) {
	include(RUTA_PROYECTO."includes/error-catch-to-report.php");
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Pedido #<?= date("dmy", strtotime($resultado['pedid_fecha_propuesta']))."-".$resultado['pedid_id']; ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<style type="text/css">
		.alinear {
			vertical-align: top;
		}
		table tbody td {
			border-right: 1px solid black;
		}
	</style>
</head>

<body style="font-family:Verdana, sans-serif; font-size:11px;">
	<div class="container">
		<div id="contenedor">
			<div class="p-2 m-2" id="encabezado">
				<div class="row mb-2">
					<div class="col-5">
						<div class="card-body">
							<h5 class="card-title" style="color: #da5c31; font-weight:bold;"><?= strtoupper($_SESSION["configuracion"]['conf_empresa']); ?></h5>
							<p class="card-text">
								<strong>DIRECCIÓN:</strong> <?= $_SESSION["configuracion"]['conf_direccion']; ?><br>
								<strong>CIUDAD:</strong> <?= $_SESSION["configuracion"]['ciu_nombre'].", ".$_SESSION["configuracion"]['dep_nombre']; ?><br>
								<strong>SITIO WEB:</strong> <a href="$_SESSION["configuracion"]['conf_web']" target="_target"><?= $_SESSION["configuracion"]['conf_web']; ?></a><br>
								<strong>CELULAR:</strong> <?= strtoupper($_SESSION["configuracion"]['conf_telefono']); ?><br>
								<strong>EMAIL:</strong> <?= strtoupper($_SESSION["configuracion"]['conf_email']); ?>
							</p>
						</div>
						<div class="card-body">
							<h5 class="card-title" style="background-color: #da5c31; color:white; font-weight:bold;">
								CLIENTE
							</h5>
							<h6 class="card-subtitle mb-1 text-muted" style="color: #da5c31; font-weight:bold;">
								<?= strtoupper($resultado['cli_nombre']); ?>
							</h6>
							<h6 class="card-subtitle mb-2 text-muted">
								<strong>NIT/CC:</strong> <?= $resultado['cli_documento']; ?>
							</h6>
							<p class="card-text">
								<strong>DIRECCIÓN:</strong> <?= $resultado['cli_direccion']; ?><br>
								<strong>EMAIL:</strong> <?= $resultado['cli_email']; ?><br>
								<strong>TELÉFONO:</strong> <?= $resultado['cli_telefono']; ?><br>
							</p>
						</div>
					</div>

					<div class="col-2">
						<div class="card-body">
							<img src="<?=REDIRECT_ROUTE.'files/logo/'.$_SESSION["configuracion"]['conf_logo']?>" width="100%">
						</div>
					</div>

					<div class="col-5 text-right">
						<div class="card-body">
							<h5 class="card-title" style="color: #da5c31; font-weight:bold;">PEDIDO #<?= date("dmy", strtotime($resultado['pedid_fecha_propuesta']))."-".$resultado['pedid_id']; ?></h5>
							<p class="card-text">
								<strong>FECHA PROPUESTA:</strong> <?= $resultado['pedid_fecha_propuesta']; ?><br>
								<strong>FECHA VENCIMIENTO:</strong> <?= $resultado['pedid_fecha_vencimiento']; ?><br>
								<strong>FORMA DE PAGO:</strong> <?= $formaPago[$resultado['pedid_forma_pago']]; ?><br>
								<strong>VENDEDOR:</strong> <?= strtoupper($resultado['usr_nombre']); ?><br>
								<strong>EMAIL:</strong> <?= strtoupper($resultado['usr_email']); ?>
							</p>
						</div>
					</div>
				</div>
			</div>
			<div style="margin: 10px; font-size: 12px;" align="center">
				<table width="100%" border="0" rules="groups" class="border border-dark rounded p-2">
					<thead align="center">
						<tr style="background-color: #da5c31; height: 50px; color: white;">
							<th>Nº</th>
							<th>&nbsp;</th>
							<th>Productos</th>
							<th>Cant.</th>
							<th width="10%">Valor Unitario</th>
							<th>IVA</th>
							<th>Dcto.</th>
							<th width="10%">VALOR TOTAL</th>
						</tr>
					</thead>
					<tbody>
						<!-- PRODUCTOS -->
						<?php
						try{
							$productos = $conexionBdComercial->query("SELECT * FROM comercial_productos 
							INNER JOIN comercial_marcas ON cmar_id=cprod_marca
							INNER JOIN comercial_categorias ON ccat_id=cmar_categoria
							INNER JOIN comercial_marca_productos ON ctipo_id=cprod_tipo
							INNER JOIN comercial_productos_fotos ON cpf_id_producto=cprod_id AND cpf_principal=1
							INNER JOIN comercial_relacion_productos ON czpp_producto=cprod_id AND czpp_tipo=2 AND czpp_cotizacion='" . $_GET["id"] . "'
							ORDER BY czpp_orden");
						} catch (Exception $e) {
							include(RUTA_PROYECTO."includes/error-catch-to-report.php");
						}
						$no=1;
						$totalIva = 0;
						$subtotal=0;
						$totalDescuento=0;
						while ($prod = mysqli_fetch_array($productos, MYSQLI_BOTH)) {
							require("logica-cotizacion-items.php");
						?>
							<tr style="height: 30px; background-color: <?= $fondo; ?>;" class="p-2">
								<td align="center"><?= $no; ?></td>
								<td align="center">
									<?php if (!empty($prod['cpf_fotos'])) { ?>
										<img src="<?= REDIRECT_ROUTE."files/productos/".$prod['cpf_fotos'] ?>" width="40">
									<?php } ?>
								</td>
								<td class="pl-2">
									<?= $prod['cprod_nombre']; ?><br>
									<span style="font-size: 9px; color: #da5c31;"><?= $prod['cprod_detalles']; ?></span><br>
									<span style="font-size: 9px; color: #da5c31;"><?= $prod['czpp_observacion']; ?></span>
								</td>
								<td align="center" class="alinear"><?= $prod['czpp_cantidad']; ?></td>
								<td align="center" class="alinear"><?= $simbolosMonedas[$resultado['pedid_moneda']]; ?><?= number_format($prod['czpp_valor'], 0, ",", "."); ?></td>
								<td align="center" class="alinear"><?= $prod['czpp_impuesto']; ?>%</td>
								<td align="center" class="alinear">
									<?= $prod['czpp_descuento']; ?>%<br>
									<?php
									if ($dcto > 0)
										echo '<span style="font-size:9px; color: blue;">$' . number_format($dcto, 0, ".", ".") . '</span>';
									?>
								</td>
								<td align="right" class="alinear pr-2"><?= $simbolosMonedas[$resultado['pedid_moneda']]; ?><?= number_format($valorTotal, 0, ",", "."); ?></td>
							</tr>
						<?php
							$no++;
						}
						$total = ($subtotal-$totalDescuento)+$totalIva;
						?>
					</tbody>
					<tfoot>
						<tr style="font-weight: bold; font-size: 13px; height: 20px;">
							<td colspan="3" rowspan="4" class="alinear p-1">
								<?php if (!empty($resultado['pedid_observaciones'])) { ?>
									<div style="height: 95px; display:block;" class="border border-dark rounded p-1">
										<b>OBSERVACIONES:</b><br>
										<span style="font-weight: normal;">
											<?= $resultado['pedid_observaciones']; ?>
										</span>
									</div>
								<?php } ?>
							</td>
							<td style="text-align: right;" colspan="3">SUBTOTAL <?= $simbolosMonedas[$resultado['pedid_moneda']]; ?></td>
							<td align="right" colspan="2" class="pr-2"><?php if (!empty($subtotal)) echo number_format($subtotal, 0, ",", "."); ?></td>
						</tr>
						<tr style="font-weight: bold; font-size: 13px; height: 20px;">
							<td style="text-align: right;" colspan="3">DESCUENTO <?= $simbolosMonedas[$resultado['pedid_moneda']]; ?></td>
							<td align="right" colspan="2" class="pr-2"><?php if (!empty($totalDescuento)) echo number_format($totalDescuento, 0, ",", "."); ?></td>
						</tr>
						<tr style="font-weight: bold; font-size: 13px; height: 20px;">
							<td style="text-align: right;" colspan="3">IVA <?= $simbolosMonedas[$resultado['pedid_moneda']]; ?></td>
							<td align="right" colspan="2" class="pr-2"><?php if (!empty($totalIva)) echo number_format($totalIva, 0, ",", "."); ?></td>
						</tr>
						<tr style="font-weight: bold; font-size: 13px; height: 20px;">
							<td style="text-align: right; background-color: #da5c31; color:white;" colspan="3">TOTAL NETO <?= $simbolosMonedas[$resultado['pedid_moneda']]; ?></td>
							<td align="right" style="background-color: #da5c31; color:white;" colspan="2" class="pr-2"><?php if (!empty($total)) echo number_format($total, 0, ",", "."); ?></td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="m-2" style="font-size: 13px;" id="pie">
				<?php if(!empty($_SESSION["configuracion"]['conf_observaciones_pedidos'])){ ?>
					<div class="border border-dark rounded">
						<h5 class="card-title p-2" style="background-color: #da5c31; color:white; font-weight:bold;">TÉRMINOS Y CONDICIONES</h5>
						<p class="card-text p-2">
							<?= $_SESSION["configuracion"]['conf_observaciones_pedidos']; ?>
						</p>
					</div>
				<?php } ?>
				<div class="mt-5 text-center">
					<p>
						Si usted tiene alguna pregunta sobre este pedido, por favor, póngase en contacto con nosotros<br>
						<?=$_SESSION["configuracion"]['conf_empresa'].", ".$_SESSION["configuracion"]['conf_telefono'].", ".$_SESSION["configuracion"]['conf_email'];?><br>
						<span style="font-weight:bold; font-size: 20px;">Gracias por hacer negocios con nosotros!</span>
					</p>
				</div>
			</div>
		</div>
	</div>
</body>
<?php
	if(empty($_GET['cte'])){
		require_once(RUTA_PROYECTO."includes/guardar-historial-acciones.php");
	}
?>
<script type="application/javascript">
	print();
</script>

</html>