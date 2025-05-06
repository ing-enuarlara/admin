<html>
    <body style="background-color:#FFF;">

		<div style="width: 100%; display: grid; place-content: center;">

			<div style="font-family:arial; background: blue; width:600px; color:#FFF; text-align:center; padding:15px;">
				<h3>NOVEDAD EVENTOS</h3>
			</div>

			<div style="font-family:arial; background:#FAFAFA; width:600px; color:#000; text-align:justify; padding:15px;">
				<p>
				Hola <b><?=$data['usuario_nombre']?></b>.<br>
				<?=$data['evento_texto']?><br><br>
				<?php if($data['evento_estado']==1){ ?>
					<b>Evento:</b> <?=$data['evento_nombre']?><br>
					<b>Fecha:</b> <?=$data['evento_fecha']?><br>
					<b>Lugar:</b> <?=$data['evento_lugar']?><br>
					<?=$data['evento_duracion']?>
					<b>Nota:</b> <?=$data['evento_nota']?><br>
					</p>
					<?php if(!empty($data['evento_enlace'])){ ?>
						Haga click <a href="<?=$data['evento_enlace']?>">AQUI</a> para ir al enlace del evento.
					<?php } ?>
				<?php } ?>
			</div>

			<div style="width:600px; color:#000; text-align:center; padding:15px;">
				¡Que tengas un excelente d&iacute;a!<br>
			</div>

        </div>
		<p>&nbsp;</p>

    <body>
<html>
    