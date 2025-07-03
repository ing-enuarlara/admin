<?php
require_once("../../sesion.php");

$idPagina = 22;
include(RUTA_PROYECTO . "includes/verificar-paginas.php");
require_once(RUTA_PROYECTO . 'class/Productos.php');
require_once(RUTA_PROYECTO . 'class/Productos_Fotos.php');
require_once(RUTA_PROYECTO . 'class/Productos_Especificaciones.php');
require_once(RUTA_PROYECTO . 'class/Productos_Tallas.php');

$subCategoria = 0;
if (!empty($_POST["marca"])) {
    $subCategoria = $_POST["marca"];
}

$idInsertU = Productos::Insert([
    'cprod_nombre' => $_POST["nombre"],
    'cprod_costo' => $_POST["costo"],
    'cprod_detalles' => $_POST["detalles"],
    'cprod_exitencia' => $_POST["existencia"] ?? 0,
    'cprod_marca' => $subCategoria,
    'cprod_categoria' => $_POST["categoria"],
    'cprod_tipo' => $_POST["tipo"],
    'cprod_palabras_claves' => $_POST["paClave"],
    'cprod_id_empresa' => $_SESSION["idEmpresa"],
    'cprod_fecha_creacion' => date("Y-m-d H:i:s"),
    'cprod_especificaciones' => $_POST["especificaciones"],
    'cprod_cod_ref' => $_POST["ref"]
]);

// 1. Colores
if (!empty($_POST['especificaciones_colores'])) {
    foreach ($_POST['especificaciones_colores'] as $color) {
        Productos_Especificaciones::Insert([
            'cpt_value' => $color,
            'cpt_id_producto' => $idInsertU,
            'cpt_id_empresa' => $_SESSION["idEmpresa"],
            'cpt_tipo' => 'COLOR'
        ]);
    }
}

// 2. Tallas
if (!empty($_POST['tallas'])) {
    for ($i = 0; $i < count($_POST['tallas']); $i++) {
        $talla = trim($_POST['tallas'][$i]);
        $stock = max(0, intval($_POST['stocks'][$i]));
        if (!empty($talla) && !empty($stock)) {
            Productos_Tallas::Insert([
                'cpta_talla' => $talla,
                'cpta_stock' => $stock,
                'cpta_producto' => $idInsertU,
                'cpta_empresa' => $_SESSION["idEmpresa"]
            ]);
        }
    }
    if (!empty($_POST['stocks'])) {
        $totalStock = array_sum(array_map('intval', $_POST['stocks']));
        Productos::Update(['cprod_exitencia' => $totalStock], ['cprod_id' => $idInsertU]);
    }
}

// 3. Otras
if (!empty($_POST['otras_labels']) && !empty($_POST['otras_values'])) {
    for ($i = 0; $i < count($_POST['otras_labels']); $i++) {
        $label = trim($_POST['otras_labels'][$i]);
        $value = trim($_POST['otras_values'][$i]);
        if (!empty($label) && !empty($value)) {
            Productos_Especificaciones::Insert([
                'cpt_lebel' => $label,
                'cpt_value' => $value,
                'cpt_id_producto' => $idInsertU,
                'cpt_id_empresa' => $_SESSION["idEmpresa"],
                'cpt_tipo' => 'OTRO'
            ]);
        }
    }
}

if (!empty($_POST['tipoImg']) && (!empty($_FILES['ftProducto']['name']) || !empty($_POST['urlProducto']))) {
    if (!empty($_FILES['ftProducto']['name'])) {
        $destino = RUTA_PROYECTO . "files/productos";
        $fileName = subirArchivosAlServidor($_FILES['ftProducto'], 'ftp', $destino);
    }

    if (!empty($_POST['urlProducto'])) {
        $fileName = $_POST['urlProducto'];
    }

    Productos_Fotos::Insert([
        'cpf_id_producto' => $idInsertU,
        'cpf_fotos' => $fileName,
        'cpf_id_empresa' => $_SESSION["idEmpresa"],
        'cpf_principal' => 1,
        'cpf_tipo' => $_POST['tipoImg']
    ]);
}

include(RUTA_PROYECTO . "includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="../bd_read/productos-editar.php?id=' . $idInsertU . '";</script>';
exit();
