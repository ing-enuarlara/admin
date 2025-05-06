<html>
    <body style="background-color:#FFF;">

		<div style="width: 100%; display: grid; place-content: center;">

			<div style="font-family:arial; background: blue; width:600px; color:#FFF; text-align:center; padding:15px;">
				<h3>TIENES UN NUEVO MENSAJE</h3>
			</div>

			<div style="font-family:arial; background:#FAFAFA; width:600px; color:#000; text-align:justify; padding:15px;">
				<p>
					Hola, <b><?=$data['usuario_nombre']?></b>, <?=$data['remitente_nombre']?> te a enviado el siguiente mensaje por la plataforma.<br>
					<?=$data['mensaje_contenido'];?><br>
					<?php if(!empty($data['mensaje_adjunto'])){ ?>
						Haga click <a href="<?=REDIRECT_ROUTE.'files/mensajes/'.$data["mensaje_adjunto"];?>">AQUI</a> para ver el archivo adjunto.
					<?php } ?>
				</p>
			</div>

			<div style="width:600px; color:#000; text-align:center; padding:15px;">
				¡Que tengas un excelente d&iacute;a!<br>
			</div>

        </div>
		<p>&nbsp;</p>

    <body>
<html>
    