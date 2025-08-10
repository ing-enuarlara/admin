<?php
    require_once("../../sesion.php");
	require_once(RUTA_PROYECTO . "class/Combos.php");
	require_once(RUTA_PROYECTO . "class/Combos_Productos.php");

    $idPagina = 197;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    Combos::Update(
        [
            'combo_title' => mysqli_real_escape_string($conexionBdComercial, $_POST["titulo"]),
            'combo_descripcion' => mysqli_real_escape_string($conexionBdComercial, $_POST["descripcion"]),
            'combo_activo' => $_POST["estado"],
            'combo_descuento' => $_POST["desc"] ?? NULL
        ],
        ['combo_id' => $_POST["id"]]
    );

    if(!empty($_POST["productos"])){
        Combos_Productos::Delete(['ccp_combo' => $_POST["id"]]);
        foreach ($_POST["productos"] AS $producto){
            Combos_Productos::Insert([
                'ccp_combo' => $_POST["id"],
                'ccp_producto' => $producto,
                'ccp_empresa' => $_SESSION["idEmpresa"]
            ]);
        }
    } else {
        Combos_Productos::Delete(['ccp_combo' => $_POST["id"]]);
    }

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/combos.php?success=SC_3";</script>';
    exit();