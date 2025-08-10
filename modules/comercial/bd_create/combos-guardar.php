<?php
require_once("../../sesion.php");
require_once(RUTA_PROYECTO . "class/Combos.php");
require_once(RUTA_PROYECTO . "class/Combos_Productos.php");

$idPagina = 195;
include(RUTA_PROYECTO . "includes/verificar-paginas.php");

$idInsertU = Combos::Insert([
    'combo_title' => mysqli_real_escape_string($conexionBdComercial, $_POST["titulo"]),
    'combo_descripcion' => mysqli_real_escape_string($conexionBdComercial, $_POST["descripcion"]),
    'combo_descuento' => $_POST["desc"],
    'combo_empresa' => $_SESSION["idEmpresa"]
]);

if(!empty($_POST["productos"])){
    foreach ($_POST["productos"] AS $producto){
        Combos_Productos::Insert([
            'ccp_combo' => $idInsertU,
            'ccp_producto' => $producto,
            'ccp_empresa' => $_SESSION["idEmpresa"]
        ]);
    }
}

include(RUTA_PROYECTO . "includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="../bd_read/combos.php?idInsertU=' . $idInsertU . '&success=SC_1";</script>';
exit();
