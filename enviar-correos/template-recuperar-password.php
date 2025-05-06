<html>
    <body style="background-color:#FFF;">

		<div style="width: 100%; display: grid; place-content: center;">

			<div style="font-family:arial; background: blue; width:600px; color:#FFF; text-align:center; padding:15px;">
				<h3>RECUPERACIÓN DE CONTRASEÑA</h3>
			</div>

			<div style="font-family:arial; background:#FAFAFA; width:600px; color:#000; text-align:justify; padding:15px;">
				Estimado <?=$data['usuario_nombre'];?>,<br>
                Para nosotros es un placer ayudarte, entra al siguiente enlace para generar una nueva contraseña<br>
				Haga click <a href="<?=REDIRECT_ROUTE.'confirmar-password.php?idU='.base64_encode($data["usuario_id"]).'&idE='.base64_encode($data["id_empresa"]);?>">AQUI</a> para crear una nueva contraseña.
			</div>

			<div style="width:600px; color:#000; text-align:center; padding:15px;">
				¡Que tengas un excelente d&iacute;a!<br>
			</div>

        </div>
		<p>&nbsp;</p>

    <body>
<html>
    