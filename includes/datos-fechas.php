<?php
//DATOS DE FECHA ACTUAL
$fechaActual=date("Y/m/d/H/i/s");  
$valoresActual = explode ("/", $fechaActual); 
$diaActual   = $valoresActual[2];  
$mesActual = $valoresActual[1];  
$anyoActual  = $valoresActual[0];
$diasActualJuliano = gregoriantojd($mesActual, $diaActual, $anyoActual);

//DATOS FECHA BD
$bdFecha='1993-10-21';
if(!empty($fechaDF)){
  $bdFecha=$fechaDF;
}
$fechaBD=date("Y/m/d/H/i/s", strtotime($bdFecha));
$valoresBD = explode ("/", $fechaBD);
$diaBD    = $valoresBD[2];  
$mesBD  = $valoresBD[1];  
$anyoBD   = $valoresBD[0];
$diasBDJuliano = gregoriantojd($mesBD, $diaBD, $anyoBD);

//VALIDA FECHAS
if(!checkdate($mesBD, $diaBD, $anyoBD) || !checkdate($mesActual, $diaActual, $anyoActual)){
  echo 'Fecha invalida.';
  exit();
}

//OPERACION PARA SABER CUANTOS DIAS VAN
$dfDias=$diasActualJuliano - $diasBDJuliano;
$timaLineAlt = str_replace(array_keys($enEspanol), array_values($enEspanol), date("l, d \\d\\e F \\d\\e Y \\a \\l\\a\\s H:i", strtotime($bdFecha)));
$timaLine = str_replace(array_keys($enEspanol), array_values($enEspanol), date("d \\d\\e F \\a \\l\\a\\s H:i", strtotime($bdFecha)));

if($dfDias==1){
  $timaLine='Hace '.$dfDias.' Día';
}

if($dfDias>1 && $dfDias<=10){
  $timaLine='Hace '.$dfDias.' Días';
}

if($dfDias<1){
  $horaActual  = $valoresActual[3];
  $horaBD   = $valoresBD[3];

  $dfHoras=$horaActual - $horaBD;
  $timaLine=date("H:i", strtotime($bdFecha));

  if($dfHoras==1){
    $timaLine='Hace '.$dfHoras.' Hora';
  }
  
  if($dfHoras>1 && $dfHoras<=24){
    $timaLine='Hace '.$dfHoras.' Horas';
  }

  if($dfHoras<1){
    $minActual  = $valoresActual[4];
    $minBD   = $valoresBD[4];
  
    $dfMin=$minActual - $minBD;
    $timaLine='Hace '.$dfMin.' Min';

    if($dfMin<1){
      $segActual  = $valoresActual[5];
      $segBD   = $valoresBD[5];
    
      $dfSeg=$segActual - $segBD;

      if($dfSeg<1){
        $dfSeg=1;
      }
      
      $timaLine='Hace '.$dfSeg.' Seg';
    }
  }
}