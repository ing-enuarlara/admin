<?php
    require_once("../../sesion.php");
	require_once(RUTA_PROYECTO . "class/Combos.php");
	require_once(RUTA_PROYECTO . "class/Combos_Productos.php");

	$idPagina = 198;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

	Combos_Productos::Delete([ 'ccp_combo' => $_GET["id"] ]);
	Combos::Delete([ 'combo_id' => $_GET["id"] ]);

	include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

	echo '<script type="text/javascript">window.location.href="../bd_read/combos.php?success=SC_2";</script>';
	exit();