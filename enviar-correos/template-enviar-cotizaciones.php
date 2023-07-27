<html>
    <body style="background-color:#FFF;">

		<div style="width: 100%; display: grid; place-content: center;">

			<div style="font-family:arial; background: green; width:600px; color:#FFF; text-align:center; padding:15px;">
				<h3>COTIZACIÓN #<?= date("dmy", strtotime($resultado['cotiz_fecha_propuesta']))."-".$resultado['cotiz_id']; ?></h3>
			</div>

			<div style="font-family:arial; background:#FAFAFA; width:600px; color:#000; text-align:justify; padding:15px;">
				<?=$_POST['mensaje'];?><br>
				Haga click <a href="<?=REDIRECT_ROUTE.'modules/reportes/formato-cotizacion-1.php?cte=1&id='.base64_encode($_POST["id"]).'&idE='.base64_encode($datosUsuarioActual["usr_id_empresa"]);?>">AQUI</a> para revisar la cotización.
			</div>

			<div style="width:600px; color:#000; text-align:center; padding:15px;">
				¡Que tengas un excelente d&iacute;a!<br>
			</div>

        </div>
		<p>&nbsp;</p>

    <body>
<html>
    