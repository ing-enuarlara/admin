<?php
$consultaConfig = $conexionBdGeneral->query("SELECT * FROM configuracion
INNER JOIN ".BDADMIN.".localidad_ciudades ON ciu_id=conf_ciudad
INNER JOIN ".BDADMIN.".localidad_departamentos ON dep_id=ciu_departamento 
WHERE conf_id_empresa='".$datosUsuarioActual['usr_id_empresa']."'");
$configuracion = mysqli_fetch_array($consultaConfig, MYSQLI_BOTH);

$tipoCrud= array("", "Create", "Read", "Update", "Delete");

$formaPago = array("", "CONTADO", "CRÉDITO");
$monedas = array("","COP","USD");
$monedasExt = array("","USD","EURO");
$simbolosMonedas = array("","$","USD");