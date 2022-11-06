<?php
$consultaConfig = $conexionBdGeneral->query("SELECT * FROM configuracion WHERE conf_id=1");
$configuracion = mysqli_fetch_array($consultaConfig, MYSQLI_BOTH);